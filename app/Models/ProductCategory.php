<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';

    // Fillable fields for mass assignment
    protected $fillable = [
        'logo', 
        'name', 
        'slug',
        'parent_category_id', 
        'meta_title', 
        'meta_description', 
        'status'
    ];
    protected static function boot()
    {
        parent::boot();

        // Prevent deletion of the "Uncategorized" category
        static::deleting(function ($category) {
            if ($category->name === 'Uncategorized') {
                throw new \Exception('The "Uncategorized" category cannot be deleted.');
            }
        });
    }
    public function parentCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id');
    }

    public function childCategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_category_id');
    }

    /**
     * Build category options recursively with parent-child hierarchy.
     *
     * @param \Illuminate\Support\Collection $categories
     * @param int|null $parentId
     * @param string $prefix
     * @return array
     */
    public function buildCategoryOptions($categories, $parentId = null, $prefix = '')
    {
        $output = [];

        foreach ($categories->where('parent_category_id', $parentId) as $category) {
            $output[] = ['id' => $category->id, 'name' => $prefix . $category->name];
            $output = array_merge($output, $this->buildCategoryOptions($categories, $category->id, $prefix . '--'));
        }

        return $output;
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
