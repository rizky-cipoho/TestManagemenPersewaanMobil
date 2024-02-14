<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam_mobil extends Model
{
    use HasFactory;
    protected $fillable = ['mobil_id','mulai','selesai','status','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function mobil(){
        return $this->belongsTo(Mobil::class);
    }
}
