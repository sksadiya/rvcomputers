<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class media extends Model
{
    use HasFactory;
    protected $table = 'media';
    protected $fillable = ['title' ,'url' ,'alt_text' ,'description' ,'caption' ,'name'];
}
