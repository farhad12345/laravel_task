<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\PermissionRole;

class PermissionController extends Controller
{
    public  function index()
    {
        $roles = Role::all();
        $modules = Module::all();
        $role_id = 0;
        return view('admin.permission.index', compact('modules', 'roles', 'role_id'));
    }
    public function store(Request $request)
    {
        $module=Str::lower($request->module_name);

        if(Permission::where('name', 'like', '%'.$module)->exists()){
            return response()->json(['status'=>'fail','message'=>'Name already exist']);
        }
        // $permissions = Permission::where('name', 'like', '%'.$module)->get();
    //    if (count($permissions) < 1) {
        $module_id=Module::insertGetId([ 'name'=>$request->module_name, 'status'=>'1']);
        $data = [
            [
                'name' => 'view '.$module,
                'module_id'=>$module_id
            ],
            [
                'name' => 'add '.$module,
                'module_id'=>$module_id
            ],
            [
                'name' => 'edit '.$module,
                'module_id'=>$module_id
            ],
            [
                'name' => 'delete '.$module,
                'module_id'=>$module_id
            ],
        ];
       //  dd($data);
       foreach ($data as $key) {
        $permission = Permission::create([
            'name' => $key['name'],
            'guard_name' => 'web',
            'module_id' => $key['module_id']
        ]);
    }
    if($permission){
        return response()->json(['status'=>'success','message' => 'Permissions created successfully']);
    }
    
// }
    }
    public function AssignPermission(Request $request)
{
    $role_id = $request->role_id;
    $role = Role::findOrFail($role_id);

    // Clear existing role permissions
    $role->syncPermissions([]);

    // Assign new permissions
    $permissions = $request->permission;
    if (!empty($permissions)) {
        $role->givePermissionTo($permissions);
    }

    // Get the assigned permissions
    $assignedPermissions = $role->permissions;

    return response()->json([
        'message' => 'Permissions assigned successfully',
        'assigned_permissions' => $assignedPermissions
    ]);
}

    public function GetPermissions(Request $request)
    {
        $roles=Role::all();
        $modules=Module::all();
        $role_id=$request->role;
        // $role_permission=RoleHasPermission::where('role_id',$role_id)->get();
        return view('admin.permission.index',compact('modules','roles','role_id'));
    }
    public function getRolePermissions($roleId)
{
    $permissions = Role::findOrFail($roleId)->permissions;
    return response()->json(['permissions' => $permissions]);
}

}
