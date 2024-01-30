<?php

namespace App\Http\Controllers\Api\Ref;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ref\PerangkatDaerah as RefPerangkatDaerah;

class PerangkatDaerah extends Controller
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
                if(RefPerangkatDaerah::count() == 0){
                    return response()->json([
                        'message' => 'Belum ada data'
                    ], 200);
                }else{
                    // jika data tidak kosong
                    $data = RefPerangkatDaerah::paginate(10);
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
                    'nama' => 'required|unique:ref_perangkat_daerah,nama',
                    'url' => 'required|unique:ref_perangkat_daerah,url|url',
                ],[
                    'nama.required' => 'Nama tidak boleh kosong',
                    'nama.unique' => 'Nama sudah ada',
                    'url.required' => 'URL tidak boleh kosong',
                    'url.unique' => 'URL sudah ada',
                    'url.url' => 'URL tidak valid'
                ]);

                if(!$validate){
                    return response()->json([
                        'message' => 'Validasi gagal',
                        'error' => $validate->errors()
                    ], 400);
                }

                $data = new RefPerangkatDaerah;
                $data->nama = $request->nama;
                $data->slug = Str::slug($request->nama);
                $data->url = $request->url;
                $data->save();

                return response()->json([
                    'message' => 'Berhasil menambahkan data',
                    'data' => $data
                ], 201);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            if(request()->header('key') != $this->key){
                return response()->json([
                    'message' => 'Key tidak valid'
                ], 401);
            }else{
                $validate = $request->validate([
                    'nama' => 'required|unique:ref_perangkat_daerah,nama,'.$id,
                    'url' => 'required|unique:ref_perangkat_daerah,url,'.$id.'|url',
                ],[
                    'nama.required' => 'Nama tidak boleh kosong',
                    'nama.unique' => 'Nama sudah ada',
                    'url.required' => 'URL tidak boleh kosong',
                    'url.unique' => 'URL sudah ada',
                    'url.url' => 'URL tidak valid'
                ]);

                if(!$validate){
                    return response()->json([
                        'message' => 'Validasi gagal',
                        'error' => $validate->errors()
                    ], 400);
                }

                $data = RefPerangkatDaerah::find($id);
                $data->nama = $request->nama;
                $data->slug = Str::slug($request->nama);
                $data->url = $request->url;
                $data->save();

                return response()->json([
                    'message' => 'Berhasil mengubah data',
                    'data' => $data
                ], 201);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengubah data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try{
            if(request()->header('key') != $this->key){
                return response()->json([
                    'message' => 'Key tidak valid'
                ], 401);
            }else{
                $data = RefPerangkatDaerah::find($id);
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
