<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produk     = Produk::get();
        return view('produk.show', compact('produk'));
    }

    public function create(Request $request)
    {
        $produk     = Produk::where('id', $request->id)->first();
        // return $produk;
        return view('produk.create', compact('produk'));
    }

    public function store(Request $request)
    {
        if($request->id){
            $produk = Produk::where('id', $request->id)->update([
                'name'          => $request->name,
                'komisi'        => $request->komisi,
                'harga'         => $request->harga,
                'exp_referral'  => $request->exp_referral,
                'template'      => $request->template,
                'created_at'    => $request->created_at,
            ]);
        }else{
            $produk = Produk::insert([
                'name'          => $request->name,
                'user_id'       => Auth::user()->id,
                'komisi'        => $request->komisi,
                'harga'         => $request->harga,
                'exp_referral'  => $request->exp_referral,
                'template'      => $request->template,
                'created_at'    => $request->created_at,
            ]);
        }
        return redirect('produk')->with('created', 'Produk Berhasil Dibuat');
    }

    public function hapus(Request $request)
    {
        $remove     = Produk::where('id', $request->id)->delete();
        return redirect('produk')->with('remove', 'Produk Berhasil Dihapus');
    }
}
