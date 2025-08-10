<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;


class StockTransaction extends Model
{

    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName(logName: 'stockTransaction')
            ->setDescriptionForEvent(fn(string $eventName): string => "stockTransaction has been {$eventName}");
    }

    public function lastActivity(){

        return $this->hasOne(Activity::class, 'subject_id')
            ->where('subject_type', self::class)
            ->latest();
            
    }


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
