<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Post::with(['author', 'category', 'editor'])->latest();

        if ($user->role->name === 'Wartawan') {
            // Wartawan hanya melihat postingan miliknya
            $query->where('author_id', $user->id);
        } elseif ($user->role->name === 'Editor') {
            // Editor hanya melihat postingan yang perlu direview
            $query->where('status', 'in_review');
        }
        // Admin tidak difilter, melihat semua postingan

        $posts = $query->paginate(10);

        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        $categories = Category::all();
        return view('dashboard.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $validatedData;
        $data['author_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        $data['status'] = 'in_review'; // Otomatis set status untuk direview

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts_featured_images', 'public');
            $data['featured_image'] = $path;
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $rules = [
            'title' => ['required', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Tambahkan validasi status jika field tersebut ada dalam request dan pengguna berwenang
        if ($request->has('status')) {
            $user = auth()->user();
            $allowed_statuses = [];
            if ($user->role->name === 'Admin') {
                $allowed_statuses = ['draft', 'in_review', 'published', 'rejected'];
            } elseif ($user->id === $post->author_id) { // Penulis asli
                $allowed_statuses = ['draft', 'in_review'];
            }

            if (!empty($allowed_statuses)) {
                $rules['status'] = ['required', Rule::in($allowed_statuses)];
            }
        }

        $validatedData = $request->validate($rules);

        $data = $validatedData;
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $path = $request->file('featured_image')->store('posts_featured_images', 'public');
            $data['featured_image'] = $path;
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Hapus gambar dari storage jika ada
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil dihapus!');
    }

    /**
     * Approve the specified post.
     */
    public function approve(Post $post)
    {
        $this->authorize('manage', $post);

        $post->update([
            'status' => 'published',
            'editor_id' => auth()->id(),
            'published_at' => now(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil disetujui dan dipublikasikan.');
    }

    /**
     * Reject the specified post.
     */
    public function reject(Request $request, Post $post)
    {
        $this->authorize('manage', $post);

        $request->validate(['rejection_notes' => 'required|string']);

        $post->update([
            'status' => 'rejected',
            'editor_id' => auth()->id(),
            'rejection_notes' => $request->rejection_notes,
        ]);

        return redirect()->route('posts.index')->with('success', 'Postingan telah ditolak.');
    }
}
