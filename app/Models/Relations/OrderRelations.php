<?php

namespace App\Models\Relations;

use App\Models\Product;

trait OrderRelations
{
    public function products(){
        return $this->belongsToMany(Product::class)
                    ->withPivot('count','price');
    }
}
