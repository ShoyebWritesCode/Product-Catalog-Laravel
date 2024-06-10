<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price','image', 'image1', 'image2', 'catagory_id'];

    public function subcatagory()
    {
        return $this->belongsTo(Catagory::class, 'catagory_id');
    }
}