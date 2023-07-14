<?php

namespace App\Services\Reviews;

use App\Entities\SalesEntities;
use App\Helpers\ResponseHelper;
use App\Models\Reviews\Review;
use App\Models\Sales\Sales;
use App\Validators\ReviewValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewService implements ReviewServiceInterface
{
    protected ReviewValidator $reviewValidator;

    public function __construct(ReviewValidator $reviewValidator)
    {
        $this->reviewValidator = $reviewValidator;
    }

    public function addTransactionReview(Request $request): array
    {
        $validator = $this->reviewValidator->validateAddTransactionReview($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $salesId = $request->input('sales_id');
            $rating = $request->input('rating');
            $comment = $request->input('comment');

            $sales = Sales::with('details')->find($salesId);

            if (!$sales) return ResponseHelper::error('Sales ID tidak ditemukan');

            if ($sales->feedback) return ResponseHelper::error('Pembelian telah direview');

            $type = substr($salesId, 1, 2);

            switch ($type) {
                case  SalesEntities::PRIVATE_CLASSES_TYPE_PREFIX:
                    $type = SalesEntities::PRIVATE_CLASSES_TYPE;

                    foreach ($sales->details->privateClasses as $detail) {
                        Review::create([
                            'sales_id' => $salesId,
                            'user_id' => $userId,
                            'mentor_id' => $detail->mentor_id,
                            'private_classes_id' => $detail->private_classes_id,
                            'type' => $type,
                            'rating' => $rating,
                            'comment' => $comment,
                        ]);
                    }

                    break;
                case  SalesEntities::GROUP_CLASSES_TYPE_PREFIX:
                    $type = SalesEntities::GROUP_CLASSES_TYPE;

                    foreach ($sales->details as $detail) {
                        Review::create([
                            'sales_id' => $salesId,
                            'user_id' => $userId,
                            'group_classes_id' => $detail->group_classes_id,
                            'type' => $type,
                            'rating' => $rating,
                            'comment' => $comment,
                        ]);
                    }
                    break;
                case  SalesEntities::MATERIALS_TYPE_PREFIX:
                    $type = SalesEntities::MATERIALS_TYPE;

                    foreach ($sales->details as $detail) {
                        Review::create([
                            'sales_id' => $salesId,
                            'user_id' => $userId,
                            'material_id' => $detail->material_id,
                            'type' => $type,
                            'rating' => $rating,
                            'comment' => $comment,
                        ]);
                    }
                    break;
            }

            $sales->feedback = 1;
            $sales->save();

            DB::commit();
            return ResponseHelper::success('Berhasil memberikan reviews');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }

    }
}
