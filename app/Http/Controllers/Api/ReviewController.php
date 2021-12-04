<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Review;

class ReviewController extends Controller
{
    //// method untuk menampilkan semua data product (read)
    public function index()
    {
        $reviews = Review::all(); // mengambil semua data course

        if(count($reviews) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $reviews
            ], 200);
        } // return data semua course dalam bentuk json
            
        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data course kosong
    }

    // method untuk menampilkan 1 data course (search)
    public function show($id)
    {
        $review = Review::find($id); // mencari data course berdasarkan id

        if(!is_null($review)){
            return response([
                'message' => 'Retrieve Review Success',
                'data' => $review
            ], 200);
        }// return data course yang ditemukan dalam bentuk json

        return response([
            'message' => 'Review Not Found',
            'data' => null
        ], 404); // return message saat data course tidak ditemukan       
    }

    // method untuk menambah 1 data course baru (create)
    public function store(Request $request)
    {
        $storeData = $request->all();// mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'nama_review' => 'required',
            'email_review' => 'required',
            'star_review' => 'required',	
            'deskripsi_review' => 'required',
        ]);// rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);//error invalid input

        $review = Review::create($storeData);
        return response([
            'message' => 'Add Review Success',
            'data' => $review
        ], 200);// return data course baru dalam bentuk json
    }

    // method untuk menghapus 1 data product (delete)
    public function destroy($id)
    {
        $review = Review::find($id);//cari data product berdasarkan id

        if(is_null($review)){
            return response([
                'message' => 'Review Not Found',
                'data' => null
            ], 404);
        }// message saat data course tidak dapat ditemukan
        
        if($review->delete()){
            return response([
                'message' => 'Delete Review Success',
                'data' => $review
            ], 200);
        }//message saat berhasil menghapus data course

        return response([
            'message' => 'Delete Review Failed',
            'data' => null
        ], 400);// message saat gagal menghapus data course
    }

    // method untuk mengubah 1 data course (update)
    public function update(Request $request, $id)
    {
        $review = Review::find($id);//mencari data course berdasarkan id
        if(is_null($review)){
            return response([
                'message' => 'Review Not Found',
                'data' => null
            ], 404);
        }//message saat data course tidak ditemukan

        $updateData = $request->all();// mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama_review' => 'required',
            'email_review' => 'required',
            'star_review' => 'required',	
            'deskripsi_review' => 'required',
        ]);//rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);//rule invalid input

        $review->nama_review = $updateData['nama_review'];// edit nama kelas
        $review->email_review = $updateData['email_review'];
        $review->star_review = $updateData['star_review'];
        $review->deskripsi_review = $updateData['deskripsi_review'];

        if($review->save()){
            return response([
                'message' => 'Update Review Success',
                'data' => $review
            ], 200);
        }//return data course yang telah di edit dalam bentuk json
        return response([
            'message' => 'Update Review Failed',
            'data' => null
        ], 400);//return message saat course gagal di edit
    }
}