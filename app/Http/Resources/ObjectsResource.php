<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObjectsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'location' => $this->location,
            'category' => $this->category->title,
            'information' => isset($this->information) ? [
                'year_grounds' => $this->information->year_grounds,
                'description' => $this->information->description
            ] : [],
            'pictures' => PictureResource::collection($this->pictures)
        ];
    }
}
