<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
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
            'worker_id' => $this->guest_id,
            'board_id' => $this->board_id,
            'num_posts' => $this->publications->count(),
            'worker_name' =>  $this->worker->user->name
        ];
    }
}