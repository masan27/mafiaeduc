<?php

namespace App\Models\Mentors;

use App\enums\MentorStatusEnum;
use App\Helpers\FileHelper;
use App\Models\Classes\PrivateClass;
use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Schedules\Schedule;
use App\Models\Subjects\Subject;
use App\Models\Users\User;
use App\Models\Users\UserDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'status' => MentorStatusEnum::class
    ];

    // APPENDS
    protected $appends = ['photo_url'];

    protected function getPhotoUrlAttribute(): String
    {
        $value = $this->attributes['photo'];
        if ($value) return FileHelper::getFileUrl($value);
        return null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userDetail(): BelongsTo
    {
        return $this->belongsTo(UserDetail::class, 'user_id', 'user_id');
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

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'mentor_subjects');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function credentials(): HasOne
    {
        return $this->hasOne(MentorCredentials::class);
    }

    public function paymentMethod(): HasMany
    {
        return $this->hasMany(MentorPaymentMethod::class);
    }
}
