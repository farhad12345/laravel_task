<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Traits\PermissionCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\file;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
class OrderController extends Controller
{
    public function index()
    {
        $permission = "view orders";
        // if (Auth::user()->can('view orders')) {
            $compnies =Company::get();
        return Response::view('orders.index',compact('compnies'));
        // }else{
        //     return view('permission_denied');
        // }
    }

    public function GetOrdersList(Request $request)
    {
        try{
            $orders = Order::query();
            $total =$orders->count();
            $orders = $orders->with('company')->paginate(10);
            $view = View('orders.order_html',compact('orders'))->render();
            return response()->json(['status' => 'success','html'=>$view,'total'=>$total]);
        }catch(Exception $e)
        {
            return response()->json(['status'=>'fail','msg'=>$e->getMessage().':'.$e->getLine()]);
        }

    }
    public function saveOrder(Request $request)
    {
        try {
            // if (auth()->check() && auth()->user()->can('add order')) {
                $validator = Validator::make($request->all(), [
                    'image' => 'nullable|image|max:2048',
                ]);

                if ($validator->fails()) {
                    return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
                }

                $logo_image = ''; // Initialize variable

                if ($request->hasFile('image')) {
                    $photo = $request->file('image');

                    $img_name = time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $path = public_path('images/orders/');
                    $photo->move($path, $img_name);
                    $logo_image = $img_name;
                }

                $order = new Order;
                $order->company_id = $request->company_id;
                $order->order_images = $logo_image; // Assign to the 'logo' attribute
                $order->order_no = $request->order_no;
                $order->city_from = $request->city_from;
                $order->city_to = $request->city_to;
                $order->price = $request->price;
                $order->save();

                return response()->json(['status' => 'success', 'msg' => 'Order created successfully'], 200);
            // } else {
            //     return view('permission_denied');
            // }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }


    public function DeleteOrder($id)
    {
        try{
            $order = Order::where('id',$id)->first();
            $order->delete();
            return response()->json(['status' => 'success', 'msg' => 'Order deleted Successfully']);
            }catch(Exception $e)
            {
                return response()->json(['status'=>'fail','msg'=>$e->getMessage().':'.$e->getLine()]);
            }
    }
}
