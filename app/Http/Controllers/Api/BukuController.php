<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::orderBy('judul_buku', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan..',
            'data' => $data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataBuku = new Book;

        $rules = [
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
             'status' => false,
             'message' => $validator->errors()
            ], 400);
        }

        $dataBuku->judul_buku = $request->judul_buku;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;
        $dataBuku->save();
        return response()->json([
         'status' => true,
         'message' => 'data berhasil ditambahkan..',
            'data' => $dataBuku
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Book::find($id);
       if($data){
        return response()->json([
            'status' => true,
             'message' => 'data ditemukan..',
               'data' => $data
           ],200);
       }else{
        return response()->json([
           'status' => false,
            'message' => 'data tidak ditemukan..'
           ],404);
       }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataBuku = Book::find($id);
        if(empty($dataBuku)){
            return response()->json([
              'status' => false,
              'message' => 'data tidak ditemukan..'
            ],404);
        }
        $rules = [
            'judul_buku' =>'required',
            'pengarang' =>'required',
            'tanggal_publikasi' =>'required|date'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
           'status' => false,
           'message' => $validator->errors()
            ], 400);
        }

        $dataBuku->judul_buku = $request->judul_buku;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;
        $dataBuku->save();
        return response()->json([
            'status' => true,
            'message' => 'data berhasil diedit..',
               'data' => $dataBuku
           ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Book::find($id);
        if(empty($data)){
            return response()->json([
              'status' => false,
              'message' => 'data tidak ditemukan..'
            ],404);
        }
        $data->delete();
        return response()->json([
          'status' => true,
          'message' => 'data berhasil dihapus..'
        ],200);
    }
}
