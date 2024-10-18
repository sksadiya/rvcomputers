<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviewSetting extends Model
{
    use HasFactory;
    protected $table = 'review_settings';
    protected $fillable = ['key','value'];
}
