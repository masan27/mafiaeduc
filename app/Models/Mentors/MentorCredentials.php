<?php

namespace App\Models\Mentors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class MentorCredentials extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'mentor_id';

    protected $fillable = [
        'mentor_id',
        'email',
        'password',
        'api_token',
        'remember_token',
        'default_password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'created_at',
        'updated_at',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }
}
