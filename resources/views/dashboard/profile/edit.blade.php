@extends('layouts.dashboard')

@section('page-header')
    <h1 class="h2">Edit Profil</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12">
                @include('dashboard.profile.partials.update-profile-information-form')
            </div>
            <div class="col-lg-6 col-md-12 col-12 mt-4 mt-lg-0">
                @include('dashboard.profile.partials.update-password-form')
            </div>
        </div>
    </div>
@endsection