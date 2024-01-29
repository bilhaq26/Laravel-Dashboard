<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        try {
            $key = request()->header('key');
            if($key == '123456789'){
                $data = User::orderBy('created_at', 'DESC')->paginate(10);
                return UserResource::collection($data);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $key = request()->header('key');
            if($key == '123456789'){
                $data = User::findOrFail($id);
                return new UserResource($data);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $key = request()->header('key');
            if($key == '123456789'){
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'username' => 'required|string|max:255|unique:users',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8',
                    'address' => 'required|string|max:255',
                    'phone' => 'required|string|max:255',
                    'roles' => 'required',
                    'photo' => 'required|image|mimes:jpg,png,jpeg'
                ],[
                    'name.required' => 'Nama harus diisi',
                    'name.string' => 'Nama harus berupa string',
                    'name.max' => 'Nama maksimal 255 karakter',
                    'username.required' => 'Username harus diisi',
                    'username.string' => 'Username harus berupa string',
                    'username.max' => 'Username maksimal 255 karakter',
                    'username.unique' => 'Username sudah digunakan',
                    'email.required' => 'Email harus diisi',
                    'email.string' => 'Email harus berupa string',
                    'email.email' => 'Email harus berupa email',
                    'email.max' => 'Email maksimal 255 karakter',
                    'email.unique' => 'Email sudah digunakan',
                    'password.required' => 'Password harus diisi',
                    'password.string' => 'Password harus berupa string',
                    'password.min' => 'Password minimal 8 karakter',
                    'address.required' => 'Alamat harus diisi',
                    'address.string' => 'Alamat harus berupa string',
                    'address.max' => 'Alamat maksimal 255 karakter',
                    'phone.required' => 'Nomor telepon harus diisi',
                    'phone.string' => 'Nomor telepon harus berupa string',
                    'phone.max' => 'Nomor telepon maksimal 255 karakter',
                    'roles.required' => 'Role harus diisi',
                    'photo.required' => 'Photo harus diisi',
                    'photo.image' => 'Photo harus berupa gambar',
                    'photo.mimes' => 'Photo harus berupa jpg, png, jpeg',
                ]);

                if($validator->fails()){
                    return response()->json([
                        'status' => 'error',
                        'message' => $validator->errors()
                    ], 400);
                }else{
                    $data = new User();
                    $data->name = $request->name;
                    $data->username = $request->username;
                    $data->email = $request->email;
                    $data->password = Hash::make($request->password);
                    $data->address = $request->address;
                    $data->phone = $request->phone;
                    $data->status = $request->status ?? 'Active';

                    if ($request->hasFile('photo')) {
                        $photo = $request->file('photo');
                        $photo_name = time().'.'.$photo->getClientOriginalExtension();
                        $photo->storeAs('/storage/user/', $photo_name);
                        $data->photo = $photo_name;
                    }

                    $data->save();

                    if($request->has('roles')){
                        $data->syncRoles($request->roles);
                    }
                }



                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil ditambahkan',
                    'data' => $data
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $key = request()->header('key');
            if($key == '123456789'){
                $data = User::findOrFail($id);
                if(!$data){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data tidak ditemukan'
                    ], 404);
                }

                if ($request->hasFile('photo')) {
                    $photo = $request->file('photo');
                    $photo_name = time().'.'.$photo->getClientOriginalExtension();
                    $photo->storeAs('public/user', $photo_name);
                    $data->photo = $photo_name;
                }

                $data->update([
                    'name' => $request->name ?? $data->name,
                    'username' => $request->username ?? $data->username,
                    'email' => $request->email ?? $data->email,
                    'password' => $request->password ? Hash::make($request->password) : $data->password,
                    'address' => $request->address ?? $data->address,
                    'phone' => $request->phone ?? $data->phone,
                    'status' => $request->status ?? $data->status,
                ]);

                if($request->has('roles')){
                    $data->syncRoles($request->roles);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil diupdate',
                    'data' => $data
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 500);
        }

    }

    public function destroy($id)
    {
        try{
            $key = request()->header('key');
            if($key == '123456789'){
                $data = User::findOrFail($id);
                if(!$data){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data tidak ditemukan'
                    ], 404);
                }
                $data->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 500);
        }
    }
}
