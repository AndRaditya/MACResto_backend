<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class OrderController extends Controller
{
    // method untuk menampilkan semua data product (read)
    public function index()
    {
        $orders = Order::all(); // mengambil semua data order

        if(count($orders) > 0)
        {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $orders
            ], 200);
        } // return data semua order dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data order kosong
    }

    // method untuk menampilkan 1 data order (show)
    public function show($id)
    {
        $order = Order::find($id); // mencari data order berdasarkan id

        if(!is_null($order))
        {
            return response([
                'message' => 'Retrieve Order Success',
                'data' => $order
            ], 200);
        } // return data order yang ditemukan dalam bentuk json

        return response([
            'message' => 'Order Not Found',
            'data' => null
        ], 404); // return message saat data order tidak ditemukan
    }

    // method untuk menambah 1 data order baru (create)
    public function store(Request $request)
    {
        $storeData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'nama_pemesan' => 'required',
            'makanan' => 'required',
            'jumlah_makanan' => 'required|numeric|min:1',
            'minuman' => 'required',
            'jumlah_minuman' => 'required|numeric|min:1'
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input
        
        $order = Order::create($storeData);
        return response([
            'message' => 'Add Order Success',
            'data' => $order
        ], 200); // return data order baru dalam bentuk json
    }

    // method untuk menghapus 1 data product (delete)
    public function destroy($id)
    {
        $order = Order::find($id); // mencari data product berdasarkan id

        if(is_null($order))
        {
            return response([
                'message' => 'Order Not Found',
                'data' => null
            ], 404); 
        } // return message saat data order tidak ditemukan

        if($order->delete())
        {
            return response([
                'message' => 'Delete Order Success',
                'data' => $order
            ], 200); 
        } // return message saat berhasil menghapus data order

        return response([
            'message' => 'Delete Order Failed',
            'data' => null
        ], 400); // return message saat gagal menghapus data order
    }

    // method untuk mengubah 1 data order (update)
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if(is_null($order))
        {
            return response([
                'message' => 'Order Not Found',
                'data' => null
            ], 404); 
        } // return message saat data order tidak ditemukan

        $updateData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama_pemesan' => 'required',
            'makanan' => 'required',
            'jumlah_makanan' => 'required|numeric|min:1',
            'minuman' => 'required',
            'jumlah_minuman' => 'required|numeric|min:1'
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $order->nama_pemesan = $updateData['nama_pemesan'];  
        $order->makanan = $updateData['makanan'];
        $order->jumlah_makanan = $updateData['jumlah_makanan'];
        $order->minuman = $updateData['minuman'];
        $order->jumlah_minuman = $updateData['jumlah_minuman'];

        if($order->save())
        {
            return response([
                'message' => 'Update Order Success',
                'data' => $order
            ], 200);
        } // return data order yang telah diedit dalam bentuk json
        return response([
            'message' => 'Update Order Failed',
            'data' => null
        ], 400); // return message saat order gagal diedit
    }
}
