<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $guarded =[];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function wishlistitems(){
        return $this->hasMany(Wishlistitem::class);
    }
    public function images()
    {   
        return $this->hasMany(Productimage::class);
    }
    
    public function cartitem(){
        return $this->hasMany(CartItem::class);
    }
    public function orderitem(){
        return $this->hasMany(OrderItem::class);
    }
}
