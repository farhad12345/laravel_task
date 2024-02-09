<script>
    //Get Data of Posts
    $(document).ready(function() {
        $('#myTable').DataTable({
            serverSide: true,
            ajax: "{{ route('admin.usersdata') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                // {
                //     data: 'image',
                //     name: 'image',
                //     render: function(data, type, full, meta) {
                //         var imageUrl = "{{ asset('storage/posts') }}/" + data;

                //         if (data) {
                //             return '<img src="' + imageUrl + '" alt="Image" height="50">';
                //         } else {
                //             var defaultImageUrl = "{{ asset('storage/posts/no_image.jpg') }}";
                //             return '<img src="' + defaultImageUrl +
                //                 '" alt="Image" height="50">';
                //         }
                //     }
                // },
                {
                    data: 'id',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        var editUrl = "{{ route('admin.users.edit', ':id') }}".replace(':id',
                            data);
                            var viewUrl = "{{ route('admin.users.show', ':id') }}".replace(':id', data);
                        var deleteUrl = "{{ route('admin.users.destroy', ':id') }}".replace(
                            ':id', data);

                        return '<a href="#" class="btn btn-primary edit-users-btn" data-id="' +
                            data +
                            '"><i class="fas fa-edit"></i></a>&nbsp;' +
                            '<a href="' + editUrl + '" class="btn btn-primary view-users-btn"><i class="fas fa-eye"></i></a>&nbsp;' +
                            '<form action="' + deleteUrl +
                            '" method="post" style="display:inline">' +
                            '@csrf' +
                            '@method('DELETE')' +
                            '<button type="submit" onclick="confirmDelete(event)" ' +
                            'class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>' +
                            '</form>';

                    }
                }
            ]
        });
    });
    //Delete Method fot post
    function confirmDelete(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        if (confirm('Are you sure to delete this?')) {
            var form = event.target.closest('form');
            // Use AJAX to submit the form
            $.ajax({
                url: form.action,
                type: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    toastr.success('User deleted successfully.');
                    $('#myTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    toastr.error('Error deleting post.');
                    // Handle any error during deletion
                }
            });
        }
    }
    // For Post Store
    $("#create-users-form").on('submit', function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        // Send an AJAX request to the Laravel controller
        $.ajax({
            url: '{{ route('admin.users.store') }}',
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                // Show the success alert
                if (response.message) {
                    toastr.success(response.message);
                    $('#myModal').modal('hide');
                    $('#myTable').DataTable().ajax.reload();
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
    // For Post Edit
    $(document).on('click', '.edit-users-btn', function() {
        var postId = $(this).data('id');
        var editUrl = "{{ route('admin.users.edit', ':id') }}".replace(':id', postId);

        // Fetch the post data using AJAX
        $.ajax({
            url: editUrl,
            method: 'GET',
            success: function(response) {
                // Populate the form fields with the retrieved data
                console.log(response.users);
                $('#user-id').val(response.users.id);
                $('#user-name_edit').val(response.users.name);
                $('#user-email_edit').val(response.users.email);
                $('#EditModal').modal('show');
            },
            error: function(xhr, status, error) {
                toastr.error('Error fetching post data.');
            }
        });
    });
    //Update The Post
    // Add an event handler for the update button in the edit modal
    $(document).on('submit', '#edit-user-form', function(event) {
        event.preventDefault();
        var updateUrl = "{{ route('admin.users_update') }}"; // Replace with your update route URL
        var postId = $('#post-id').val(); // Get the post ID from the hidden input field
        var formData = new FormData($('#edit-users-form')[0]); // Get the form data
        // Append the post ID to the update URL
        // updateUrl = updateUrl.replace(':id', postId);

        // Send an AJAX request to update the record
        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.status == 'success') {
                    toastr.success(response.message);
                    // Close the edit modal
                    $('#EditModal').modal('hide');
                    // // Reload the table data
                    $('#myTable').DataTable().ajax.reload();
                }

            },
            error: function(xhr, status, error) {
                toastr.error('Error updating post.');
            }
        });
    });
</script>
