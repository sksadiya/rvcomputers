<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = 'product_variants'; // Specify the table name

    protected $fillable = [
        'product_id', 
        'variant_name', 
        'variant_price', 
        'variant_sku', 
        'variant_qty', 
        'variant_image',
    ]; // Allow mass assignment for these fields

    public function product()
    {
        return $this->belongsTo(Product::class ,'product_id'); // Define relationship to Product model
    }
}
