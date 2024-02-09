<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\PermissionCheck;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\file;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    use PermissionCheck;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $permission = "view post";
        if (Auth::user()->can('view post')) {
        $categories=Category::select('name as title','id as key')->get();
        $posts=Post::paginate(3);
        return Response::view('admin.posts.index',compact('categories','posts'));
        }else{
            return view('permission_denied');
        }
    }
    public function dataTable()
    {
    $data = Post::get(); // Replace with your own model
        return DataTables::of($data)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = "add post";
        // if ($this->hasPermission($permission)){
            if (Auth::user()->can('add post')) {
        $categories=Category::select('name as title','id as key')->get();
        return Response::view('admin.posts.create',compact('categories'));
        }else{
            return view('permission_denied');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('add post')) {
        $content = $request->description;
         if($request->hasFile('photo')){
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->storeAs('public/posts', $imageName);
            $blog_image = $imageName;
            }else{
                $blog_image = '';
            }
        $posts = new Post;
        $posts->title = $request->title;
        $posts->image =  $blog_image;
        $posts->slug = Str::slug($request->title);
        $posts->category_id = $request->category_id;
        $posts->title = $request->title;
        $posts->description = $content;
        $posts->save();
        return response()->json(['message' => 'Post Created successful'], 200);
    }else{
        return view('permission_denied');
    }
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

        $posts=Post::find($id);
        return response()->json(['status' => 'success', 'posts' => $posts]);
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
        if (Auth::user()->can('edit post')) {
        $posts=Post::find($request->post_id);
        if($request->hasFile('photo')) {
            $file_name = time().'.'.$request->photo->extension();
            $path = $request->file('photo')->storeAs('public/posts',$file_name);
            $posts->image=$file_name;
            $Image = str_replace('/storage', '', $request->old_image);
            #Using storage
            if(Storage::exists('public/posts/' . $Image)){
            $delete= Storage::delete('/public/posts/' . $Image);
            }
        }
        $posts->title=$request->title;
        $posts->description=$request->description;
        $posts->category_id=$request->category_id;
        $posts->update();
        return response()->json(['status' => 'success', 'message' => 'Post Updated Successfully']);
    }else{
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
        if (Auth::user()->can('delete post')) {
        $posts=Post::find($id);
        if($posts->image)
        {
            if(Storage::exists('public/posts/' . $posts->image)){
            $delete= Storage::delete('/public/posts/' . $posts->image);
            }
        }
        $posts->delete();
        return redirect()->back()->with('success','Post deleted Successfully');
    }else{
        return view('permission_denied');
    }
    }
       //Ck Editor Images Upload
       public function storeImage(Request $request)
       {
           $file=$request->upload;
           $filename=$file->getClientOriginalName();
           $new_name=time().$filename;
           $dir="ckeditor/images/";
          $file->move($dir,$new_name);
          $url=asset('ckeditor/images/'.$new_name);
         $CkeditorFuncNum=$request->input('CKEditorFuncNum');
   
            $status="<script>window.parent.CKEDITOR.tools.callFunction('$CkeditorFuncNum','$url','File Uploaded Succesfully')</script>";
          echo $status;
          return response()->$status;
   
       }
}
