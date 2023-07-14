<?php

namespace App\Models\Materials;

use App\Models\Admins\Admin;
use App\Models\Grades\Grade;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
