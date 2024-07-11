<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price', 'image', 'image1', 'image2', 'catagory_id'];

    public function subcatagory()
    {
        return $this->belongsTo(Catagory::class, 'catagory_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }
}
