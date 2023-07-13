<?php

namespace App\Models\Schedules;

use App\Models\Classes\GroupClass;
use App\Models\Classes\PrivateClass;
use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Mentors\Mentor;
use App\Models\Subjects\Subject;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_method_id',
        'private_classes_id',
        'group_classes_id',
        'mentor_id',
        'grade_id',
        'subject_id',
        'meeting_link',
        'meeting_platform',
        'address',
        'date',
        'time',
    ];

    protected $casts = [
        'date' => 'date:d F Y',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_schedule', 'schedule_id', 'user_id');
    }

    public function learningMethod(): BelongsTo
    {
        return $this->belongsTo(LearningMethod::class);
    }

    public function privateClass(): BelongsTo
    {
        return $this->belongsTo(PrivateClass::class);
    }

    public function groupClass(): BelongsTo
    {
        return $this->belongsTo(GroupClass::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
