<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'email',
        'contact',
        'avatar',
        'password',
        'activation_token',
        'status',
    ];
    protected $hidden = [
        'password',
    ];
    public function billingAddresses()
    {
        return $this->hasMany(BillingAddress::class);
    }

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
