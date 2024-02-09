
<!-- The Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Company</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="create-company-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_name">Company Name</label>
                            <input type="text" class="form-control" name="name" id="company_name" placeholder="Company Name" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Email</label>
                            <input type="email" class="form-control" name="email" id="company_email" placeholder="Email" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Country Code</label>
                            <input type="text" class="form-control" name="country_code" id="country_code" placeholder="Country Code" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Commertial Record No</label>
                            <input type="number" class="form-control" name="record_no" id="record_no" placeholder="Commertial Record No" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Logo</label>
                            <input type="file" class="form-control" name="logo" id="logo" placeholder="Email" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Commercial Record Image</label>
                            <input type="file" class="form-control" name="record_image" id="record_image"  >
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
                <h4 class="modal-title">Edit Company</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-company-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <input type="text" hidden name="id" id="id">
                            <label class="form-label" for="company_name">Company Name</label>
                            <input type="text" class="form-control" name="name" id="edit_company_name" placeholder="Company Name" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_company_email" placeholder="Email" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Country Code</label>
                            <input type="text" class="form-control" name="country_id" id="edit_country_code" placeholder="Country Code" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Commertial Record No</label>
                            <input type="number" class="form-control" name="commercial_record_no" id="edit_record_no" placeholder="Commertial Record No" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Logo</label>
                            <input type="file" class="form-control" name="logo"   >
                            <img src="" id="edit_logo" height="50px" width="45px">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="company_email">Commercial Record Image</label>
                            <input type="file" class="form-control" name="record_image" id="edit_record_image"  >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="EditbtnSubmit">Update</button>
                        {{-- <button type="reset" class="btn btn-default">Clear</button> --}}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   <!-- end Edit modal-->
