<?php

namespace App\Http\Controllers\Api\Ref;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Ref\JenisApi as Api;
use App\Http\Controllers\Controller;

class JenisApi extends Controller
{
    public $key = '1234567890';

    public function index()
    {
        try{
            if(request()->header('key') != $this->key){
                return response()->json([
                    'message' => 'Key tidak valid'
                ], 401);
            }else{
                // jika data kosong
                if(Api::count() == 0){
                    return response()->json([
                        'message' => 'Belum ada data'
                    ], 200);
                }else{
                    // jika data tidak kosong
                    $data = Api::all();
                    return response()->json([
                        'message' => 'Berhasil menampilkan data',
                        'data' => $data
                    ], 200);
                }
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat menampilkan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            if(request()->header('key') != $this->key){
                return response()->json([
                    'message' => 'Key tidak valid'
                ], 401);
            }else{

                $validate = $request->validate([
                    'nama' => 'required|unique:jenis_apis',
                ],[
                    'nama.required' => 'Nama harus diisi',
                    'nama.unique' => 'Nama sudah ada',
                    'slug.required' => 'Slug harus diisi'
                ]);

                if(!$validate){
                    return response()->json([
                        'message' => 'Validasi gagal',
                        'error' => $validate->errors()
                    ], 400);
                }

                $data = new Api;
                $data->nama = $request->nama;
                $data->slug = Str::slug($request->nama);
                $data->save();

                return response()->json([
                    'message' => 'Berhasil menyimpan data',
                    'data' => $data
                ], 201);

            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try{
            if(request()->header('key') != $this->key){
                return response()->json([
                    'message' => 'Key tidak valid'
                ], 401);
            }else{

                $validate = $request->validate([
                    'nama' => 'required|unique:jenis_apis,nama,'.$request->id,
                ],[
                    'nama.required' => 'Nama harus diisi',
                    'nama.unique' => 'Nama sudah ada',
                    'slug.required' => 'Slug harus diisi'
                ]);

                if(!$validate){
                    return response()->json([
                        'message' => 'Validasi gagal',
                        'error' => $validate->errors()
                    ], 400);
                }

                $data = Api::find($request->id);
                $data->nama = $request->nama;
                $data->slug = Str::slug($request->nama);
                $data->save();

                return response()->json([
                    'message' => 'Berhasil menyimpan data',
                    'data' => $data
                ], 201);

            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(request()->header('key') != $this->key){
                return response()->json([
                    'message' => 'Key tidak valid'
                ], 401);
            }else{

                $data = Api::find($request->id);
                $data->delete();

                return response()->json([
                    'message' => 'Berhasil menghapus data',
                    'data' => $data
                ], 201);

            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
