<?php

namespace App\Models\Reviews;

use App\Models\Sales\Sales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'user_id',
        'mentor_id',
        'private_classes_id',
        'material_id',
        'group_classes_id',
        'type',
        'rating',
        'comment',
    ];

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }
}
