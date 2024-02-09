<script>
    //Get Data of Posts
    $(document).ready(function() {
        $('#myTable').DataTable({
            serverSide: true,
            ajax: "{{ route('admin.get-resumes') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
            data: 'user.name', // Assuming the user's name attribute is "name"
            name: 'user.name',
            render: function(data, type, full, meta) {
                return data;
            }
        },
                {
                    data: 'summary',
                    name: 'summary'
                },

                {
                    data: 'id',
                    name: 'action',
                    orderable: false,
                    searchable: false,
          render: function(data, type, full, meta) {
        var resume_id = full.template_id;
        console.log(full.template_id);

        var deleteUrl = "{{ route('admin.posts.destroy', ':id') }}".replace(':id', data);
        var viewUrl = "{{ route('admin.users.resumes', [':id', ':resume_id']) }}".replace(':id', data).replace(':resume_id',
        resume_id);
        return '<a href="' + viewUrl + '" target="_blank" class="btn btn-primary" data-id="' +
                data +
                '"><i class="fas fa-eye"></i></a>&nbsp;' +
        '<form action="' + deleteUrl + '" method="post" style="display:inline">' +
            '@csrf' +
            '@method('DELETE')' +
            '<button type="submit" onclick="confirmDelete(event)" ' +
                ' class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>' +
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
                    toastr.success('Post deleted successfully.');
                    $('#myTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    toastr.error('Error deleting post.');
                    // Handle any error during deletion
                }
            });
        }
    }



</script>
