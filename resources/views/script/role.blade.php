<script>
    //Get Role Data In show in table
    $(document).ready(function() {
        $('#myTable').DataTable({
            serverSide: true,
            ajax: "{{ route('admin.get-roles') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'id',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        var editUrl = "{{ route('admin.roles.edit', ':id') }}".replace(':id',
                            data);
                        var deleteUrl = "{{ route('admin.roles.destroy', ':id') }}".replace(
                            ':id', data);

                        return '<a href="#" class="btn btn-primary edit-role-btn" data-id="' +
                            data +
                            '"><i class="fas fa-edit"></i></a>&nbsp;' +
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
    //Delete Roles
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
                    toastr.success('Roles deleted successfully.');
                    $('#myTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    toastr.error('Error deleting Roles.');
                    // Handle any error during deletion
                }
            });
        }
    }
    // For Role Store
    $("#create-role-form").on('submit', function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        // Send an AJAX request to the Laravel controller
        $.ajax({
            url: '{{ route('admin.roles.store') }}',
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
    // Edit Role
    $(document).on('click', '.edit-role-btn', function() {
        var RoleId = $(this).data('id');
        var editUrl = "{{ route('admin.roles.edit', ':id') }}".replace(':id', RoleId);

        // Fetch the post data using AJAX
        $.ajax({
            url: editUrl,
            method: 'GET',
            success: function(response) {
                // Populate the form fields with the retrieved data
                $('#role-id').val(response.roles.id);
                $('#role-name').val(response.roles.name);
                $('#EditModal').modal('show');
            },
            error: function(xhr, status, error) {
                toastr.error('Error fetching post data.');
            }
        });
    });
    //Update The Role 
    // Add an event handler for the update button in the edit modal
    $(document).on('submit', '#edit-role-form', function(event) {
        event.preventDefault();
        var updateUrl = "{{ route('admin.roles_update') }}"; // Replace with your update route URL
        var RoleId = $('#role-id').val(); // Get the post ID from the hidden input field
        var formData = new FormData($('#edit-role-form')[0]); // Get the form data
        // Append the post ID to the update URL

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
