<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    use HasFactory;
    protected $table = 'catagories';
    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Catagory::class, 'parent_id');
    }

    public function children($id)
    {
        return $this->where('parent_id', $id)->get();
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
}
