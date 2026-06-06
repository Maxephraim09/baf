<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display list of all blog posts
     */
    public function index()
    {
        $posts = Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        
        $featured = Blog::where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->first();
        
        $recent = Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        
        $categories = Blog::where('status', 'published')
            ->select('category')
            ->distinct()
            ->get()
            ->pluck('category');
        
        return view('frontend.blog.index', compact('posts', 'featured', 'recent', 'categories'));
    }

    /**
     * Display single blog post
     */
    public function show($slug)
    {
        $post = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        
        // Increment view count
        $post->increment('views');
        
        // Get related posts
        $related = Blog::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->limit(3)
            ->get();
        
        return view('frontend.blog.show', compact('post', 'related'));
    }

    /**
     * Display posts by category
     */
    public function category($category)
    {
        $posts = Blog::where('status', 'published')
            ->where('category', $category)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        
        $categories = Blog::where('status', 'published')
            ->select('category')
            ->distinct()
            ->get()
            ->pluck('category');
        
        return view('frontend.blog.category', compact('posts', 'category', 'categories'));
    }
}