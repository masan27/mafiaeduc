<?php

namespace App\Models\Classes;

use App\Entities\PrivateClassEntities;
use App\enums\PrivateClassStatusEnum;
use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Mentors\Mentor;
use App\Models\Sales\Sales;
use App\Models\Sales\SalesDetail;
use App\Models\Schedules\Schedule;
use App\Models\Subjects\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
        'status' => PrivateClassStatusEnum::class,
        'total_slot' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', PrivateClassEntities::STATUS_PUBLISHED);
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

    public function sales(): HasManyThrough
    {
        return $this->hasManyThrough(Sales::class, SalesDetail::class, 'private_classes_id', 'id', 'id',
            'sales_id');
    }

    public function salesDetails(): HasMany
    {
        return $this->hasMany(SalesDetail::class, 'private_classes_id');
    }
}
