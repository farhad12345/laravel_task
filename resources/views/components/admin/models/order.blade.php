
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Order</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="create-order-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_name">Select Company</label>
                            <select class="form-control select2" name="company_id" id="company_id">
                                <option selected disabled >Select Company</option>
                                @foreach($compnies as $compnay)
                                <option value="{{ $compnay->id }}">{{ $compnay->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Order Number</label>
                            <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order Number" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">City From</label>
                            <input type="text" class="form-control" name="city_from" id="city_from" placeholder="City From" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">City To</label>
                            <input type="text" class="form-control" name="city_to" id="city_to" placeholder="City To" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Price" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Image</label>
                            <input type="file" class="form-control" name="image" id="image"  >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btnSubmit">Save</button>
                        {{-- <button type="reset" class="btn btn-default">Clear</button> --}}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   {{-- Edit Company Model --}}
   <div id="EditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Order</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="update-order-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_name">Select Company</label>
                            <select class="form-control " name="company_id" id="edit_company_id">
                                <option selected disabled >Select Company</option>
                                @foreach($compnies as $compnay)
                                <option value="{{ $compnay->id }}">{{ $compnay->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="id" hidden id="id">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Order Number</label>
                            <input type="text" class="form-control" name="order_no" id="edit_order_no" placeholder="Order Number" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">City From</label>
                            <input type="text" class="form-control" name="city_from" id="edit_city_from" placeholder="City From" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">City To</label>
                            <input type="text" class="form-control" name="city_to" id="edit_city_to" placeholder="City To" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Price</label>
                            <input type="number" class="form-control" name="price" id="edit_price" placeholder="Price" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Image</label>
                            <input type="file" class="form-control" name="image" id=""  >
                            <img src="" id="edit_lmage" height="50px" width="45px">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btnSubmit">Save</button>
                        {{-- <button type="reset" class="btn btn-default">Clear</button> --}}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   <!-- end Edit modal-->
