@extends('layouts.backend.main', ['users' => $users])

@section('title', 'Dashboard')
@section('styles')

    <style>
        .custom-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: " > ";
        }
    </style>
@endsection
@section('admin-content')
    <div class="main-content-inner" style="padding: 13px;">
        <h3>Dashboard</h3>
    </div>
@endsection
@section('scripts')

@endsection
