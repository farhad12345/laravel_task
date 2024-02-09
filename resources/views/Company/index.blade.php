@extends('layouts.admin')
@section('content')


    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Companies</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @can('add company')
                    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#myModal">Add Company</button>
                @endcan
                <h6 class="m-0 font-weight-bold text-primary">Companies</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country ID</th>
                                <th>Company Code</th>
                                <th>Commercial Number</th>

                                <th>Logo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="apppend_here">
                            <!-- Table rows -->
                        </tbody>
                    </table>
                    <div class="text-end">
                        <div id="pagination">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->
    @include('components.admin.models.company')
@endsection
@section('scripts')
    @include('components.admin.script.company')
@endsection
