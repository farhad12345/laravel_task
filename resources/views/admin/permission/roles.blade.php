@extends('layouts.admin')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Roles </h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#myModal">Add
                    Roles</button>
                <h6 class="m-0 font-weight-bold text-primary">ROles </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="display">
                        <thead>
                            <th>Role Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <!-- Table rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('components.admin.models.roles')
    <!-- /.container-fluid -->
@endsection
@section('scripts')
    @include('components.admin.script.role')
@endsection
