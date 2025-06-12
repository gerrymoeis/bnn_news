@extends('layouts.frontend')

@section('title', $post->title . ' - BNN News')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Post Header -->
            <header class="mb-4">
                <!-- Post Title -->
                <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                <!-- Post Meta -->
                <div class="text-muted fst-italic mb-2">
                    Diposting pada {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
                    oleh {{ $post->author->name }}
                </div>
                <!-- Editor Meta -->
                @if($post->editor)
                    <div class="text-muted fst-italic mb-2">
                        <span class="text-success">&#10003; Direview oleh {{ $post->editor->name }}</span>
                    </div>
                @endif
                <!-- Post Categories -->
                <a class="badge bg-primary text-decoration-none link-light" href="#!">{{ $post->category->name }}</a>
            </header>

            <!-- Preview image figure-->
            <figure class="mb-4">
                <img class="img-fluid rounded" src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/900x400' }}" alt="{{ $post->title }}" />
            </figure>

            <!-- Post content-->
            <section class="mb-5 fs-5">
                {!! nl2br(e($post->content)) !!}
            </section>

            <hr>

            <a href="{{ route('home') }}" class="btn btn-outline-dark">&larr; Kembali ke Beranda</a>

        </div>
    </div>
</div>
@endsection
