<script>

    //Get Data
    GetOrders();
    function GetOrders(page = 1, per_page = 10) {
            $.ajax({
                url: '/api/get/orders/list?page=' + page + '&per_page=' + per_page,
                type: "get",
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
                    pagination_html += '<a href="javascript:;" onclick="GetOrders(' + (current_page -
                            1) +
                        ',' +
                        per_page + ')">Prev</a>';
                }
                // Add links for the current page and the surrounding pages
                for (var i = Math.max(current_page - 2, 1); i <= Math.min(current_page + 2, total_pages); i++) {
                    if (i == current_page) {
                        pagination_html += '<span>' + i + '</span>';
                    } else {
                        pagination_html += '<a href="javascript:;" onclick="GetOrders(' + i + ',' +
                            per_page + ')">' +
                            i + '</a>';
                    }
                }
                // Add the "next" link if the current page is not the last page
                if (current_page < total_pages) {
                    pagination_html += '<a href="javascript:;" onclick="GetOrders(' + (current_page +
                            1) +
                        ',' +
                        per_page + ')">Next</a>';
                }
            }
            $('#pagination').html(pagination_html);
        }
    $(document).on('submit','#create-order-form', function(e){
        e.preventDefault();
            const formData = new FormData(this);
                $.ajax({
                url: "/api/add/orders",
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
                        GetOrders();
                        $("#create-order-form")[0].reset();
                        $("#myModal").modal("hide");
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
    });

    //Delete Method fot post
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
                        url: "/api/order/delete/" + id,
                        type: "get",
                        dataType: "JSON",
                        cache: false,
                        success: function(response) {
                            if (response["status"] == "fail") {
                                toastr.error('Failed', response["msg"])
                            } else if (response["status"] == "success") {
                                toastr.success('Success', response["msg"])
                                GetOrders();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

    // For Post Store

        $(document).on('click', '.edit-order-btn', function (e) {
        var order = $(this).data("orders");
        $("#EditModal").modal("show");
        $('#id').val(order.id);

        $('#edit_company_id').val(order.company_id);
        $('#edit_order_no').val(order.order_no);
        $('#edit_city_from').val(order.city_from);
        $('#edit_city_to').val(order.city_to);
        $('#edit_price').val(order.price);

        var image = order.order_images;
        var source = "{!! asset('images/orders/') !!}" + '/' + image;
        $('#edit_lmage').attr('src', source);
    });

$(document).on('submit','#update-order-form', function(e){
        e.preventDefault();
            const formData = new FormData(this);
                $.ajax({
                url: "/api/order/update",
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
                        GetOrders();
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
