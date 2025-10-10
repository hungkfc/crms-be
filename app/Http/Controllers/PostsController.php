<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::latest()->paginate(10);
        // dd($posts);
        // return response()->json([
        //     'data'=>$posts
        // ]);
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts), 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // $validateData = $request->validated();
        // // $validateData['user_id'] = auth()->id();
        // $post = Post::create($validateData);
        // return response()->json([
        //     'message'=>'Post created successfully',
        //     'data'=>$post
        // ], 201);
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $post = Post::create($input);
   
        return $this->sendResponse(new PostResource($post), 'Product created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('user');
        return response()->json([
            'data'=>$post
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return response()->json([
            'message'=>'Post updated successfully',
            'data'=>$post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
         // 1. Tùy chọn: Thêm phân quyền (Authorization)
        // if ($request->user()->cannot('delete', $post)) {
        //     return response()->json(['message' => 'Unauthorized.'], 403);
        // }
        $post->delete();
        return response()->json([
            'message'=>'Post deleted successfully'
        ]);
    }
}
