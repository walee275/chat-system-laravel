@extends('layouts.backend.main')

@section('title')
    permission Edit - Admin Panel
@endsection

@section('styles')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }
    </style>
@endsection


@section('admin-content')


    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Edit permission</h4>
                        @include('partials.backend.messages')

                        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">permission Name</label>
                                <input type="text" class="form-control" id="name" value="{{ $permission->name }}"
                                    name="name" placeholder="Enter a permission Name">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update permission</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('scripts')
    @include('backend.permissions.partials.scripts')
@endsection
