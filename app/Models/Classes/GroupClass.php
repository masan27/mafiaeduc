<?php

namespace App\Models\Classes;

use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Subjects\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

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
}
