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
        $compnies = Company::get();
        return Response::view('orders.index', compact('compnies'));
        // }else{
        //     return view('permission_denied');
        // }
    }

    public function GetOrdersList(Request $request)
    {
        try {
            $orders = Order::query();
            $total = $orders->count();
            $orders = $orders->with('company')->paginate(10);
            $view = View('orders.order_html', compact('orders'))->render();
            return response()->json(['status' => 'success', 'html' => $view, 'total' => $total]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
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
        try {
            $order = Order::findOrFail($id);
            // Delete the associated image file if it exists
            if ($order->order_images) {
                $imagePath = public_path('images/orders/') . $order->order_images;
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            // Delete the order from the database
            $order->delete();
            return response()->json(['status' => 'success', 'msg' => 'Order deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }
    public function UpdateOrder(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }


            $order = Order::findOrFail($request->id);

            // Check if a new image is present in the request
            if ($request->hasFile('image')) {
                // Upload the new image
                $newImage = $request->file('image');
                $newImageName = time() . '-' . $newImage->getClientOriginalName();
                $path = public_path('images/orders/');
                $newImage->move($path, $newImageName);

                // Delete the old image if it exists
                if ($order->image) {
                    $oldImagePath = public_path('images/orders/') . $order->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                // Update the order with the new image
                $order->order_images = $newImageName;
            }

            $order->update([
                'company_id' => $request->company_id,
                'order_no' => $request->order_no,
                'city_from' => $request->city_from,
                'city_to' => $request->city_to,
                'price' => $request->price,
            ]);

            return response()->json(['status' => 'success', 'msg' => 'Order Updated Successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }
    public function GetOrderData(Request $request)
    {
        try {
            $Orders = Order::get();
            return response()->json(['status' => 'success', 'Orders' => $Orders]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage() . ':' . $e->getLine()]);
        }
    }
}
