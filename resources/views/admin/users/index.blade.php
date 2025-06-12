@extends('layouts.dashboard')

@section('page-header')
    <h1 class="h2">Manajemen Pengguna</h1>
    <p>Kelola semua pengguna yang terdaftar di sistem.</p>
@endsection

@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Pengguna</h5>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Peran</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-primary">{{ $user->role->name }}</span></td>
                    <td>
                        @if ($user->isApproved())
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-warning">Menunggu Persetujuan</span>
                        @endif
                    </td>
                    <td>
                        @unless ($user->isApproved())
                            <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                            </form>
                        @endunless
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
