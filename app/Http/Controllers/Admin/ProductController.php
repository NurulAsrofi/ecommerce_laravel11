<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use App\Models\Distributor;
use Illuminate\Support\Facades\DB;
use App\Http\Controller\Admin\DistributorController;




class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $data = DB::table('distributors')
                ->join('products', 'distributors.id', '=', 'products.id_distributor')
                ->select('distributors.*', 'products.*')
                ->get();

        confirmDelete('Hapus Data!', 'Apakah anda yakin ingin menghapus data ini?');
        return view('pages.admin.product.index', compact('products'));
    }

    public function create()
    {
        $distributor = Distributor::all();

        return view('pages.admin.product.create', compact('distributor'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'id_distributor' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg',
            'discount' => 'nullable|numeric|min:0|max:100', 
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back();
        }

        // Proses upload gambar
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        // Simpan data produk
        $product = Product::create([
            'id_distributor' => $request->id_distributor,
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imageName,
            'discount' => $request->discount ?? 0,
        ]);

        if ($product) {
            Alert::success('Berhasil!', 'Produk berhasil ditambahkan!');
            return redirect()->route('admin.product');
        } else {
            Alert::error('Gagal!', 'Produk gagal ditambahkan!');
            return redirect()->back();
        }
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);

        $data = DB::table('distributors')
                ->join('products', 'distributors.id', '=', 'products.id_distributor')
                ->select('distributors.*', 'products.*')
                ->where('products.id', '=', $id)
                ->first();

        return view('pages.admin.product.detail', compact('product'));
    }

    public function edit($id)
    {
        $product = product::findOrFail($id);
        $distributor = Distributor::all();

        return view('pages.admin.product.edit', compact('product', 'distributor'));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make($request->all(), [
            'id_distributor' => 'required|numeric',
            'name' => 'required',
            'price' => 'numeric',
            'category' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpeg,jpg',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back();
        }

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $oldPath = public_path('images/') . $product->image;
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images/', $imageName);
        } else {
            $imageName = $product->image;
        }

        $product->update([
            'id_distributor' => $request->id_distributor,
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imageName,
            'discount' => $request->discount ?? 0,
        ]);

        if ($product) {
            Alert::success('Berhasil!', 'Produk berhasil diperbarui!');
            return redirect()->route('admin.product');
        } else {
            Alert::error('Gagal!', 'Produk gagal diperbarui!');
            return redirect()->back();
        }
    }

    public function delete($id) 
    {
        $product = Product::findOrFail($id);

        $oldPath = public_path('images/') . $product->image;
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }

        $product->delete();

        if ($product) {
            Alert::success('Berhasil!', 'Produk berhasil dihapus!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Produk gagal dihapus!');
            return redirect()->back();
        }
    }

}
