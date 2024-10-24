<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
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
        'status',
        'old_price'
    ];
    public function brand() {
        return $this->belongsTo(Brand::class ,'brand_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class ,'product_id'); 
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

    public function attributes() {
        return $this->hasMany(productAttribute::class , 'product_id');
    }
    public static function generateSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug already exists in the database
        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
