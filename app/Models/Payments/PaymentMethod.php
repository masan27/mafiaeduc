<?php

namespace App\Models\Payments;

use App\Entities\PaymentMethodEntities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'name',
        'icon',
        'code',
        'type',
        'status',
        'description',
        'fee',
        'account_number',
    ];

    protected $casts = [
        'fee' => 'integer',
        'status' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', PaymentMethodEntities::PAYMENT_METHOD_STATUS_ACTIVE);
    }
}
