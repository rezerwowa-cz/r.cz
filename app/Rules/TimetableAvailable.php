<?php

namespace App\Rules;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class TimetableAvailable implements Rule
{
    private Service $service;

    private string $time;

    public function __construct(Service $service, string $time)
    {
        $this->service = $service;
        $this->time = $time;
    }

    public function passes($attribute, $value)
    {
        $date = Carbon::create($value . ' ' . $this->time);

        if (! ($timetable = $this->service->timetables->where('day', Str::lower($date->dayName))->first())) {
            return false;
        }


        $start = Carbon::createFromTimeString($timetable->from->format('H:i'));
        $end = Carbon::createFromTimeString($timetable->to->format('H:i'));
        $time = Carbon::createFromTimeString($date->format('H:i'));

        if (! $time->between($start, $end)) {
            return false;
        }

        return $this->service->orders
                ->where('status', 'complete')
                ->where('service_date', $date->format('Y-m-d H:i:00'))
                ->count() < $timetable->limit;
    }

    public function message()
    {
        return 'Wybrana godzina nie jest już dostępna!';
    }
}
