<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentSettings extends Model
{
    use HasFactory;
    protected $table = 'payment_settings';
    protected $fillable = ['key' ,'value'];
}
