<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $fillable = ['merek','model','nomor_plat','tarif_sewa', 'image', 'user_id'];

    public function pinjam(){
        return $this->hasOne(Pinjam_mobil::class, 'mobil_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}