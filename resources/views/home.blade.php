@extends('layouts.frontend')

@section('title', 'BNN News - Berita Terkini dan Terpercaya')

@section('content')
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Selamat Datang di BNN News</h1>
                    <p class="col-md-8 fs-4">Portal berita terkini, terakurat, dan terpercaya di Indonesia. Temukan informasi terbaru dari berbagai kategori.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Telusuri Berdasarkan Kategori</h2>
            <div class="d-flex flex-wrap gap-2">
                @if($categories->isEmpty())
                    <p>Belum ada kategori berita.</p>
                @else
                    @foreach ($categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-primary rounded-pill">
                            {{ $category->name }} <span class="badge bg-primary ms-1">{{ $category->posts_count }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Latest Posts -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Berita Terbaru</h2>
        </div>
    </div>

    <div class="row g-4">
        @if($posts->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    Saat ini belum ada berita yang dipublikasikan.
                </div>
            </div>
        @else
            @foreach ($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('post.show', $post->slug) }}" class="text-inherit">{{ $post->title }}</a></h5>
                            <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <small class="text-muted">
                                Oleh {{ $post->author->name ?? 'Penulis Tidak Dikenal' }}
                                @if($post->editor)
                                    <span class="text-success">&#10003; Direview oleh {{ $post->editor->name }}</span>
                                @endif
                                <br>
                                Kategori: <span class="badge bg-primary">{{ $post->category->name ?? 'Tanpa Kategori' }}</span>
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
