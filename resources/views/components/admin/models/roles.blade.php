   <!-- /Add Role modal -->
   <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <!-- Modal content-->
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title">Add Role</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                   <form id="create-role-form">
                       @csrf
                       <div class="row">
                           <div class="mb-12 col-12">
                               <label class="form-label" for="validationCustom01">Role Name</label>
                               <input type="text" class="form-control" name="role_name" id="title"
                                   placeholder="Role Name" required>
                               <div class="valid-feedback">
                                   Looks good!
                               </div>
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
   {{-- End Add Role Model --}}

   {{-- Edit Model --}}
   <div id="EditModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <!-- Modal content-->
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title">Edit Role</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>

               </div>
               <div class="modal-body">
                   <form id="edit-role-form" class="ps-3 pe-3">
                       @csrf
                       <input type="text" name="role_id" hidden id="role-id">
                       <div class="row">
                           <div class="mb-12 col-12">
                               <label class="form-label" for="validationCustom01">Role</label>
                               <input type="text" class="form-control" name="role_name" id="role-name"
                                   placeholder="Title" required>
                               <div class="valid-feedback">
                                   Looks good!
                               </div>
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button type="submit" class="btn btn-success" id="update-post-btn">Update</button>
                           <button type="reset" class="btn btn-default">Clear</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
   <!-- end Edit modal-->
