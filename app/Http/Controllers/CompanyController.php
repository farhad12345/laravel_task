<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\PermissionCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\file;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use PermissionCheck;
    public function index()
    {
        $permission = "view company";
        if (Auth::user()->can('view company')) {
            $companies = Company::select('name as title', 'id as key')->get();
            return Response::view('company.index', compact('companies'));
        } else {
            return view('permission_denied');
        }
    }

    public function SaveCompany(Request $request)
    {
        try {
            // if (Auth::user()->can('add company')) {
            $validator = Validator::make($request->all(), [
                'logo' => 'nullable|image|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            if ($request->hasFile('logo')) {
                $photo = $request->file('logo');

                $img_name = time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $path = public_path('images/companies/');
                $photo->move($path, $img_name);
                $logo_image = $img_name;
            } else {
                $logo_image = '';
            }
            $company = new Company;
            $company->name = $request->name;
            $company->logo =  $logo_image;
            $company->email = $request->email;
            $company->country_id = $request->country_code;
            $company->commercial_record_no = $request->record_no;
            $company->company_code = Str::random(8);
            $company->save();
            return response()->json(['status' => 'success', 'msg' => 'Company Created successful'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
        // }else{
        //     return view('permission_denied');
        // }
    }
    public function GetCompaniesList(Request $request)
    {
        try {
            $companies = Company::query();
            $total = $companies->count();
            $companies = $companies->paginate(10);
            $view = View('company.company_html', compact('companies'))->render();
            return response()->json(['status' => 'success', 'html' => $view, 'total' => $total]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }
    public function DeleteCompany($id)
    {
        try {
            $company = Company::findOrFail($id);

            // Delete the associated image file if it exists
            if ($company->logo) {
                $imagePath = public_path('images/companies/') . $company->logo;
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // Delete the company from the database
            $company->delete();

            return response()->json(['status' => 'success', 'msg' => 'Company deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }
    public function UpdateCompany(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'logo' => 'nullable|image|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $img_name = time() . '-' . $logo->getClientOriginalName();
                $path = public_path('images/companies/');
                $logo->move($path, $img_name);
                $data['logo']  = $img_name;
            }
            $company = Company::find($request->id);
            $company->update($data);
            return response()->json(['status' => 'success', 'msg' => 'Company Updated Successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }


    public function GetCompaniesData(Request $request)
    {
        try {
            $companies = Company::get();
            return response()->json(['status' => 'success', 'companies' => $companies]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }
}
