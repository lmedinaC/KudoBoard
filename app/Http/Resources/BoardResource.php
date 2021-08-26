<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'start_date'=> $this->start_date,
            'end_date'=> $this->end_date,
            'num_max_guest' => $this->num_max_guest,
            'num_guest' => $this->guests->count(),
            'owner' => [
                'owner_id'=> $this->owner_id,
                'name'=> $this->worker->user->name
            ],
            'recipients' => RecipientResource::collection($this->recipients),
            'guests' => GuestResource::collection($this->guests),
        ];
    }
}