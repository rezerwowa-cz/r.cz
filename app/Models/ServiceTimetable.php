<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceTimetable extends Model
{
    use HasFactory;

    protected $fillable = ['day', 'from', 'to', 'limit', 'step'];

    protected $dates = ['from', 'to'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class, 'service_timetable_id');
    }

    public function confirmedOrders(): HasMany
    {
        return $this->orders()->where('status', ServiceOrder::STATUS_COMPLETED);
    }
}
