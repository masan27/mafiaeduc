<?php

namespace App\Models\Classes;

use App\enums\StatusEnum;
use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Schedules\Schedule;
use App\Models\Subjects\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'grade_id',
        'subject_id',
        'learning_method_id',
        'description',
        'additional_info',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'integer',
        'grade_id' => 'integer',
        'subject_id' => 'integer',
        'learning_method_id' => 'integer',
        'status' => StatusEnum::class
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function learningMethod(): BelongsTo
    {
        return $this->belongsTo(LearningMethod::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'group_classes_id');
    }
}
