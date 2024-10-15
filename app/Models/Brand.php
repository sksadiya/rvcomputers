<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $fillable = ['logo' ,'name','slug','meta_title' ,'meta_description','status'];

    protected function generateSlug($name) {
    // Generate a slug from the name
    $slug = Str::slug($name);
    $originalSlug = $slug;
    $count = 1;

    // Ensure the slug is unique
    while (Brand::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    return $slug;
}

}
