<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Models\AuthorsArticle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticlesWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('category')->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        $Authors_id = Author::all()->pluck('user_id');
        $Authors = User::whereIn('id', $Authors_id)->get();
        return view('articles.create', compact('categories', 'Authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {

        // مصفوفة تحتوي على أرقام نصية
        $arrayOfStrings = $request->authors_id;
        // تحويل كل عنصر في المصفوفة إلى رقم صحيح
        $arrayOfIndexes_users = array_map('intval', $arrayOfStrings);
        //store the image in the public folder
        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        Storage::disk('public')->put('images/' . $imageName, file_get_contents($request->file('image')));
        //store in database
        $article = Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imageName,
            'category_id' => $request->category_id
        ]);
        $auth_indexes = Author::whereIn('user_id', $arrayOfIndexes_users)->get();
        // dd($auth_indexes->pluck('id') );
        // $arrayOfIndexes_authors=
        foreach ($auth_indexes as $index) {
            // dd($index->id);
            $art_auth = AuthorsArticle::create([
                'author_id' => $index->id,
                'article_id' => $article->id,
            ]);
        }
        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::where('id', $id)->with('authors', 'authors.userData')->get();
        $article = $article[0];
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::where('id', $id)->with('authors', 'authors.userData')->get();
        $article = $article[0];
        $categories = Category::all();
        $Authors = Author::with('userData')->get();
        return view('articles.edit', compact('article', 'categories', 'Authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $updatedData = [
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
        ];
        $selectedAuthorIds = $request->input('authors_id', []);
        $article->authors()->sync($selectedAuthorIds);

        if (isset($request->image)) {
            if (Storage::disk('public')->exists('images/' . $article->image)) {
                Storage::disk('public')->delete('images/' . $article->image);
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $imageName, file_get_contents($request->image));

            $updatedData['image'] = $imageName;
        }

        $article->update($updatedData);
        return redirect()->route('articles.index', $article->id);
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

        return redirect()->route('articles.index');
    }
}
