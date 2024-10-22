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
    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class);
    }
    
    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class);
    }
    
}
