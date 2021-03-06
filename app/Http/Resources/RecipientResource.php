<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipientResource extends JsonResource
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
            'worker_id'=> $this->recipient_id,
            'name' => $this->worker->user->name,
        ];
    }
}