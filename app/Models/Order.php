<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;



class Order extends Model
{
     use HasFactory,LogsActivity;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('order')
            ->setDescriptionForEvent(fn(string $eventName) => "Order has been {$eventName}");
    }

    // Get last activity of order with user updated
    public function lastActivity(){

        return $this->hasOne(Activity::class, 'subject_id')
            ->where('subject_type', self::class)
            ->latest();

    }

    protected $fillable = [
        'customer_id',
        'total',
        'notes',
        'status',
        'payment_method'
    ];

    public function customer(){

        return $this->belongsTo(Customer::class);

    }

    public function products(){

        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();

    }

    public function user(){

        return $this->belongsTo(User::class);

    }

}