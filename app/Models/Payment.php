<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $fillable = [
        'payment_id',
        'product_name',
        'quantity',
        'amount',
        'price',
        'currency',
        'payer_name',
        'payer_email',
        'status',
        'method',
    ];}
