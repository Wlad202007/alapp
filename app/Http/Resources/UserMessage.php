<?php

namespace App\Http\Resources;
use App\Http\Resources\FriendMessage;
use App\Http\Resources\MyMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMessage extends JsonResource
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
            'name' => $this->name,
            'created_at' => $this->created_at,
            'avatar_link' => $this->avatar_link,
            'friends_messages' => FriendMessage::collection($this->friendsMessages),
            'my_messages' => MyMessage::collection($this->myMessages),
        ];
    }
}
