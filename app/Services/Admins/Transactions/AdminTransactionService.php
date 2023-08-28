<?php

namespace App\Services\Admins\Transactions;

use App\Entities\NotificationEntities;
use App\Entities\SalesEntities;
use App\Helpers\ResponseHelper;
use App\Models\Sales\Sales;
use App\Repository\Notifications\NotificationRepoInterface;
use App\Validators\TransactionValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminTransactionService implements AdminTransactionServiceInterface
{
    protected TransactionValidator $transactionValidator;
    protected NotificationRepoInterface $notificationRepo;

    public function __construct(TransactionValidator $transactionValidator, NotificationRepoInterface $notificationRepo)
    {
        $this->transactionValidator = $transactionValidator;
        $this->notificationRepo = $notificationRepo;
    }

    public function getAllTransactions(): array
    {
        try {
            $type = request()->query('type', 'all');

            switch ($type) {
                case 'pending':
                    $transactions = Sales::with('user.detail', 'status')->where('sales_status_id',
                        SalesEntities::SALES_STATUS_NOT_PAID)->get();
                    break;
                case 'process':
                    $transactions = Sales::with('user.detail', 'status')->where('sales_status_id', SalesEntities::SALES_STATUS_PROCESSING)->get();
                    break;
                case 'paid':
                    $transactions = Sales::with('user.detail', 'status')->where('sales_status_id', SalesEntities::SALES_STATUS_PAID)->get();
                    break;
                case 'expired':
                    $transactions = Sales::with('user.detail', 'status')->where('sales_status_id', SalesEntities::SALES_STATUS_EXPIRED)->get();
                    break;
                case 'cancelled':
                    $transactions = Sales::with('user.detail', 'status')->where('sales_status_id', SalesEntities::SALES_STATUS_CANCELLED)->get();
                    break;
                case 'failed':
                    $transactions = Sales::with('user.detail', 'status')->where('sales_status_id',
                        SalesEntities::SALES_STATUS_FAILED)->get();
                    break;
                default:
                    $transactions = Sales::with('user.detail', 'status')->get();
                    break;
            }

            if ($transactions->isEmpty()) {
                return ResponseHelper::notFound('Tidak ada transaksi yang berlangsung');
            }

            return ResponseHelper::success('Berhasil mengambil data transaksi', $transactions);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getTransactionDetails(string $salesId): array
    {
        try {
            $transaction = Sales::with('user.detail', 'status', 'details', 'paymentMethod')->find
            ($salesId);

            if (!$transaction) {
                return ResponseHelper::notFound('Transaksi tidak ditemukan');
            }


            $transaction->status_info = self::getSalesStatusInfo($transaction->sales_status_id);

            $products = [];

            if ($transaction->type == SalesEntities::PRIVATE_CLASSES_TYPE) {
                foreach ($transaction->details as $detail) {
                    $products[] = $detail->privateClasses;
                }
            } else if ($transaction->type == SalesEntities::GROUP_CLASSES_TYPE) {
                foreach ($transaction->details as $detail) {
                    $products[] = $detail->groupClasses;
                }
            } else if ($transaction->type == SalesEntities::MATERIALS_TYPE) {
                foreach ($transaction->details as $detail) {
                    $products[] = $detail->material;
                }
            }

            $transaction->products = $products;

            return ResponseHelper::success('Berhasil mengambil data transaksi', $transaction);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }

    }

    public function getSalesStatusInfo($salesStatus): string
    {
        $status = '';

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
            default:
                $status = 'Gagal';
                break;
        }

        return $status;
    }

    public function confirmTransaction(Request $request): array
    {
        $validator = $this->transactionValidator->validateSalesId($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $salesId = $request->input('sales_id');

            $sales = Sales::find($salesId);

            if (!$sales) return ResponseHelper::error('Transaksi tidak ditemukan');

            $userId = $sales->user_id;

            $transactionType = $sales->type;

            switch ($transactionType) {
                case SalesEntities::PRIVATE_CLASSES_TYPE:
                    foreach ($sales->details as $detail) {
                        foreach ($detail->privateClasses->schedules as $schedule) {
                            $schedule->users()->attach($userId);
                        }
                    }
                    break;
                case SalesEntities::GROUP_CLASSES_TYPE:
                    foreach ($sales->details as $detail) {
                        foreach ($detail->groupClasses->schedules as $schedule) {
                            $schedule->users()->attach($userId);
                        }
                    }
                    break;
                case SalesEntities::MATERIALS_TYPE:
                    foreach ($sales->details as $detail) {
                        $detail->material->users()->attach($userId);
                    }
                    break;
            }

            $sales->sales_status_id = SalesEntities::SALES_STATUS_PAID;
            $sales->payment_date = Carbon::now();
            $sales->save();

            $this->notificationRepo->createUserNotification($userId, 'Pembayaran Berhasil',
                'Pembayaran Anda berhasil, silahkan cek status pembayaran Anda di halaman transaksi',
                NotificationEntities::TYPE_PAYMENT, $salesId);

            DB::commit();
            return ResponseHelper::success('Berhasil mengkonfirmasi transaksi');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}
