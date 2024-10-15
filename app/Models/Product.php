<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'brand_id',
        'unit',
        'weight',
        'min_qty',
        'video_provider',
        'video_link',
        'unit_price',
        'discount',
        'discount_type',
        'current_stock',
        'sku',
        'short_description',
        'description',
        'low_stock_quantity',
        'image',
    ];
    public function variants()
    {
        return $this->hasMany(ProductVariant::class); 
    }
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'category_product', 'product_id', 'category_id'); 
    }

    // Relationship to Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id'); 
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color', 'product_id', 'color_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class ,'product_id');
    }
}
