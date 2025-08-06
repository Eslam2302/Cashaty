<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category_id',
        'image',
        'barcode',
        'stock',
        'is_active',
    ];

    public function category(){

        return $this->belongsTo(Category::class);

    }

    public function orders(){

        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price')->withTimestamps();

    }

    public function stockTransactions(){

        return $this->hasMany(StockTransaction::class);

    }

    // To get the available stock of the product
    public function getAvailableStockAttribute(){

        $in = $this->stockTransactions()->where('type','in')->sum('quantity');
        $out = $this->stockTransactions()->where('type','out')->sum('quantity');

        return $in - $out;
        
    }

}
