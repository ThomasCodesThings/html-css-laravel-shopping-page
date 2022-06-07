<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Shoppingcart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','ordered'];

    public function users(){
        return $this->belongsToOne(User::class)->withTimestamps();
    }
}
