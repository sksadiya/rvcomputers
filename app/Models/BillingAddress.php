<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;
    protected $table = 'billing_addresses';
    protected $fillable = [
        'customer_id',
        'address_line_1',
        'address_line_2',
        'city_id',
        'state_id',
        'postal_code',
        'country_id',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class ,'customer_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
