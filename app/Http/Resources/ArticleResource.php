<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Article;
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // return $request;
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'category' => $this->category->name,
            'publish_date' => $this->created_at,
        ];

        $actual_url = (isset($_SERVER['HTTPS'])? 'https': 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        $data['image_url'] = $actual_url . 'images/' . $this->image;

        return $data;
    }
}
