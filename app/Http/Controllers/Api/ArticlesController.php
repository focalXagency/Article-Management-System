<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Block;
use App\Models\Author;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\AuthorsArticle;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\StoreArticleRequestApi;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:show-articles', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-article', ['only' => ['store', 'show']]);
        $this->middleware('permission:edit-own-article', ['only' => ['update', 'show']]);
        $this->middleware('permission:delete-own-article', ['only' => ['delete', 'show']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $blockedAuthors = Block::where('user_id', $user_id)->get();
        $blockedAuthors_id =$blockedAuthors->pluck('author_id');
        
        if(!$blockedAuthors->isNotEmpty())
        {
        
            $articles = Article::all();
            return ArticleResource::collection($articles);
        }
        else
        {
            $Articles_written_by_blocked_users = AuthorsArticle::where('author_id', $blockedAuthors_id)->get();
            // return $Articles_written_by_blocked_users ;
            $articles = Article::whereNotIn('id',$Articles_written_by_blocked_users->pluck('article_id'))->get();
        
            return ArticleResource::collection($articles);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequestApi $request)
    {
        //store the image in the public folder
        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        Storage::disk('public')->put('images/' . $imageName, file_get_contents($request->image));
        //store in database
        $user_id = auth()->user()->id;
        $auth = Author::where('user_id', $user_id)->first();
        $article=Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imageName,
            'category_id' => $request->category_id
        ]);
        $art_auth=AuthorsArticle::create([
            'author_id'=>$auth->id,
            'article_id'=>$article->id,       
        ]);
        return response()->json(['message' => 'article posted successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::where('id', $id)->with('category')->get();
        return new ArticleResource($article[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $updatedData = [
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category
        ];

        if (isset($request->image)) {
            if (Storage::disk('public')->exists('images/' . $article->image)) {
                Storage::disk('public')->delete('images/' . $article->image);
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $imageName, file_get_contents($request->image));

            $updatedData['image'] = $imageName;
        }
        $article->update($updatedData);

        return response()->json(['message' => 'article updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (Storage::disk('public')->exists('images/' . $article->image)) {
            Storage::disk('public')->delete('images/' . $article->image);
        }
        $article->delete();

        return response()->json(['message' => 'article deleted successfully!']);
    }
}
