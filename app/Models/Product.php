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
    protected $fillable = ['name', 'description', 'price', 'image', 'image1', 'image2', 'catagory_id', 'inventory'];

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

    public function reviewCount()
    {
        return $this->reviews()->count();
    }

    public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function totalQuantity()
    {
        return $this->inventory()->sum('quantity');
    }

    public function images()
    {
        return $this->hasMany(Images::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attCount()
    {
        return $this->attributes()->count();
    }
}
