<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.permission.roles');
    }
    public function GetRoles()
    {
        $data=Role::all();
        return DataTables::of($data)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Role = Role::create([
            'name' => $request->role_name,
            'guard_name'=>'web',
            'created_at'=>date('Y-m-d H:m:s')
        ]);
        return response()->json(['message' => 'Role Created successful'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles=Role::find($id);
        return response()->json(['status' => 'success', 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data=[
            'name'=>$request->role_name,
        ];
        $update= Role::where('id', $request->role_id)
        ->update($data);
        return response()->json(['status' => 'success','message'=>'Roles Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roles=Role::find($id);
        $roles->delete();
        return response()->json(['status' => 'success','message'=>'Roles Deleted Successfully']);
    }
     //de_Active_role
     public function de_Active_role($id)
     {
         $data=[
             'status'=>0
         ];
         Module::where('id', $id)->update($data);
         alert::success('Updated  Successfully');
         return redirect()->back();
     }
}
