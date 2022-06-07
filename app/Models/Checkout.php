<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $fillable = ['userID','cartID','name','email','phone','country',
    'region','town','postalCode','street','details','payment','delivery','total'];
}

