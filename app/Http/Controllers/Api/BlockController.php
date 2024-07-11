<?php

namespace App\Http\Controllers\Api;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $author_id = $request->input('author_id');
        $blockedAuthors = Block::where('author_id', $author_id)->where('user_id', $user_id)->first();
        if(!$blockedAuthors)
        {
            $user->blocks()->attach($author_id);
            return response()->json(['message' => 'Author blocked successfully.']);
                
            }
   
        else
            return response()->json(['message' => 'This Author is already blocked successfully.']);
        // {
        // $user->blocks()->attach($author_id);
        // return response()->json(['message' => 'Author blocked successfully.']);
            
        // }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id)
    {
        $user = auth()->user();
        $user_id = auth()->user()->id;
        $blockedAuthors = Block::where('author_id', $author_id)->where('user_id', $user_id)->first();
        if($blockedAuthors)
        { 
            $user->blocks()->detach($author_id);
            return response()->json(['message' => 'Author unblocked successfully.', ]);
        }
        else
            return response()->json(['message' => 'This Author is already unblocked successfully.']);
     
    }
}
