<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';
    protected $fillable = ['product_id', 'quantitySR', 'quantityMR', 'quantityLR', 'quantitySB', 'quantityMB', 'quantityLB', 'quantitySG', 'quantityMG', 'quantityLG'];
}
