<x-app-layout>
    <script src="{{url('plugins/jquery/jquery.min.js')}}" ></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Add Permissions</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Permissions</li>
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
                <h3 class="card-title">Add Permissions</h3>
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
             
        
                <!-- /.row -->
            
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Module Name</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $item)
                        <tr>
                          <td>{{$item->name}}</td>
                          <td>  
                            <div class="row"> 
                             <a href="{{ URL::to('de_Active/'. $item->id)}}" class="btn btn-danger">
                              De Active
                          </a>
                       
                        </div>
                        </td>
                        </tr>
                        @endforeach 
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Action</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <!-- /.card -->
              </div>
             
            </div>
          </div>
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
        <script>
          $('#cat_name').keyup(function(e){
          
            $.get('{{url('check_Blogcat_slug')}}',
            {'cat_name':$('#cat_name').val()},
            function(data){
              $('#cat_slug').val(data.cat_slug);
            }
            );
    
          });
        </script>
          </x-app-layout>