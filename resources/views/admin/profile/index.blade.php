@extends('layouts.admin')
@section('content')

    <body>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Profile </h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile </h6>
                </div>
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">User Profile</h5>
                                </div>
                                <div class="card-body">
                                    <form id="profileForm" class="mb-3">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                value="{{ $user->name }}" name="name">
                                            <input type="text" hidden class="form-control" name="user_id" id="name"
                                                value="{{ $user->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ $user->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="bio">Role</label>
                                            <input type="email" class="form-control" name="role" id="email"
                                                value="{{ $role_name }}" readonly>
                                        </div>
                                        <div class="text-center">

                                            <button type="submit" id="saveBtn" class="btn btn-success ">Save
                                                Profile</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Save profile changes
            $("#profileForm").on('submit', function(event) {
                // Prevent the default form submission behavior
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                // Handle login form submission
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                event.preventDefault();
                // Perform AJAX request to save profile changes
                $.ajax({
                    url: '{{ route('admin.update-profile') }}',
                    method: 'POST',
                    data: $('#profileForm').serialize(),
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        toastr.success('Error occurred. Please try again');
                    }
                });
            });
        });
    </script>
@endsection
