<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Display all posts
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    // Show form to create a new post
    public function create()
    {
        return view('posts.create');
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:active,inactive',
            'image' => 'required|image|max:2048', // Marked image as required
        ]);

        $data = $request->only(['title', 'content', 'status']);

        // Handle image upload
        $data['image'] = $request->file('image')->store('posts', 'public');

        Post::create($data);

        return redirect()->route('admin.post.index')->with('success', 'Post created successfully!');
    }


    // Show form to edit an existing post
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    // Update the post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id); // Retrieve the post you are editing

        // Apply validation rules
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:active,inactive',
            'image' => $post->image ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        // Update the post with new data
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->status = $request->input('status');

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        // Save the updated post
        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Post updated successfully');
    }


    // Delete the post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Delete image file if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully!');
    }
}
