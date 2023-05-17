<?php

namespace App\Models\Mentors;

use App\Models\Payments\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorPaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'mentor_payment_methods';

    protected $fillable = [
        'mentor_id',
        'payment_method_id',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
