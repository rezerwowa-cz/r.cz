<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\ServiceOrder;
use DateInterval;
use DatePeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function order(Service $service): Response
    {
        return Inertia::render('Order/Create', [
            'service' => new ServiceResource($service),
        ]);
    }

    public function store(OrderFormRequest $request, Service $service): RedirectResponse
    {
        $datetime = Carbon::create($request->input('date') . ' ' . $request->input('time'));
        $order = new ServiceOrder([
            'price' => $service->price,
            'currency' => $service->currency,
            'service_date' => $datetime,
            'status' => 'complete',
        ]);
        $order->user()->associate($request->user());
        $order->service()->associate($service);

        $timetable = $service->timetables->where('day', Str::lower($datetime->dayName))->first();

        $order->timetable()->associate($timetable);

        $order->save();

        return Redirect::route('service.order.complete', $order);
    }

    public function complete(Request $request, ServiceOrder $order): Response
    {
        $this->authorize('view', $order);

        return Inertia::render('Order/Complete', [
                'order' => $order,
                'service' => new ServiceResource($order->service)
            ]);
    }

    public function timetables(Request $request, Service $service): array
    {
        $date      = Carbon::create($request->input('date'));
        $timetable = $service->timetables->where('day', Str::lower($date->dayName))->first();

        if (! $timetable) {
            return [
                'status' => 'failed',
            ];
        }
        $interval = DateInterval::createFromDateString($timetable->step . ' minutes');
        $period = new DatePeriod($timetable->from->toDate(), $interval, $timetable->to->toDate());

        $timetables = [];
        foreach ($period as $time) {
            $timetables[] = [
                'time' => $time->format('H:i'),
                'step' => $timetable->step,
                'available' => $timetable->orders
                        ->where('status', 'complete')
                        ->where('service_date', $time->format('Y-m-d H:i:00'))
                        ->count() < $timetable->limit
            ];
        }

        return [
            'status' => 'success',
            'data' => [
                'timetables' => $timetables,
            ],
        ];
    }

    public function userOrders(): Response
    {
        return Inertia::render('Order/List', [
            'orders' => OrderResource::collection(\request()->user()->orders),
        ]);
    }
}
