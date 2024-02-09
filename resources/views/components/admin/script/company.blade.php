<script>
    //Get Data
    GetCompanies();
    function GetCompanies(page = 1, per_page = 10) {
            $.ajax({
                url: '/api/get/companies/list?page=' + page + '&per_page=' + per_page,
                type: "Get",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    camp_id: "2",
                },
                dataType: "JSON",
                cache: false,
                success: function(response) {
                    console.log(response);
                    if (response["status"] == "fail") {
                        $('.loader').css('display', 'none');
                        toastr.error(response.msg);
                    } else if (response["status"] == "success") {
                        if (response['html'] == '') {

                            $("#apppend_here").html(
                                '<tr class="text-center"><td colspan="7"><span class="fs-6 text-danger">No Data Found</span></td></tr>'
                            );
                        } else {
                            $('#check_loader_image').css('display', 'none');
                             console.log(response['html']);
                            $("#apppend_here").html(response['html']);
                        }
                        console.log(response['total']);
                        render_pagination_links(response['total'], per_page, page);
                        $('.loader').css('display', 'none');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        function render_pagination_links(total_items, per_page, current_page) {
            // Calculate the total number of pages
            var total_pages = Math.ceil(total_items / per_page);

            var pagination_html = '';
            if (total_pages > 1) {
                // Add the "previous" link if the current page is not the first page
                if (current_page > 1) {
                    pagination_html += '<a href="javascript:;" onclick="GetCompanies(' + (current_page -
                            1) +
                        ',' +
                        per_page + ')">Prev</a>';
                }
                // Add links for the current page and the surrounding pages
                for (var i = Math.max(current_page - 2, 1); i <= Math.min(current_page + 2, total_pages); i++) {
                    if (i == current_page) {
                        pagination_html += '<span>' + i + '</span>';
                    } else {
                        pagination_html += '<a href="javascript:;" onclick="GetCompanies(' + i + ',' +
                            per_page + ')">' +
                            i + '</a>';
                    }
                }
                // Add the "next" link if the current page is not the last page
                if (current_page < total_pages) {
                    pagination_html += '<a href="javascript:;" onclick="GetCompanies(' + (current_page +
                            1) +
                        ',' +
                        per_page + ')">Next</a>';
                }
            }
            $('#pagination').html(pagination_html);
        }
    $(document).on('submit','#create-company-form', function(e){
        e.preventDefault();
            const formData = new FormData(this);
                $.ajax({
                url: "/api/add/company",
                type: "post",
                data: formData,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-spin").css('display', 'inline-block');

                },
                complete: function() {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-spin").css('display', 'none');
                },
                success: function(response) {
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"]);

                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $(".fa-spin").css('display', 'none');
                        GetCompanies();
                        $("#create-company-form")[0].reset();
                        $("#myModal").modal("hide");
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
    });

    //Delete Method fot
    $(document).on("click", ".delete-api-btn", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want to delete this .",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, perform delete action
                    $.ajax({
                        url: "/api/company/delete/" + id,
                        type: "get",
                        dataType: "JSON",
                        cache: false,
                        success: function(response) {
                            if (response["status"] == "fail") {
                                toastr.error('Failed', response["msg"])
                            } else if (response["status"] == "success") {
                                toastr.success('Success', response["msg"])
                                GetCompanies();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

    // For  Store

        $(document).on('click', '.edit-company-btn', function (e) {
        var company = $(this).data("lists");
        $("#EditModal").modal("show");
        $('#id').val(company.id);
        $('#edit_company_name').val(company.name);
        $('#edit_company_email').val(company.email);
        $('#edit_country_code').val(company.country_id);
        $('#edit_record_no').val(company.commercial_record_no);
        var image = company.logo;
        var source = "{!! asset('images/companies/') !!}" + '/' + image;
        $('#edit_logo').attr('src', source);
    });

$(document).on('submit','#edit-company-form', function(e){
        e.preventDefault();
            const formData = new FormData(this);
                $.ajax({
                url: "/api/company/update",
                type: "post",
                data: formData,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $("#EditbtnSubmit").attr('disabled', true);
                    $(".fa-spin").css('display', 'inline-block');

                },
                complete: function() {
                    $("#EditbtnSubmit").attr('disabled', false);
                    $(".fa-spin").css('display', 'none');
                },
                success: function(response) {
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"]);
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        GetCompanies();
                        $(".fa-spin edit").css('display', 'none');
                        $("#EditModal").modal("hide");
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
    });
</script>
