<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    use HasFactory;
    protected $table = 'mappings';
    protected $fillable = [ 'catagory_id','product_id'];

    public function subcatagory()
    {
        return $this->belongsTo(Catagory::class, 'catagory_id', );
    }
}