<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    public function favorite(Request $request)
    {
        $user =auth()->user();
        $article_id=intval ($request->article_id);
        $article = Article::find( $article_id);
        if(empty($article))
            return response()->json([
                'message' => 'This book is not found',
            ]);
        $favourite = $user->favourites()->where('article_id', $article_id)->get();
        if ($favourite->isNotEmpty()) 
        {
            $user->favourites()->detach($article_id);
            return response()->json([
                'message' => 'Favourite book unstored',
            ]);
        } 
        else 
        {
            $user->favourites()->attach($article->id);
            return response()->json([
                'message' => 'Favorit book stored',
            ]);
        }
    
    }
}
