@extends('layouts.backend.main')

@section('title')
    permission Page - Admin Panel
@endsection

@section('styles')
@endsection


@section('admin-content')
    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Permissions List</h4>
                        <p class="float-right mb-2">
                            @can('create permission')
                                <a class="btn btn-primary text-white" href="{{ route('admin.permissions.create') }}">Create New
                                    Permission</a>
                            @endcan

                        </p>
                        <div class="clearfix"></div>
                        <div class="data-tables">
                            @include('partials.backend.messages')
                            <table id="dataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="33%">Sl</th>
                                        <th width="33%">Name</th>
                                        @if (Auth::user()->hasAnyPermission(['edit permission', 'delete permission']))
                                            <th width="33%">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $permission->name }}</td>
                                            @if (Auth::user()->hasAnyPermission(['edit permission', 'delete permission']))
                                                <td>
                                                    @can('edit permission')
                                                        <a class="btn btn-success text-white"
                                                            href="{{ route('admin.permissions.update', $permission) }}">Edit</a>
                                                    @endcan

                                                    @can('delete permission')
                                                        <a class="btn btn-danger text-white"
                                                            href="{{ route('admin.permissions.delete', $permission) }}">
                                                            Delete
                                                        </a>
                                                    @endcan

                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('scripts')
    <!-- Start datatable js -->


    <script>
        /*================================
                datatable active
                ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }
    </script>
@endsection
