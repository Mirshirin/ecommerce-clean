<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['title','description','image','price','discount_price','quantity','category_id'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
}
