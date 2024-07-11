<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\AuthorsArticle;
use App\Http\Controllers\Controller;

class AddAuthorsToArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:create-article');
    }
    public function add_authors(Request $request)
    {
        $user=auth()->user();
        $auth = Author::where('user_id', $user->id)->first();
        if($auth)
        {    
            $article=Article::find($request->article_id);
            $AuthorsArticle=AuthorsArticle::where('article_id',$request->article_id)->get();//الكتاب مع مقالاتهم
            $the_authors_for_this_article=$AuthorsArticle->pluck('author_id');
        
            if(in_array($auth->id, $the_authors_for_this_article->toArray()) )
            {
                if(!in_array($request->new_auther_id, $the_authors_for_this_article->toArray()) )
                {
                    $art_auth=AuthorsArticle::create([
                        'author_id'=>$request->new_auther_id,
                        'article_id'=>$request->article_id,       
                    ]);
                    return response()->json(['message' => 'New author is added !']);

                }
                else

                return response()->json(['message' => 'He is already an author!!!']);

            }
            else
                return response()->json(['message' => 'You are not an author for this Article, you can not add authors!!!']);

        }
        else
            return response()->json(['message' => 'You are not an author, you can not add authors!']);
    }
}
