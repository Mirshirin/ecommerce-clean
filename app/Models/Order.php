<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\OrderRelations;


class Order extends Model
{
    use OrderRelations;

    protected $fillable=[
        'name',
        'email',
        'phone_number',
        'address',
        'password',
        'product_title',
        'price',
        'quantity',
        'image',
        'product_id',
        'user_id',
        'payment_status',
        'delivery_status',
        'transaction_id',
        'reference_id',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function payments() 
    {
         return $this->hasMany(Payment::class);
    }  
 
}

