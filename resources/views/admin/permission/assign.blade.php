<x-app-layout>
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <script src="{{url('plugins/jquery/jquery.min.js')}}" ></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Assign Permission</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Assign Permission</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Assign Permission</h3>
                <div class="card-tools">
                  @if(auth()->user()->permission('add permissions')) 
                  <button type="button" class="btn btn-tool bg-primary" data-toggle="modal" data-target="#modal-default">
                    Add Permission
                  </button>
                  @endif
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            
              <!-- /.card-header -->
            
                <form id="form" action="{{route('GetPermissions')}}" method="get">
                @csrf
                 <!-- /.form-group -->
                 <div class="col-md-6">
                    <div class="form-group">
                      <label>Select Role</label>
                      <select class="form-control select2"  name="role" onchange="get_permissions()" style="width: 100%;">
                        <option selected="selected">Select Role</option>
                        @foreach($roles as $role )
                        <option value="{{$role->id}}" {{($role->id == $role_id) ? 'selected' : ''}}>{{$role->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
          
            <div class="grid grid-cols-4 mb-8 gap-4 mt-4">
            
                <div class="mt-5">
                    <input type="text" class="border border-gray-300 rounded-md	 w-full" id="myInput" onkeyup="myFunction()" placeholder="Search here.." title="Type in a name">
                </div>
            </div>
            <form action="{{route('AssignPermissions')}}" method="post">
                @csrf
                <table id="myTable" class="w-100 border border-gray-400"> 
                    <thead class="bg-gray-400 text-black w-100">
                        <th>Menu Name</th>
                        <th>Assign Permission</th>
                    </thead>
                    <tbody class="mt-4">
                        <input type="text" name="role_id" hidden id="role_id" value="{{$role_id}}">
                        @foreach ($modules as $item)
                            <tr class="mt-4 border border-gray-300">
                                <td class="border-r border-gray-300"><b class="ml-2">{{ $item->name }}</b></td>
                                <td>
                                    <ul class="flex justify-between">
                                        @foreach (Spatie\Permission\Models\Permission::where('module_id', $item->id)->get() as $item2)
                                            <li class="w-3/12 border-r border-gray-300 ml-4"><label for="">
                                                {{-- @foreach($role_permission as $per)
                                               @if($item2->id==$per->permission_id) --}}
                                                <input type="checkbox" value="{{ $item2->id }}" @if (App\Models\User::get_roles_permissions($role_id, $item2->id))
                                                checked
                                                @endif name="permission[]"> {{ $item2->name }}</label></li>
                                                {{-- @endif
                                                @endforeach --}}
                                        @endforeach
                                    </ul>
                                </td>
        
                            </tr>
                        @endforeach
                        {{-- <div hidden>
                            <input  type="checkbox" value="0" checked name="permission[]"> 
                        </div> --}}
                       
                    </tbody>
                </table>
        
                
                    <div class="col-1 col-sm-1 m-4 float-right" >
                        <div class="form-group">
                          <input type="submit" class="form-control bg-primary float-righ" id="" >
                          </div>
                        </div>
            
                    </form>
              </div>
         
            </div>
          </div>
        </div>
          <!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Module Name</h4>
        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="{{route('permission.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="row">
                    <!-- /.col -->
                      <div class="col-12 col-sm-12">
                        <div class="form-group">
                          <label for="Permission">module Name</label>
                          <input type="text" class="form-control" name="module_name" id="" placeholder="Enter Permission Name">
                          <span>Just Write Module Name he will create Others Automaticaly</span>
                      </div>
                        </div>
                        <div class="form-group">
                
                          <input type="Submit" class="form-control bg-success"  id="" >
                          </div>
                        </div>
                      </form>
                          </div>
      <div class="modal-footer justify-content-between">
    
        {{-- <button type="button" id="close2" class="btn btn-default" data-dismiss="modal">Close</button> --}}
      
      </div>
  </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- /.content-wrapper -->
   <script>
        function get_permissions() {
        $('#role_id').val($('#role_id').val());
        $('#form').submit();
    }
     $(document).ready(function() {
    $('#myTables').DataTable({
        language: {
            searchPlaceholder: "Search here ..",
            search: ""
        },
       
       
       
        });
    });
     function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                } else {
                tr[i].style.display = "none";
                }
                }       
            }
        }
   </script>
          </x-app-layout>