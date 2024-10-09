<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mailSetting extends Model
{
    use HasFactory;
    protected $table = 'mail_settings';
    protected $fillable = ['key','value'];
}
