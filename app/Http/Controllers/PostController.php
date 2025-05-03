<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    

    public function index()
    {
        $user_id = Auth::user()->id;
        $posts = Post::where('user_id', $user_id)->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,name',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $imagePath = null;

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . 'myapp' . '_' . $image->getClientOriginalName();
            $imagePath = 'uploads/' . $imageName;
            $image->move(public_path('uploads'), $imageName);
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'featured_image' => $imagePath
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|min:3|unique:posts,name' . $post->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                unlink(public_path($post->featured_image));
            }

            $image = $request->file('featured_image');
            $imageName = time() . '_' . 'myapp' . '_' . $image->getClientOriginalName();
            $imagePath = 'uploads/' . $imageName;
            $image->move(public_path('uploads'), $imageName);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'featured_image' => $imagePath
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            unlink(public_path($post->featured_image));
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    // read more and public post list
    /**
     * Public post list view
     */
    public function publicIndex()
    {
        $posts = Post::latest()->with('user')->get();
        return view('welcome', compact('posts'));
    }

    /**
     * Public single post view (for read more)
     */
    public function publicShow(Post $post)
    {
        $post->load('user');
        return view('public_post_show', compact('post'));
    }
}
