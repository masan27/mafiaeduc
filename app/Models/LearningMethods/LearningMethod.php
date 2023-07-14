<?php

namespace App\Models\LearningMethods;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMethod extends Model
{
    use HasFactory;

    protected $table = 'learning_methods';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
