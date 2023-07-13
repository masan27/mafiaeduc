<?php

namespace App\Models\Mentors;

use App\Models\Classes\PrivateClass;
use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grade_id',
        'learning_method_id',
        'full_name',
        'photo',
        'certificate',
        'identity_card',
        'cv',
        'teaching_video',
        'phone',
        'salary',
        'status',
        'linkedin',
    ];

    protected $casts = [
        'salary' => 'integer',
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function learningMethod(): BelongsTo
    {
        return $this->belongsTo(LearningMethod::class);
    }

    public function privateClasses(): HasMany
    {
        return $this->hasMany(PrivateClass::class);
    }
}
