<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table= 'categories';
    protected $fillable = ['name'];
    public function subcategory()
    {
        return $this->hasMany(Subcategory::class,'subcate_id','id');
    }

    public function product()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }
}
