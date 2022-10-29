<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiConversiosModel extends Model
{
    use HasFactory;
    protected $fillable = ['currency_from', 'currency_to', 'amount_to_convert', 'converted_amount', 'rate'];
}
