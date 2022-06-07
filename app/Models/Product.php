<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['productTitle','productImage','productType','productPrice','productBrand','productAmount','productDiscount', 'productdetail'];
    protected $cast = ['productImage' => 'array'];

}
