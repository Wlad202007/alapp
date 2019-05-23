<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FriendMessage extends JsonResource
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
            'body' => $this->body,
            'created_at' => $this->created_at,
            'author_id' => $this->author_id,
            'friend_id' => $this->friend_id,
            'read' => $this->read,
            'time' => $this->time,
            'group_id' => $this->group_id,
        ];
    }
}
