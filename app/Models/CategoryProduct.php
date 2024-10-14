<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $table = 'category_product';
    protected $fillable = ['product_id' ,'category_id'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class ,'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
