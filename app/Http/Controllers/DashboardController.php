<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Mobil;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function view(){
        $mobil = Mobil::with('pinjam')->with('user')->get()->reject(function($value){
            return $value->user_id == Auth::user()->id;
        });
        $mobilsTersedia = Mobil::with('pinjam')->with('user')->get()->reject(function($value){
            return $value->user_id == Auth::user()->id;
        })->reject(function($value){
            return $value->pinjam != null;
        });
        return Inertia::render('Dashboard', [
            'mobils'=>$mobil,
            'mobilsTersedia'=>$mobilsTersedia
        ]);
    }
    public function search(Request $request){
        // dd($request->all());
        $mobil = Mobil::with('pinjam')->with('user')->get()->reject(function($value){
            return $value->user_id == Auth::user()->id;
        });
        if ($request->model == '') {
            $mobil = Mobil::with('pinjam')->with('user')->where('merek', 'LIKE', "%$request->merek%")->get()->reject(function($value){
                return $value->user_id == Auth::user()->id;
            });
        }else if($request->merek == ''){
            $mobil = Mobil::with('pinjam')->with('user')->where('model', 'LIKE', "%$request->model%")->get()->reject(function($value){
                return $value->user_id == Auth::user()->id;
            });
        }else{
            $mobil = Mobil::with('pinjam')->with('user')->where('model', 'LIKE', "%$request->model%")->where('merek', 'LIKE', "%$request->merek%")->get()->reject(function($value){
                return $value->user_id == Auth::user()->id;
            });
        }
        if ($request->tersedia) {
            return $mobil->reject(function($value){
                return $value->pinjam != null;
            });
        }else{
            return $mobil;
        }
    }
}
