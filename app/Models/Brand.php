<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public $table= 'brands';


    public function productss()
    {
        return $this->hasMany(Product::class,'brand_id','id');
    }
}
