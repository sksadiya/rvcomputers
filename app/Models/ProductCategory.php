<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';

    // Fillable fields for mass assignment
    protected $fillable = [
        'logo', 
        'name', 
        'parent_category_id', 
        'meta_title', 
        'meta_description', 
        'status'
    ];
    public function parentCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id');
    }

    public function childCategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_category_id');
    }
}
