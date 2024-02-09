@extends('layouts.admin')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Permissions </h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#myModal">Add
                    Permissions</button>
                <h6 class="m-0 font-weight-bold text-primary">Create Permission </h6>

            </div>
            <div class="card-body">
                {{-- <form id="form" action="{{ route('admin.get-permissions') }}" method="get">
                    <div class="form-group">
                        <label>Select Role</label>
                        <select class="form-control select2" name="role" onchange="get_permissions()"
                            style="width: 100%;">
                            <option selected="selected">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $role_id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form> --}}

                {{-- <div class="grid grid-cols-4 mb-8 gap-4 mt-4">
                    <div class="mt-5">
                        <div class="input-group">
                            <input type="text" class="form-control border rounded-md" id="myInput"
                                onkeyup="myFunction()" placeholder="Search here.." title="Type in a name">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div> --}}


                <div class="table-responsive">
                    <form id="assignPermissionsForm">
                        @csrf
                        <div class="form-group">
                            <label>Select Role</label>
                            <select class="form-control select2" required name="role_id" id="roleSelect"
                                style="width: 100%;">
                                <option value="" disabled selected>Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == $role_id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <table id="myTables" class="table">
                            <thead>
                                <tr>
                                    <th>Menu Name</th>
                                    <th>Assign Permission</th>
                                </tr>
                            </thead>
                            <tbody class="mt-4">
                                @foreach ($modules as $item)
                                    <tr class="mt-4 border border-gray-300">
                                        <td class="border-right border-gray-300"><b class="ml-2">{{ $item->name }}</b>
                                        </td>
                                        <td>
                                            <ul class="list-inline">
                                                @foreach (Spatie\Permission\Models\Permission::where('module_id', $item->id)->get() as $item2)
                                                    <li class="list-inline-item">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" value="{{ $item2->id }}"
                                                                name="permission[]">
                                                            {{ $item2->name }}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-2 col-sm-2 m-4 float-right">
                            <div class="form-group">
                                <input type="submit" class="form-control bg-primary float-righ" id="">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- /Add Permission modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Permission</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="create-permission-form">
                        @csrf
                        <div class="row">
                            <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">module Name</label>
                                <input type="text" class="form-control" name="module_name" id="title"
                                    placeholder="Enter Permission Name" required>
                                <span>Just Write Module Name he will create Others Automaticaly</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="reset" class="btn btn-default">Clear</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Add Permission Model --}}
@endsection
@section('scripts')
    <script>
        $("#create-permission-form").on('submit', function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
            // Send an AJAX request to the Laravel controller
            $.ajax({
                url: '{{ route('admin.permissions.store') }}',
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    // Show the success alert
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        $('#myModal').modal('hide');
                        $('#myTables').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    if (response && response.errors) {
                        var errors = response.errors;
                        $.each(errors, function(field, error) {
                            toastr.error(error[0]);
                        });
                    } else if (response && response.message) {
                        toastr.error(response.message);
                    }
                },

            });
        });
        //Get permission Through user role
        function get_permissions() {
            $('#role_id').val($('#role_id').val());
            $('#form').submit();
        }
        $(document).ready(function() {
            $('#myTables').DataTable({
                language: {
                    searchPlaceholder: "Search here ..",
                    search: ""
                },
                paging: false, // Disable pagination
                info: false
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handler for role select change event
            $('#roleSelect').change(function() {
                var roleId = $(this).val();
                $.ajax({
                    url: '/admin/get-role-permissions/' +
                        roleId, // Update the URL to the endpoint that fetches permissions
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Clear all checkboxes
                        $('input[name="permission[]"]').prop('checked', false);

                        // Check the checkboxes for the retrieved permissions
                        $.each(response.permissions, function(index, permission) {
                            $('input[name="permission[]"][value="' + permission.id +
                                '"]').prop('checked', true);
                        });
                    }
                });
            });
        });

        $("#assignPermissionsForm").on('submit', function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
            // Send an AJAX request to the Laravel controller
            $.ajax({
                url: '{{ route('admin.assign-permissions') }}',
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    var assignedPermissions = response.assigned_permissions;
                    $('input[name="permission[]"]').each(function() {
                        var permissionId = $(this).val();
                        if (assignedPermissions.includes(permissionId)) {
                            $(this).prop('checked', true);
                        }
                    });
                    // Display Toast message
                    toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    // Display error Toast message
                    toastr.error('Error occurred. Please try again.');
                }

            });
        });
    </script>
@endsection
