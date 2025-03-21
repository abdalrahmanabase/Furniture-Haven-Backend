<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $guarded =[];

    public function orderitems(){
        return $this->hasMany(OrderItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


    public function shippingaddress(){
        return $this->hasOne(ShippingAddress::class);
    }
}
