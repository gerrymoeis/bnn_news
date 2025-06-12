@extends('layouts.dashboard')

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h2">Manajemen Postingan</h1>
            <p class="mb-0">Di sini Anda dapat mengelola semua postingan berita.</p>
        </div>
        <div>
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Postingan
                </a>
            @endcan
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-bottom-0">
        <h5 class="mb-0">Daftar Postingan</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-nowrap">
            <thead class="table-light">
                <tr>
                    <th scope="col">Judul Berita</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Status</th>
                    @if(auth()->user()->role->name === 'Wartawan')
                        <th scope="col">Direview Oleh</th>
                    @endif
                    <th scope="col"></th> <!-- Kolom untuk tombol aksi -->
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/80x60' }}" alt="{{ $post->title }}" class="avatar-lg rounded">
                            <div class="ms-3">
                                <h5 class="mb-0">
                                    <a href="{{ route('post.show', $post->slug) }}" class="text-inherit" target="_blank">{{ Str::limit($post->title, 40) }}</a>
                                </h5>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('dashui-assets/images/avatar/avatar-1.jpg') }}" alt="" class="avatar avatar-xs rounded-circle">
                            <div class="ms-2">
                                <h5 class="mb-0">{{ $post->author->name ?? 'N/A' }}</h5>
                            </div>
                        </div>
                    </td>
                    <td>{{ $post->category->name ?? 'N/A' }}</td>
                    <td>
                        @php
                            $statusConfig = [
                                'published' => ['class' => 'bg-success', 'text' => 'Diterbitkan'],
                                'in_review' => ['class' => 'bg-warning', 'text' => 'Review'],
                                'rejected' => ['class' => 'bg-danger', 'text' => 'Ditolak'],
                                'draft' => ['class' => 'bg-secondary', 'text' => 'Draf'],
                            ];
                            $currentStatus = $statusConfig[$post->status] ?? $statusConfig['draft'];
                        @endphp
                        <span class="badge {{ $currentStatus['class'] }}">{{ $currentStatus['text'] }}</span>
                    </td>
                    @if(auth()->user()->role->name === 'Wartawan')
                        <td>{{ $post->editor->name ?? 'Belum ada' }}</td>
                    @endif
                    <td>
                        <div class="dropdown">
                            <a class="text-muted" href="#" role="button" id="dropdownAction-{{ $post->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownAction-{{ $post->id }}">
                                @if(auth()->user()->role->name === 'Editor' || auth()->user()->role->name === 'Admin')
                                    @if($post->status === 'in_review')
                                        <li>
                                            <form action="{{ route('posts.approve', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check-circle me-2"></i>Setujui
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $post->id }}">
                                                <i class="bi bi-x-circle me-2"></i>Tolak
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                @endif

                                @can('update', $post)
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">
                                        <i class="bi bi-pencil-fill me-2"></i>Edit
                                    </a>
                                </li>
                                @endcan
                                @can('delete', $post)
                                <li>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus postingan ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-trash-fill me-2"></i>Hapus
                                        </button>
                                    </form>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="text-center my-5">
                            <i class="bi bi-newspaper fs-1 text-muted"></i>
                            <h4 class="mt-3">Belum Ada Postingan</h4>
                            <p class="text-muted">Mulai buat postingan baru untuk ditampilkan di sini.</p>
                            @can('create', App\Models\Post::class)
                                <a href="{{ route('posts.create') }}" class="btn btn-primary mt-2">Buat Postingan Pertama Anda</a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@foreach ($posts as $post)
<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal-{{ $post->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $post->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel-{{ $post->id }}">Tolak Postingan: {{ $post->title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('posts.reject', $post) }}" method="POST">
          @csrf
          @method('PATCH')
          <div class="modal-body">
              <div class="mb-3">
                  <label for="rejection_reason-{{ $post->id }}" class="form-label">Alasan Penolakan (Opsional)</label>
                  <textarea class="form-control" id="rejection_reason-{{ $post->id }}" name="rejection_reason" rows="3" placeholder="Berikan alasan mengapa postingan ini ditolak..."></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Tolak Postingan</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection