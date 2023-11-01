<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    use HasFactory;

    public const STATUS_COMPLETED = 'completed';

    protected $fillable = ['price', 'currency', 'provider', 'payment_date', 'service_date', 'payment_id', 'status'];

    protected $dates = ['service_date', 'payment_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function timetable(): BelongsTo
    {
        return $this->belongsTo(ServiceTimetable::class, 'service_timetable_id');
    }
}
