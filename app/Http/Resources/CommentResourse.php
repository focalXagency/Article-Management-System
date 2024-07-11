<?php

namespace App\Http\Resources;


use App\Models\Article;
use App\Models\Comment;


use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment_body' =>$this->body,
            'on_article_id'=> $this->article_id,
        ];
    }
}
