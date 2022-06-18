<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ForumResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // disini dapat mengolah data lebih felxsibel, seperti membuat uppercase pada query
        return [
            'id' => $this->id,
            // 'title' => $this->title,
            'title' => ucfirst($this->title),
            'body' => $this->body,
            'slug' => $this->sluge,
            'category' => $this->category,
            'created_at' => $this->created_at,    
            'updated_at' => $this->updated_at,    
            'user' => $this->user,    
            'comments' => $this->comments,
        ];
    }
}
