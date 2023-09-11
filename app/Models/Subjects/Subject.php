<?php

namespace App\Models\Subjects;

use App\enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
