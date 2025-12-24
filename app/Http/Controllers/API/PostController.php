<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Models\Post;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $users = User::where('user_type', 'seller')->get();
        return SellerResource::collection($users);    
       return response()->json(Post::with('user')->latest()->get());

    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $post = $request->user()->posts()->create($request->only('title', 'body'));
        return response()->json(['message' => 'Post created', 'post' => $post]);
    }
    public function show(Post $post)
    {
        return response()->json($post);
    }
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $post->update($request->only('title', 'body'));
        return response()->json(['message' => 'Post updated', 'post' => $post]);
    }
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }

    public function approve($user_id)
    {
        $seller = Seller::where("user_id", $user_id)->first();

        if($seller != null){
            $seller->is_approved = 1;
            $seller->save();
            return response()->json(['message' => 'Seller approved successfully']);
        }

        return response()->json(['message' => 'Seller not found'], 404);
    }

    public function disapprove($user_id)
    {
        $seller = Seller::where("user_id", $user_id)->first();

        if($seller != null){
            $seller->is_approved = 0;
            $seller->save();
            return response()->json(['message' => 'Seller disapproved successfully']);
        }

        return response()->json(['message' => 'Seller not found'], 404);
    }
 
}
