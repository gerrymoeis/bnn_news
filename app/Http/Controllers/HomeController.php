<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil postingan terbaru yang sudah publish, lengkap dengan data penulis, kategori, dan editor
        $posts = Post::with(['author', 'category', 'editor'])
            ->where('status', 'published')
            ->latest()
            ->take(9)
            ->get();

        // Mengambil semua kategori untuk ditampilkan di filter
        $categories = Category::all();

        // Mengirim kedua data ke view
        return view('home', compact('posts', 'categories'));
    }

    /**
     * Show a single post.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $post = Post::with(['author', 'category', 'editor'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('post-detail', compact('post'));
    }

    /**
     * Display posts filtered by a specific category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function category(Category $category)
    {
        // Mengambil postingan yang sudah publish dari kategori yang dipilih
        $posts = $category->posts()
            ->with(['author', 'category', 'editor'])
            ->where('status', 'published')
            ->latest()
            ->take(9)
            ->get();

        // Mengambil semua kategori
        $categories = Category::all();

        // Mengirim data ke view yang sama dengan homepage
        return view('home', compact('posts', 'categories'));
    }
}
