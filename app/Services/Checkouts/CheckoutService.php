<?php

namespace App\Services\Checkouts;

use App\Entities\FileFolderEntities;
use App\Entities\NotificationEntities;
use App\Entities\PaymentMethodEntities;
use App\Entities\PrivateClassEntities;
use App\Entities\SalesEntities;
use App\Helpers\FileHelper;
use App\Helpers\ResponseHelper;
use App\Models\Classes\GroupClass;
use App\Models\Classes\PrivateClass;
use App\Models\Materials\Material;
use App\Models\Payments\PaymentMethod;
use App\Models\Sales\Sales;
use App\Models\Sales\SalesConfirmation;
use App\Models\Sales\SalesDetail;
use App\Repository\Notifications\NotificationRepoInterface;
use App\Validators\CheckoutValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService implements CheckoutServiceInterface
{
    protected CheckoutValidator $checkoutValidator;
    protected NotificationRepoInterface $notificationRepo;

    public function __construct(CheckoutValidator $checkoutValidator, NotificationRepoInterface $notificationRepo)
    {
        $this->checkoutValidator = $checkoutValidator;
        $this->notificationRepo = $notificationRepo;
    }

    public function makeCheckout(Request $request): array
    {

        $validator = $this->checkoutValidator->validateMakeCheckout($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = $request->user()->id;
            $productId = $request->input('product_id');
            $type = $request->input('type');
            $paymentMethodId = $request->input('payment_method_id');

            switch ($type) {
                case SalesEntities::PRIVATE_CLASSES_TYPE:
                    $product = PrivateClass::find($productId);
                    break;
                case SalesEntities::GROUP_CLASSES_TYPE:
                    $product = GroupClass::find($productId);
                    break;
                case SalesEntities::MATERIALS_TYPE:
                    $product = Material::find($productId);
                    break;
            }

            if (!$product) return ResponseHelper::error('Produk tidak ditemukan');

            if ($product->status == 0) return ResponseHelper::error('Produk tidak tersedia');

            $paymentMethod = PaymentMethod::find($paymentMethodId);

            if (!$paymentMethod) return ResponseHelper::error('Metode pembayaran tidak ditemukan');

            if ($paymentMethod->status == PaymentMethodEntities::PAYMENT_METHOD_STATUS_INACTIVE) return
                ResponseHelper::error('Metode pembayaran tidak aktif');

            $subTotal = $product->price;
            $processingFee = $paymentMethod->fee;
            $totalPrice = $subTotal + $processingFee;

            $salesId = self::generateSalesId($productId, $type);

            $sales = Sales::create([
                'id' => $salesId,
                'user_id' => $userId,
                'type' => $type,
                'payment_method_id' => $paymentMethodId,
                'sales_status_id' => SalesEntities::SALES_STATUS_NOT_PAID,
                'sales_date' => Carbon::now(),
                'total_price' => $totalPrice,
            ]);

            if (!$sales) return ResponseHelper::error('Pembelian gagal dilakukan');

            $salesDetailData = [
                'sales_id' => $salesId,
                'user_id' => $userId,
                'sub_total' => $subTotal,
            ];

            switch ($type) {
                case SalesEntities::PRIVATE_CLASSES_TYPE:
                    $salesDetailData['private_classes_id'] = $productId;
                    $salesDetailData['group_classes_id'] = 0;
                    $salesDetailData['material_id'] = 0;
                    break;
                case SalesEntities::GROUP_CLASSES_TYPE:
                    $salesDetailData['group_classes_id'] = $productId;
                    $salesDetailData['private_classes_id'] = 0;
                    $salesDetailData['material_id'] = 0;
                    break;
                case SalesEntities::MATERIALS_TYPE:
                    $salesDetailData['material_id'] = $productId;
                    $salesDetailData['private_classes_id'] = 0;
                    $salesDetailData['group_classes_id'] = 0;
                    break;
            }

            SalesDetail::create($salesDetailData);

            PrivateClass::where('id', $productId)->update([
                'status' => PrivateClassEntities::STATUS_PURCHASED
            ]);

            $this->notificationRepo->createUserNotification($userId, 'Menunggu Pembayaran', 'Mohon melakukan pembayaran selama 1x24 jam',
                NotificationEntities::TYPE_ORDER, $salesId);

            $data = [
                'sales_id' => $salesId
            ];

            DB::commit();
            return ResponseHelper::success('Pembelian berhasil dilakukan', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function generateSalesId(int $productId, string $type): string
    {
        $prefix = '';

        switch ($type) {
            case SalesEntities::PRIVATE_CLASSES_TYPE:
                $prefix = SalesEntities::PRIVATE_CLASSES_TYPE_PREFIX;
                break;
            case SalesEntities::GROUP_CLASSES_TYPE:
                $prefix = SalesEntities::GROUP_CLASSES_TYPE_PREFIX;
                break;
            case SalesEntities::MATERIALS_TYPE:
                $prefix = SalesEntities::MATERIALS_TYPE_PREFIX;
                break;
        }

        $now = Carbon::now();
        // Add leading zero to day and month if necessary
        $day = str_pad($now->day, 2, '0', STR_PAD_LEFT);
        $month = str_pad($now->month, 2, '0', STR_PAD_LEFT);
        $year = substr($now->year, 2, 2);
        $salesDate = $day . $month . $year;

        // Add leading zero to hour, minute, and second if necessary
        $hour = str_pad($now->hour, 2, '0', STR_PAD_LEFT);
        $minute = str_pad($now->minute, 2, '0', STR_PAD_LEFT);
        $second = str_pad($now->second, 2, '0', STR_PAD_LEFT);
        $salesTime = $hour . $minute . $second;

        $productId = sprintf('%04d', $productId);

        $randomString = Str::upper(Str::random(2));

        return "$prefix$productId-$salesDate-$salesTime-$randomString";
    }

    public function getSalesStatusInfo($salesStatus, $salesDate): string
    {
        switch ($salesStatus) {
            case SalesEntities::SALES_STATUS_NOT_PAID:
                $status = 'Menunggu Pembayaran';
                break;
            case SalesEntities::SALES_STATUS_PROCESSING:
                $status = 'Sedang Diproses';
                break;
            case SalesEntities::SALES_STATUS_PAID:
                $status = 'Berhasil';
                break;
            case SalesEntities::SALES_STATUS_EXPIRED:
                $status = 'Kadaluarsa';
                break;
            case SalesEntities::SALES_STATUS_CANCELLED:
                $status = 'Dibatalkan';
                break;
            case SalesEntities::SALES_STATUS_NOT_PAID && Carbon::now() > $salesDate:
            default:
                $status = 'Gagal';
                break;
        }

        return $status;
    }

    public function getInvoiceDetails($salesId, Request $request): array
    {
        try {
            $userId = $request->user()->id;
            $sales = Sales::with('status', 'paymentMethod', 'details', 'user.detail')->where([
                ['id', $salesId],
                ['user_id', $userId]
            ])->first();

            if (!$sales) return ResponseHelper::notFound('Invoice tidak ditemukan');


            $expiredDate = $sales->sales_date->addDays(1)->format('Y-m-d H:i:s');

            $sales->expires_in = $expiredDate;

            $sales->failed_reason = null;

            if ($expiredDate < Carbon::now() && $sales->sales_status_id == SalesEntities::SALES_STATUS_NOT_PAID) {
                Sales::where('id', $salesId)->update([
                    'sales_status_id' => SalesEntities::SALES_STATUS_EXPIRED
                ]);

                $sales->failed_reason = 'Pembayaran tidak dilakukan dalam waktu 24 jam';
            }

            if ($sales->sales_status_id == SalesEntities::SALES_STATUS_PAID) {
                $sales->failed_reason = null;
            }

            $sales->status_info = self::getSalesStatusInfo($sales->sales_status_id, $sales->sales_date);

            $products = [];

            foreach ($sales->details as $detail) {
                if ((int)$sales->type->value === SalesEntities::PRIVATE_CLASSES_TYPE) {
                    $products[] = $detail->privateClasses->load('mentor:id,full_name,status');
                } else if ((int)$sales->type->value === SalesEntities::GROUP_CLASSES_TYPE) {
                    $products[] = $detail->groupClasses;
                } else if ((int)$sales->type->value === SalesEntities::MATERIALS_TYPE) {
                    $products[] = $detail->material;
                }
            }

            $sales->products = $products;

            return ResponseHelper::success('Berhasil mengambil invoice', $sales);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function paymentConfirmation(Request $request): array
    {
        $validator = $this->checkoutValidator->validatePaymentConfirmation($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = $request->user()->id;
            $salesId = $request->input('sales_id');
            $accountName = $request->input('account_name');
            $paymentMethodId = $request->input('payment_method_id');
            $paymentDate = $request->input('payment_date', Carbon::now());
            $paymentAmount = $request->input('amount', 0);
            $paymentProof = $request->file('proof_of_payment');

            $sales = Sales::where([
                ['id', $salesId],
                ['user_id', $userId]
            ])->first();

            if (!$sales) return ResponseHelper::error('Invoice tidak ditemukan');

            if ($sales->sales_status_id == SalesEntities::SALES_STATUS_PAID) {
                return ResponseHelper::error('Pembelian sudah dibayar');
            } else if ($sales->sales_status_id == SalesEntities::SALES_STATUS_EXPIRED) {
                return ResponseHelper::error('Pembelian sudah kadaluarsa');
            } else if ($sales->sales_status_id == SalesEntities::SALES_STATUS_CANCELLED) {
                return ResponseHelper::error('Pembelian sudah dibatalkan');
            } else if ($sales->sales_status_id == SalesEntities::SALES_STATUS_FAILED) {
                return ResponseHelper::error('Pembelian gagal');
            }

            if ($sales->sales_date->addDays(1) < Carbon::now()) {
                return ResponseHelper::error('Pembayaran sudah kadaluarsa');
            }

            if ($paymentMethodId != $sales->payment_method_id) return ResponseHelper::error('Maaf, metode pembayaran tidak sesuai');

            if ((int)$paymentAmount !== (int)$sales->total_price) return ResponseHelper::error('Maaf, Jumlah pembayaran tidak sesuai');

            $sales->sales_status_id = SalesEntities::SALES_STATUS_PROCESSING;
            $sales->confirm_date = Carbon::now();
            $sales->save();

            if ($paymentProof) {
                $folderPath = FileFolderEntities::PAYMENT_PROOF_FOLDER;
                $paymentPrefix = 'PROOF-' . $salesId;
                $path = FileHelper::uploadFile($paymentProof, $folderPath, $paymentPrefix);
            }

            SalesConfirmation::create([
                'sales_id' => $salesId,
                'payment_method_id' => $paymentMethodId,
                'account_name' => $accountName,
                'payment_date' => $paymentDate,
                'amount' => $paymentAmount,
                'proof_of_payment' => $paymentProof ? FileHelper::getFileUrl($path) : null
            ]);

            $this->notificationRepo->updateUserNotification($salesId, 'Sedang Diproses', 'Mohon menunggu konfirmasi pembayaran.',
                NotificationEntities::TYPE_ORDER);

            DB::commit();
            return ResponseHelper::success('Pembayaran berhasil dikonfirmasi');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function cancelPayment(Request $request): array
    {
        $validator = $this->checkoutValidator->validateCancelPayment($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = $request->user()->id;
            $salesId = $request->input('sales_id');

            $sales = Sales::where([
                ['id', $salesId],
                ['user_id', $userId]
            ])->first();

            if (!$sales) return ResponseHelper::error('Invoice tidak ditemukan');

            if ($sales->sales_status_id == SalesEntities::SALES_STATUS_PAID) {
                return ResponseHelper::error('Pembelian sudah dibayar');
            } else if ($sales->sales_status_id == SalesEntities::SALES_STATUS_EXPIRED) {
                return ResponseHelper::error('Pembelian sudah kadaluarsa');
            } else if ($sales->sales_status_id == SalesEntities::SALES_STATUS_CANCELLED) {
                return ResponseHelper::error('Pembelian sudah dibatalkan');
            } else if ($sales->sales_status_id == SalesEntities::SALES_STATUS_FAILED) {
                return ResponseHelper::error('Pembelian gagal');
            }

            $sales->sales_status_id = SalesEntities::SALES_STATUS_CANCELLED;
            $sales->save();

            $this->notificationRepo->updateUserNotification($salesId, 'Pembayaran Dibatalkan', 'Pembelian dibatalkan oleh pengguna',
                NotificationEntities::TYPE_ORDER);

            DB::commit();
            return ResponseHelper::success('Pembelian berhasil dibatalkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}
