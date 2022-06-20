<?php

namespace App\Http\Resources;

use Hamcrest\Text\SubstringMatcher;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => ucfirst($this->title),
            'body' => Substr($this->body),
            'slug' => $this->slug,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comment_count' => $this->comments_count,
        ];
    }
}
