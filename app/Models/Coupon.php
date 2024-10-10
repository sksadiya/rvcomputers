<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $fillable = [
        'name',
        'promocode',
        'discount',
        'minimum_amount',
        'start_date',
        'end_date',
        'max_uses_per_user',
        'description',
        'terms_and_conditions',
        'logo',
        'status',
        'type'
    ];

    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    /**
     * Check if the coupon is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->status && $this->start_date <= now() && $this->end_date >= now();
    }

    public function getDurationAttribute()
{
    $start = Carbon::parse($this->start_date)->format('d/m/Y');
    $end = Carbon::parse($this->end_date)->format('d/m/Y');
    
    return "{$start} to {$end}";
}
}
