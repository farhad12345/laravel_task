<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\file;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        $roles = Role::get();
        return view('admin.users.index', ['users' => $users,'roles'=>$roles]);
    }
    public function getUsersData(Request $request)
    {
        $data = User::get(); // Replace with your own model
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
        // Validate the request data...

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // Assign a role (e.g., 'user') to the newly created user
        $user->assignRole('user');

        return response()->json(['message' => 'User created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['status' => 'success', 'users' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Delete the user and related records (e.g., resume, experiences, etc.)
        // ...

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }



    public function updateProfile(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        if ($user) {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:6|confirmed',
                'old_password' => ['nullable', 'string', function ($attribute, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->password)) {
                        $fail('The old password is incorrect.');
                    }
                }],
            ]);

            // Update the user's profile information
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            if ($request->filled('password')) {
                $user->password = bcrypt($validatedData['password']);
            }
            $user->save();

            return response()->json(['message' => 'Profile updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }
    public function test()
    {
        // Assuming you have the necessary models imported and the user ID available
        $user = User::find(1);

        // Create a new resume for the user
        $resume = $user->resumes()->create([
            'template_id' => 1,
            'title' => 'test',
            'summary' => 'test summary',
        ]);

        // Insert multiple experiences
        $experiences = [
            [
                'company' => 'Company A',
                'position' => 'Position A',
                'start_date' => '2022-01-01',
                'end_date' => '2022-12-31',
                'description' => 'Experience A description',
            ],
            [
                'company' => 'Company B',
                'position' => 'Position B',
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'description' => 'Experience B description',
            ],
        ];

        foreach ($experiences as $experienceData) {
            $experience = $resume->experience()->create($experienceData);
        }

        // Insert multiple skills
        $skills = ['Skill A', 'Skill B', 'Skill C'];

        foreach ($skills as $skill) {
            $resume->skills()->create(['skill' => $skill]);
        }
        return response()->json(['message' => 'Resume Created successfully'], 200);
    }

    public function resumes($id)
    {
        $user = User::findOrFail($id);
        $resumes = $user->resumes()->get();
        return view('admin.users.resumes', compact('user', 'resumes'));
    }
}
