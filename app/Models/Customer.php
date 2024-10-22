<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory;
    use Notifiable;
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
        return $this->hasOne(BillingAddress::class);
    }

    public function shippingAddresses()
    {
        return $this->hasOne(ShippingAddress::class);
    }
}
