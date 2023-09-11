<?php

namespace App\Models\Admins;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return (int)$this->status === 1;
    }
}
