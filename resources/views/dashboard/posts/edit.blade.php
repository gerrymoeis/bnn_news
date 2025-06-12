@extends('layouts.dashboard')

@section('page-header')
    <h1 class="h2">Edit Postingan</h1>
    <p>Perbarui detail postingan Anda di bawah ini.</p>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Formulir Edit Postingan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status Dropdown --}}
            @if(auth()->user()->role->name === 'Admin' || auth()->id() == $post->author_id)
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    @php
                        $statuses = [];
                        if (auth()->user()->role->name === 'Admin') {
                            $statuses = ['draft' => 'Draft', 'in_review' => 'In Review', 'published' => 'Published', 'rejected' => 'Rejected'];
                        } else {
                            // Wartawan (Author) can only switch between draft and in_review
                            $statuses = ['draft' => 'Draft', 'in_review' => 'In Review'];
                        }
                    @endphp
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $post->status) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @endif

            <div class="mb-3">
                <label for="content" class="form-label">Konten</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="featured_image" class="form-label">Gambar Unggulan</label>
                <input class="form-control @error('featured_image') is-invalid @enderror" type="file" id="featured_image" name="featured_image">
                @error('featured_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if ($post->featured_image)
                    <div class="mt-2">
                        <p>Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="img-thumbnail" width="200">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Perbarui Postingan</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
