<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public function sub_category()
    {
        return $this->belongsTo(Subcategory::class, 'sub_category_id', 'id');
    }

    public function categorys()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class,'product_id','id');
    }

    public function rating()
    {
        return $this->hasMany(ProductRating::class,'product_id','id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id','id');
    }

}
