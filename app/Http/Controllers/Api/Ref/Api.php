<?php

namespace App\Http\Controllers\Api\Ref;

use App\Http\Controllers\Controller;
use App\Http\Resources\DaftarApiResource;
use App\Models\DaftarApi;
use Illuminate\Http\Request;

class Api extends Controller
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
                if(DaftarApi::count() == 0){
                    return response()->json([
                        'message' => 'Belum ada data'
                    ], 200);
                }else{
                    // jika data tidak kosong
                    $data = DaftarApi::all();
                    return DaftarApiResource::collection($data);
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
                $validate = Validator(request()->all(), [
                    'id_jenis_api' => 'required',
                    'id_perangkat_daerah' => 'required',
                    'endpoint' => 'required',
                ],[
                    'id_jenis_api.required' => 'Jenis API tidak boleh kosong',
                    'id_perangkat_daerah.required' => 'Perangkat Daerah tidak boleh kosong',
                    'endpoint.required' => 'Endpoint tidak boleh kosong',
                ]);

                if($validate->fails()){
                    return response()->json([
                        'message' => 'Terjadi kesalahan saat menambahkan data',
                        'error' => $validate->errors()
                    ], 422);
                }

                $data = new DaftarApi();
                $data->id_jenis_api = $request->id_jenis_api;
                $data->id_perangkat_daerah = $request->id_perangkat_daerah;
                $data->endpoint = $request->endpoint;
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

    public function update(Request $request)
    {
        try{
            $validate = Validator(request()->all(), [
                'id_jenis_api' => 'nullable',
                'id_perangkat_daerah' => 'nullable',
                'endpoint' => 'nullable',
            ],[
                'id_jenis_api.required' => 'Jenis API tidak boleh kosong',
                'id_perangkat_daerah.required' => 'Perangkat Daerah tidak boleh kosong',
                'endpoint.required' => 'Endpoint tidak boleh kosong',
            ]);

            if($validate->fails()){
                return response()->json([
                    'message' => 'Terjadi kesalahan saat mengubah data',
                    'error' => $validate->errors()
                ], 422);
            }

            $data = DaftarApi::find($request->id);
            $data->id_jenis_api = $request->id_jenis_api;
            $data->id_perangkat_daerah = $request->id_perangkat_daerah;
            $data->endpoint = $request->endpoint;
            $data->save();

            return response()->json([
                'message' => 'Berhasil mengubah data',
                'data' => $data
            ], 201);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengubah data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try{
            $data = DaftarApi::find($request->id);
            $data->delete();

            return response()->json([
                'message' => 'Berhasil menghapus data',
                'data' => $data
            ], 201);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
