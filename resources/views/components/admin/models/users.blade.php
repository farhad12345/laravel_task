<!-- /Add Post modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="create-users-form">
                    @csrf
                    <div class="row">
                        <div class="mb-12 col-12">
                            <label class="form-label" for="validationCustom01">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-12 col-12">
                            <label class="form-label" for="validationCustom01">Email</label>
                            <input type="email" name="email" placeholder="Email"  class="form-control" id="email">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-12 col-12">
                            <label class="form-label" for="validationCustom01">Password</label>
                            <input type="password" name="password" placeholder="Password"  class="form-control" id="pass">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-12 col-md-12">
                            <label class="form-label" for="company_name">Select Role</label>
                            <select class="form-control " name="role_id" id="role_id">
                                <option selected disabled >Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <br><br><br>
                        <div class="mb-12 col-12">
                            <label class="form-label" for="validationCustom01">Description</label>
                            <textarea name="description" class="editor" id="description" cols="60" rows="5"></textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> --}}
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
{{-- End Add Post Model --}}

{{-- Edit Post Model --}}
<div id="EditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form id="edit-users-form" class="ps-3 pe-3">
                    @csrf
                    <input type="text" name="user_id" hidden id="user-id">
                    <div class="row">
                        <div class="mb-12 col-12">
                            <label class="form-label" for="validationCustom01">Name</label>
                            <input type="text" class="form-control" name="name" id="user-name_edit"
                                placeholder="Name" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">Email</label>
                                <input type="email" class="form-control" name="email" id="user-email_edit" placeholder="Email" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
{{--
                        <div class="mb-12 col-12">
                            <label class="form-label" for="validationCustom01">Image</label>
                            <input type="text" hidden class="form-control" id="image" name="old_image">
                            <input type="file" name="photo" accept="image/*" class="form-control" id="enImg">
                            <img src="" height="50px" id="my_image" width="50px" alt="" title="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> --}}

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="update-post-btn">Save</button>
                        <button type="reset" class="btn btn-default">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end Edit modal-->
