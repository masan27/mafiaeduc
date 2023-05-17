<?php

namespace App\Models\PasswordResets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    protected $fillable = [
        'user_id',
        'otp',
        'expired_at',
    ];
}
