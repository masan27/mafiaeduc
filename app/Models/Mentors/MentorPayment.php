<?php

namespace App\Models\Mentors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_payment_method_id',
        'payment_id',
        'payment_status',
        'payment_amount',
        'payment_proof',
        'feedback'
    ];

    public function mentorPaymentMethod(): BelongsTo
    {
        return $this->belongsTo(MentorPaymentMethod::class);
    }
}
