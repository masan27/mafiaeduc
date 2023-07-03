<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesStatus extends Model
{
    use HasFactory;

    protected $table = 'sales_status';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];
}
