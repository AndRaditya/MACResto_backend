<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // method untuk menampilkan semua data product (read)
    public function index()
    {
        $reservations = Reservation::all(); // mengambil semua data reservation

        if(count($reservations) > 0)
        {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $reservations
            ], 200);
        } // return data semua reservation dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data reservation kosong
    }

    // method untuk menampilkan 1 data reservation (show)
    public function show($id)
    {
        $reservation = Reservation::find($id); // mencari data Reservation berdasarkan id

        if(!is_null($reservation))
        {
            return response([
                'message' => 'Retrieve Reservation Success',
                'data' => $reservation
            ], 200);
        } // return data reservation yang ditemukan dalam bentuk json

        return response([
            'message' => 'Reservation Not Found',
            'data' => null
        ], 404); // return message saat data reservation tidak ditemukan
    }

    // method untuk menambah 1 data reservation baru (create)
    public function store(Request $request)
    {
        $storeData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'nama_reservator' => 'required|max:100|unique:reservations',
            'no_telp' => 'required || numeric || digits_between:10,13',
            'no_meja' => 'required|numeric'
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input
        
        $reservation = Reservation::create($storeData);
        return response([
            'message' => 'Add Reservation Success',
            'data' => $reservation
        ], 200); // return data reservation baru dalam bentuk json
    }

    // method untuk menghapus 1 data product (delete)
    public function destroy($id)
    {
        $reservation = Reservation::find($id); // mencari data product berdasarkan id

        if(is_null($reservation))
        {
            return response([
                'message' => 'Reservation Not Found',
                'data' => null
            ], 404); 
        } // return message saat data reservation tidak ditemukan

        if($reservation->delete())
        {
            return response([
                'message' => 'Delete Reservation Success',
                'data' => $reservation
            ], 200); 
        } // return message saat berhasil menghapus data reservation

        return response([
            'message' => 'Delete Reservation Failed',
            'data' => null
        ], 400); // return message saat gagal menghapus data reservation
    }

    // method untuk mengubah 1 data reservation (update)
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        if(is_null($reservation))
        {
            return response([
                'message' => 'Reservation Not Found',
                'data' => null
            ], 404); 
        } // return message saat data reservation tidak ditemukan

        $updateData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama_reservator' => ['max:100', 'required', Rule::unique('reservations')->ignore($reservation)],
            'no_telp' => 'required || numeric || digits_between:10,13',
            'no_meja' => 'required|numeric'
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $reservation->nama_reservator = $updateData['nama_reservator'];
        $reservation->no_telp = $updateData['no_telp'];
        $reservation->no_meja = $updateData['no_meja'];

        if($reservation->save())
        {
            return response([
                'message' => 'Update Reservation Success',
                'data' => $reservation
            ], 200);
        } // return data reservation yang telah diedit dalam bentuk json
        return response([
            'message' => 'Update Reservation Failed',
            'data' => null
        ], 400); // return message saat reservation gagal diedit
    }
}
