<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Address;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceTimetable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Service/Index', [
            'services' => ServiceResource::collection(Service::all()),
        ]);
    }

    public function search(Request $request): array
    {
        $result = Service::when(! empty($request->input('category')), static function (Builder $query) use ($request): Builder {
            return  $query->whereHas('categories', static fn (Builder $query): Builder => $query->whereIn('id', Arr::wrap($request->input('category'))));
        })
        ->when(! empty($request->input('query')), static function (Builder $query) use ($request): Builder {
            return $query->where('name', 'like', '%' . $request->input('query') . '%');
        })
        ->get();

        return [
            'status' => 'success',
            'data' => ServiceResource::collection($result)
        ];
    }

    public function userIndex(?User $user = null): Response
    {
        $user = $user ?? \request()->user();

        return Inertia::render('Service/Index', [
            'services' => ServiceResource::collection(Service::where('user_id', $user->getKey())->get()),
            'user' => $user
        ]);
    }

    public function show(Service $service): Response
    {
        $this->authorize('view', $service);

        return Inertia::render('Service/Show', [
            'service' => new ServiceResource($service),
        ]);
    }

    private function form(?Service $service = null): Response
    {
        return Inertia::render('Service/Form', [
            'service' => $service,
            'categories' => Category::all()
        ]);
    }

    public function create(): Response
    {

        return $this->form();
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Service::class);

        $data = $request->all();
        $dataRaw = $request->all();
        $service = new Service(Arr::except($data, 'timetables'));
        $service->user()->associate($request->user());
        $service->save();

        $service->categories()->sync($request->input('categories', []));

        $address = new Address($request->input('address'));
        $address->save();

        $service->addresses()->sync([$address->getKey()]);

        foreach ($request->input('timetable') as $timetable) {
            $timetable = new ServiceTimetable($timetable);
            $timetable->service()->associate($service);
            $timetable->save();
        }

        foreach ($dataRaw['photos'] ?? [] as $photo) {
            $service->addMedia($photo)->toMediaCollection();
        }

        return Redirect::route('user');
    }

    public function edit(Service $service): Response
    {
        return $this->form($service);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $this->authorize('update', $service);

        $data = $request->all();
        $dataRaw = $request->all();
        $service->update(Arr::except($data, 'timetables'));

        $service->categories()->sync($request->input('categories', []));

        $service->address()->update($request->input('address'));

        foreach ($service->timetables as $timetable) {
            $timetable->update($data['timetables'][$timetable->day]);
        }

        foreach ($dataRaw['photos'] ?? [] as $photo) {
            $service->addMedia($photo)->toMediaCollection();
        }

        return Redirect::route('user');
    }

    public function delete(Service $service): RedirectResponse
    {
        $this->authorize('delete', $service);

        $service->delete();

        return Redirect::route('user.services');
    }
}
