<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{

    protected $fillable = [
        'product_id',
        'quantity',
        'type', // 'in' or 'out'
        'notes',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function products(){

        return $this->belongsTo(Product::class);
        
    }
}