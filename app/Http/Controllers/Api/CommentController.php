<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResourse;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    use ApiResponceTrait;
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user =auth()->user();
        $comments = $user->user_comments;
        return $this->ApiResponse(['user'=> new UserResourse($user),
            'comment'=>CommentResourse::collection($comments)
            ],'ok',200);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    
        $validator = Validator::make($request->all(), [
            'article_id' => 'required|string|max:255|exists:articles,id',
            'comment_body'=>'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        $user =auth()->user();
        $article_id=intval ($request->article_id);
        $article = Article::find($article_id);
        
        // return $user ;
        $comment = new Comment([
            'user_id' => $user->id,
            'article_id' => $article_id,
            'body' => $request->comment_body,
        ]);
    
        $comment->save();
        return  $comment;
        return response()->json(['message' => 'Comment saved successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $article_id)
    {

        $article = Article::find($article_id);
        $comments = $article->Article_comments;
        return $this->ApiResponse([ CommentResourse::collection($comments) ],'ok',201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $comment_id)
    {
    

        $validator = Validator::make($request->all(), [

            'comment_body'=>'required|string|max:255'
        ]);
        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()], 422);
        }
        // return $comment_id;
        $comment = Comment::find($comment_id); 

        if (!$comment)
            return response()->json(['message' => 'Comment not  found'], 404);

        $user_id_comment = $comment->user_id;
        
        $user2 =auth()->user();
        if( $user2->id== $user_id_comment)
        {    
            $comment->body=$request->comment_body?? $comment->body;
            $comment->update();
            return response()->json(['message' => 'Comment updated'], 200);
        }
        else
            return response()->json(['message' =>'you are not the auther of this comment,You do not have the permission to update this comment'],401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($comment_id)
    {
        
        $comment = Comment::find($comment_id); 
        if (!$comment)
            return response()->json(['message' => 'Comment not  found'], 404);
    
        // return 'fdgds';
        $user_id_comment = $comment->user_id;
    
        $user2 =auth()->user();
        if( $user2->id== $user_id_comment)
        {
            $comment->delete();
            return response()->json(['message' => 'The Comment deleted'],200);
        }
        else 
            return response()->json(['message' =>'you are not the auther of this comment,You do not have the permission to delete this comment'],401);

    }
}
