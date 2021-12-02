<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator; //import validasi
use App\Models\User; //import model course

class UserController extends Controller
{
    public function index() //method tampil semua data product (read)
    {
        $users = User::all(); //mengambil semua data course

        if(count($users) > 0)  {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $users
            ], 200); //return data semua course dalam bentuk JSON
        }
        
        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //return message data course kosong
    }

    //method tampil 1 data course(search)
    public function show($id)
    {
        $users = User::find($id);

        if(!is_null($users))   {
            return response([
                'message' => 'Retrieve User Success',
                'data' => $users
            ], 200); //return semua data course dalam bentuk json
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 400); //return message data course kosong
    }

    //method tambah 1 data course baru (create)
    public function store(Request $request)
    {
        $storeData = $request->all(); //ambil semua input dari api client
        $validate = Validator::make($storeData, [
            'namaLengkap' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'username' => 'required',
            'noTelp' => 'required|numeric|digits_between:10,13|starts_with:08'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        $storeData['password'] = bcrypt($request->password);
        $user = User::create($storeData);
        return response([
            'message' => 'Add User Success',
            'data' => $user
        ], 200); //return message data course baru dalam bentuk json
    }

    //method hapus 1 data product (delete)
    public function destroy($id)
    {
        $user = User::find($id); //mencari data product dari id

        if(is_null($user))  {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        } //return message data course tidak ditemukan

        if($user->delete())  {
            return response([
                'message' => 'Delete User Success',
                'data' => $user
            ], 200);
        } //return message saat berhasil hapus data course

        return response([
            'message' => 'Delete User Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(is_null($user))  {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaLengkap' => ['required'],
            'email' => 'required|email:rfc,dns|unique:users,email,'.$id,
            'username' => 'required',
            'noTelp' => 'required|numeric|digits_between:10,13|starts_with:08'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $user->namaLengkap = $updateData['namaLengkap'];
        $user->email = $updateData['email'];
        $user->username = $updateData['username'];
        $user->noTelp = $updateData['noTelp'];
        // $user->password = bcrypt($updateData['password']);

        if($user->save())  {
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }
        return response([
            'message' => 'Update User Failed',
            'data' => null,
        ], 400);
    }
}