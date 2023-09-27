<?php

namespace App\Models\Sales;

use App\Models\Classes\GroupClass;
use App\Models\Classes\PrivateClass;
use App\Models\Grades\Grade;
use App\Models\LearningMethods\LearningMethod;
use App\Models\Materials\Material;
use App\Models\Mentors\Mentor;
use App\Models\Schedules\Schedule;
use App\Models\Subjects\Subject;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class SalesDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'user_id',
        'material_id',
        'private_classes_id',
        'group_classes_id',
        'sub_total',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'sub_total' => 'integer',
        'sales_id' => 'string',
        'user_id' => 'integer',
        'material_id' => 'integer',
        'private_classes_id' => 'integer',
        'group_classes_id' => 'integer',
    ];

    // APPENDS
    protected $appends = ['products', 'type_product'];


    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ! Deprecated
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    // ! Deprecated
    public function privateClasses(): BelongsTo
    {
        return $this->belongsTo(PrivateClass::class, 'private_classes_id');
    }

    // ! Deprecated
    public function groupClasses(): BelongsTo
    {
        return $this->belongsTo(GroupClass::class);
    }

    public function privateClassSchedule(): HasOneThrough
    {
        return $this->hasOneThrough(Schedule::class, PrivateClass::class, 'id', 'private_classes_id', 'private_classes_id', 'id');
    }

    public function groupClassSchedule(): HasOneThrough
    {
        return $this->hasOneThrough(Schedule::class, GroupClass::class, 'id', 'group_classes_id', 'group_classes_id', 'id');
    }

    public function learningMethod(): BelongsTo
    {
        return $this->belongsTo(LearningMethod::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    protected function getProductsAttribute(): array
    {
        $products = [];

        if ($this->attributes['material_id']) {
            $data = Material::find($this->attributes['material_id']);
            if($data) {array_push($products, $data);}
        }
        if ($this->attributes['private_classes_id']) {
            $data = PrivateClass::with('mentor')->find($this->attributes['private_classes_id']);
            if($data) {array_push($products, $data);}
        }
        if ($this->attributes['group_classes_id']) {
            $data = GroupClass::find($this->attributes['group_classes_id']);
            if($data) {array_push($products, $data);}
        }
        return $products;
    }

    protected function getTypeProductAttribute(): String
    {
        $type = null;

        if ($this->attributes['material_id']) {
            $type = 'Materi';
        }
        if ($this->attributes['private_classes_id']) {
            $type = 'Kelas Private';
        }
        if ($this->attributes['group_classes_id']) {
            $type = 'Kelas Belajar';
        }
        return $type;
    }
}
