<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    //munculkan semua data dari database
   public function index(){
    //buat variabel untuk menampung semua isi data
    $product = Product::all();

    //bikin respon yang akan di laksanakan setelah mengambil semua data
    return response()->json([
        "message" => "Sukses di tampilkan",
        "code" => 200,
        "data" => $product
    ]);
   }

   //buatkan funsi mengambil data by id
   public function show($id){
    //ambil isi product atau temukan berdasarkan id
    $product = Product::find($id);

    //panggil respon json etelah product berdasakan id di temukan
    return response()->json([
        "message" => "data by id berhasil di tampilkan",
        "code" => 200,
        "data" => $product
    ]);
   }

   //fungsi untuk menambah data
   public function store(Request $request){
    //validasi terlebih dahulu data mana yang mau di tambahkan
    $data = $request->validate([
        "penerbit" => "required",
        "tema" => "required",
        "judul" => "required",
        //pada validasi harga di tambahkan required|numeric karena pada harga ada nomor
        //pada validasi gambar di tambahkan required|max:5136 untuk membatasi ukuran file yg akan di inpu
        "harga" => "required|numeric",
        "gambar" => "required|max:5136",
    ]);
    //dan untuk validasi poto di tambahkan kondisi untuk mengkonvert file poto tersebut
    if($request->hasFile('gambar')){
        $image = $request->file('gambar');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'),$imageName);
        $data['gambar'] = $imageName;
    }
    $product = Product::create($data);

    return response()->json([
        "message" => "data sudah di tambahkan",
        "code" => 200,
        "data" => $product
    ]);
   }

   //function untuk mengedit data berdasarkan id
   public function edit(Request $request, $id){
    //pada metode ini juga harus di validasi dulu
    $data = $request->validate([
        "penerbit" => "required",
        "tema" => "required",
        "judul" => "required",
        //pada validasi harga di tambahkan required|numeric karena pada harga ada nomor
        //pada validasi gambar di tambahkan required|max:5136 untuk membatasi ukuran file yg akan di inpu
        "harga" => "required|numeric",
        "gambar" => "required|max:5136",
    ]);
     //dan untuk validasi poto di tambahkan kondisi untuk mengkonvert file poto tersebut
     if($request->hasFile('gambar')){
        $image = $request->file('gambar');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'),$imageName);
        $data['gambar'] = $imageName;
    }
    $product = Product::create($data);

    return response()->json([
        "message" => "berhasil di edit",
        "code" => 200,
        "data" => $product
    ]);
   }

   //function untuk delete by ud
   public function delete($id){
    $product = Product::find($id);
    $product->delete();

    //buatkan repon jsonya
    return response()->json([
        "message" => 'berhasil di hapus',
        "code" => 200,
    ]);
   }

   //funsi untuk menampilkan gambar
   public function image($filaname){
    $path = public_path("images" , $filaname );

    //jika hasil outpunya kosong
    if(!file_exists($path)){
        abort(404);
   }

   $file = file_get_contents($path);
   $type = mime_content_type($path);

   return response($file)->header('Content-Type', $type);
}
}