<?php

namespace App\Models\Materials;

use App\enums\StatusEnum;
use App\Helpers\FileHelper;
use App\Models\Admins\Admin;
use App\Models\Grades\Grade;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SNMP;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover_image',
        'admin_id',
        'grade_id',
        'price',
        'description',
        'total_page',
        'benefits',
        'preview_file',
        'source_file',
        'status',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];

    protected function getCoverImageAttribute(): String
    {
        $value = $this->attributes['cover_image'];
        if ($value) return FileHelper::getFileUrl($value);
        return null;
    }

    protected function getPreviewFileAttribute(): String
    {
        $value = $this->attributes['preview_file'];
        if ($value) return FileHelper::getFileUrl($value);
        return null;
    }

    protected function getSourceFileAttribute(): String
    {
        $value = $this->attributes['source_file'];
        if ($value) return FileHelper::getFileUrl($value);
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_material', 'material_id', 'user_id');
    }
}
