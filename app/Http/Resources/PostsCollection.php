<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $temp = [];
        foreach($this->collection as $post){
            $postLang = $post->postLang ;
            $aPostTitle = [] ;
            $aPostContent = [] ;
            foreach ($postLang as $item)
            {
                $aPostTitle[$item['postLangType']] = $item->postTitle ;
                $aPostContent[$item['postLangType']] = $item->postContent ;
            }

            $temp[] = [
                "id" => $post->id,
                "author" => $post->author,
                "status" => $post->status,
                "postTitle" => $aPostTitle,
                "postContent" => $aPostContent,
            ];
        }

        return $temp;
    }
}
