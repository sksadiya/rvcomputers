<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productAttribute extends Model
{
    use HasFactory;
    protected $table = 'product_attribute';
    protected $fillable = ['product_id' ,'attribute_id' ,'attribute_value_id'];
   
}
