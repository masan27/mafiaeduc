<?php

namespace App\Models\Classes;

use App\Models\LearningMethods\LearningMethod;
use App\Models\Mentors\Mentor;
use App\Models\Subjects\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivateClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'subject_id',
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
        'learning_method_id' => 'integer',
        'status' => 'boolean',
        'total_slot' => 'integer',
    ];

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
}
