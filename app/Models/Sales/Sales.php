<?php

namespace App\Models\Sales;

use App\enums\SalesTypeEnum;
use App\Models\Payments\PaymentMethod;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'user_id',
        'payment_method_id',
        'sales_status_id',
        'sales_date',
        'confirm_date',
        'payment_date',
        'type',
        'total_price',
    ];

    protected $casts = [
        'sales_date' => 'datetime:Y-m-d H:i:s',
        'confirm_date' => 'datetime:Y-m-d H:i:s',
        'payment_date' => 'datetime:Y-m-d H:i:s',
        'total_price' => 'integer',
        'sales_status_id' => 'integer',
        'type' => SalesTypeEnum::class
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(SalesDetail::class, 'sales_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(SalesStatus::class, 'sales_status_id', 'id');
    }
}
