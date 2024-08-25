<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emaillog extends Model
{
    use HasFactory;


  protected $fillable =[
    'recipient' ,
    'message',
    'sent_at',
  ];
}
