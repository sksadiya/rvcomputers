<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productColor extends Model
{
    use HasFactory;
    protected $table = 'product_color';
    protected $fillable = ['product_id' ,'color_id'];
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    // Relation to the Product table
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
