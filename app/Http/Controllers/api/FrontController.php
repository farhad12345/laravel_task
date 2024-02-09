<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function store(Request $request)
    {
        // if (Auth::user()->can('add user')) {
        $users = new User;
        $users->name = $request->name;
        $users->email =  $request->email;
        $posts->save();
        return response()->json(['message' => 'User Created successful'], 200);
        // } else {
        //     return view('permission_denied');
        // }
    }
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit user')) {
            $users = User::find($request->post_id);

            $users->name = $request->name;
            $users->email = $request->email;
            $users->update();
            return response()->json(['status' => 'success', 'message' => 'USer Updated Successfully']);
        } else {
            return view('permission_denied');
        }
    }
}
