<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjam_mobil;
use App\Models\Mobil;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class PinjamMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinjam = Pinjam_mobil::where('user_id', Auth::user()->id)->with('mobil')->get();
        return Inertia::render('Pinjam/Index', [
            'pinjaman'=>$pinjam
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->durasi);
        $pinjam = Pinjam_mobil::create([
           'mobil_id'=>$request->id,
           'mulai'=>$request->mulai,
           'selesai'=>$request->selesai,
           'user_id'=>Auth::user()->id,
           'status'=>'Butuh Konfirmasi',
       ]);
        return redirect()->route('pinjam.index')->with('warning', 'Butuh Konfirmasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pinjam = Pinjam_mobil::with([
            'mobil'=>function($mobil){
                $mobil->with('user');
            }
        ])->find($id);
        if (!Gate::allows('owner', $pinjam->mobil->user)) {
            abort(403);
        }
        $mobil = Pinjam_mobil::with('user')->with([
            'mobil'=>function($mobil){
                $mobil->with('user');
            }
        ])->findOrFail($id);
        return Inertia::render('Pinjam/Show', [
            'mobil'=>$mobil
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pinjam = Pinjam_mobil::with([
            'mobil'=>function($mobil){
                $mobil->with('user');
            }
        ])->find($id);
        if (!Gate::allows('owner', $pinjam->mobil->user)) {
            abort(403);
        }
        $pinjam->update([
            'status'=>'Sudah Dikonfirmasi'
        ]);
        return back()->with('message', 'Konformasi Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // $pinjam = Pinjam_mobil::with([
        //     'mobil'=>function($mobil){
        //         $mobil->with('user');
        //     }
        // ])->with('user')->find($id);
        // dd($pinjam);
        // if (!Gate::allows('else', $pinjam->user)) {
        //     abort(403);
        // }
        $arr = collect([]);
        $pinjam = Pinjam_mobil::with('mobil')->where('user_id', Auth::user()->id)->get();
        foreach($pinjam as $data){
            if ($data->mobil->nomor_plat == $request->nomor_plat) {
                $arr->push($data->id);
                Pinjam_mobil::find($data->id)->delete();
            }
        }
        if ($arr->isEmpty()) {
            return back()->with('danger','Nomor tidak ditemukan');
        }
        return back()->with('message','Berhasil Dikembalikan');
    }
}
