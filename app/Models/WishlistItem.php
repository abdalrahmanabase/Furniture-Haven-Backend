<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    /** @use HasFactory<\Database\Factories\WishlistItemFactory> */
    use HasFactory;
    protected $guarded =[];

    public function wishlist(){
        return $this->belongsTo(wishlist::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
