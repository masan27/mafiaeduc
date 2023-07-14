<?php

namespace App\Models\Classes;

use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Mentors\Mentor;
use App\Models\Schedules\Schedule;
use App\Models\Subjects\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrivateClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'subject_id',
        'grade_id',
        'learning_method_id',
        'description',
        'address',
        'price',
        'total_slot',
        'status',
    ];

    protected $casts = [
        'price' => 'integer',
        'subject_id' => 'integer',
        'grade_id' => 'integer',
        'learning_method_id' => 'integer',
        'status' => 'boolean',
        'total_slot' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function learningMethod(): BelongsTo
    {
        return $this->belongsTo(LearningMethod::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'private_classes_id');
    }
}
