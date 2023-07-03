<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesConfirmation extends Model
{
    use HasFactory;

    protected $table = 'sales_confirmations';
    protected $primaryKey = 'sales_id';

    protected $fillable = [
        'sales_id',
        'payment_method_id',
        'account_name',
        'payment_date',
        'amount',
        'proof_of_payment',
    ];
}
