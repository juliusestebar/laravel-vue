<?php

namespace App\Http\Resources;

use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'url' => URL::route('post.article', $this->slug),
            'cover_image' =>  url('storage/' . $this->image),
            'content' => $this->content,
            'tags' => $this->tags,
            'date_created' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'date_updated' => Carbon::parse($this->updated_at)->format('d/m/Y'),
            'published' => $this->status == Post::PUBLISHED ? true : false,
        ];
    }
}
