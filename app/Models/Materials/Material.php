<?php

namespace App\Models\Materials;

use App\Models\Admins\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
