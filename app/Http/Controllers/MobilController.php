<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Pinjam_mobil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobil = Mobil::where('user_id', Auth::user()->id)->with('pinjam')->get();
        return Inertia::render('Mobil/MyCar',[
            'mobils'=>$mobil
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Mobil/CreateCar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = $request->file('image')->store('images');
        Storage::disk('public')->put('images', $request->file('image'));
        Mobil::create([
            'merek'=>$request->merek,
            'model'=>$request->model,
            'nomor_plat'=>$request->nomor_plat,
            'tarif_sewa'=>$request->tarif_sewa,
            'user_id'=>Auth::user()->id,
            'image'=>$store,
        ]);
        return back()->with('message', 'Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mobil = Mobil::with('user')->findOrFail($id);
        return Inertia::render('Mobil/Show', [
            'mobil'=>$mobil
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mobil = Mobil::with('user')->findOrFail($id);

        if (!Gate::allows('owner', $mobil->user)) {
            abort(403);
        }
        return Inertia::render('Mobil/EditCar', [
            'mobil'=>$mobil
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mobil = Mobil::with('user')->findOrFail($id);

        if (!Gate::allows('owner', $mobil->user)) {
            abort(403);
        }
        $pinjam = Pinjam_mobil::where('mobil_id', $id)->first();
        if($pinjam != null){
            return back()->with('danger', 'Mobil Sedang Disewa');
        }else{
            Mobil::find($id)->delete();
            return back()->with('message', 'Mobil Berhasil Dihapus');
        }
    }
    public function updateData(Request $request, $id){
        // dd($request->all());
                $mobil = Mobil::with('user')->findOrFail($id);

        if (!Gate::allows('owner', $mobil->user)) {
            abort(403);
        }
        if(isset($request->image)){
            $mobil = Mobil::find($id);
            if (Storage::disk('public')->exists($mobil->image) && $mobil->image != 'images/mobil.webp') {
                Storage::disk('public')->delete($mobil->image);
            }
            $store = $request->file('image')->store('images');
            Storage::disk('public')->put('images', $request->file('image'));
            $mobil->update([
                'merek'=>$request->merek,
                'model'=>$request->model,
                'nomor_plat'=>$request->nomor_plat,
                'tarif_sewa'=>$request->tarif_sewa,
                'image'=>$store,
            ]);
        }else{
            Mobil::find($id)->update([
                'merek'=>$request->merek,
                'model'=>$request->model,
                'nomor_plat'=>$request->nomor_plat,
                'tarif_sewa'=>$request->tarif_sewa,
            ]);
        }
        return back()->with('message', 'Data Berhasil Diubah');
    }
}
