<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\file;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Resume;

class AdminController extends Controller
{
    public function AllResumes()
    {
        $users = User::paginate(5);
        return view('admin.resumes.index', ['users' => $users]);
    }
    public function GetAllResumes(Request $request)
    {
        $data = Resume::with('user')->get();
        return DataTables::of($data)->make(true);
    }
    //Get User Resumes
    public function GetUserResumes($id, $template_id)
    {
        $user_resumes = Resume::where('id', $id)->where('template_id', $template_id)
            ->with('user', 'education', 'experience', 'skills', 'referances', 'projects', 'certficates', 'personal_info', 'intersts', 'template', 'languages')
            ->get();
        // return response()->json(['user_resumes' => $user_resumes]);

        return \view('admin.resumes.user-resumes', \compact('user_resumes'));
    }

    public function updateExperience(Request $request)
    {
        $data = $request->all();

        // Find the resume by user ID and template ID
        $resume = Resume::where('user_id', $data['user_id'])
            ->where('template_id', $data['template_id'])
            ->first();

        if (!$resume) {
            return response()->json(['message' => 'Resume not found'], 404);
        }

        // Loop through the experience data array
        foreach ($data['experience_id'] as $key => $experienceId) {
            // Find the specific experience record by its ID
            $experience = $resume->experience()->find($experienceId);

            if ($experience) {
                // Update the experience record with the new data
                $experience->update([
                    'position' => $data['job_title'][$key],
                    'start_date' => $data['start_date'][$key],
                    'end_date' => $data['end_date'][$key],
                    'company' => $data['company'][$key],
                    'description' => $data['description'][$key],
                ]);
            }
        }

        return response()->json(['message' => 'Experience records updated successfully']);
    }
    public function createExperience(Request $request)
    {
        $data = $request->all();

        // Find the resume by user ID and template ID
        $resume = Resume::where('user_id', $data['user_id'])
            ->where('template_id', $data['template_id'])
            ->first();

        if (!$resume) {
            return response()->json(['message' => 'Resume not found'], 404);
        }

        // Extract arrays of data from the request
        $positions = $data['job_title'];
        $startDates = $data['start_date'];
        $endDates = $data['end_date'];
        $companies = $data['company'];
        $descriptions = $data['description'];

        // Create an array to store the new experience records
        $newExperiences = [];

        // Loop through the arrays and create new experience records
        foreach ($positions as $key => $position) {
            $newExperience = [
                'position' => $position,
                'start_date' => $startDates[$key],
                'end_date' => $endDates[$key],
                'company' => $companies[$key],
                'description' => $descriptions[$key],
            ];

            // Create a new experience record and associate it with the resume
            $experience = $resume->experience()->create($newExperience);

            // Add the newly created experience to the array
            $newExperiences[] = $experience;
        }

        return response()->json(['message' => 'Experience records created successfully', 'experiences' => $newExperiences]);
    }
}
