<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Service $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (string) money($this->price, $this->currency, true),
            'thumbnail' => $this->getFirstMediaUrl(),
            'gallery' => collect($this->getMedia()->all())->transform(static fn (Media $media): string => $media->getFullUrl()),
            'creator' => $this->user,
            'address' => $this->address(),
            'timetables' => $this->timetables,
            'categories' => CategoryResource::collection($this->categories),
        ];
    }
}
