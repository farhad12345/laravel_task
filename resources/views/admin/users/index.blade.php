@extends('layouts.admin')
@section('content')
<!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">users </h1> --}}
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @can('add post')
                <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#myModal">Add
                    users</button>
                @endcan
                <h6 class="m-0 font-weight-bold ">Users </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="display">
                        <thead>
                            <th>Id</th>
                         <th>Name</th>
                        <th>Email</th>
                            {{-- <th>Image</th> --}}
                            <th>Action</th>
                        </thead>
               <tbody>
                </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@include('components.admin.models.users')
    @endsection
    @section('scripts')
@include('components.admin.script.users')

    @endsection
