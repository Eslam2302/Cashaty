<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Customer extends Model
{

    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() 
            ->useLogName(logName: 'customer')
            ->setDescriptionForEvent(fn(string $eventName) => "Customer has been {$eventName}");
    }

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    public function orders(){

        return $this->hasMany(Order::class);

    }

}
