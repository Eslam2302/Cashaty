<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{

    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('category') 
            ->setDescriptionForEvent(fn(string $eventName) => "Category has been {$eventName}");
    }

    protected $fillable = ['name', 'slug','description'];

    public function products(){

        return $this->hasMany(Product::class);
    }

}