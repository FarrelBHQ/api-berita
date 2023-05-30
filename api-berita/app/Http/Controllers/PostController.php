<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ShowResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $berita = Post::all();
        return PostResource::collection($berita);
    }

    public function show($id)
    {
        $post = Post::with('writer')->findOrFail($id);
        return new ShowResource($post);

    }

    public function show1($id)
    {
        $post = Post::findOrFail($id);
        return new ShowResource($post);

    }

    public function create(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'author' => $request->author,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => $request->title,'telah tertera',
            'data' => $post
        ]);
    }

    public function edit(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();
        if (! $post) {
            return response([
                'message' => 'Post Tak Ada'
            ]); 
        }

        $post->update([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'author' => $request->author,
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $post
        ], 200);
    }

    public function delete($id)
    {
        $post = Post::where('id', $id)->first();

        if (! $post) {
            return response([
                'message' => 'title Tak Ada'
            ]); 
        }

        $post->delete();

        return response()->json([
            'status' => 'Success',
            'message' => $post->title.'berhasil dihapus'
        ], 200);

    }
}
