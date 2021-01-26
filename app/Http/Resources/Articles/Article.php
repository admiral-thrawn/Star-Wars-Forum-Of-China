<?php

namespace App\Http\Resources\Articles;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
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
            'title' => $this->title,
            'topic' => $this->topic(),
            'desctiption' => $this->description,
            'content' => $this->content,
            'content_raw' => $this->when($request->get('raw'), $this->content_raw),
        ];
    }
}
