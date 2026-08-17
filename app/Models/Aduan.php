<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tiket', 'user_id', 'desa_id', 'kategori_id', 'judul', 'deskripsi', 'latitude', 'longitude', 'detail_lokasi', 'foto', 'is_anonymous', 'status'])]
#[Guarded('id')]
class Aduan extends Model
{
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriAduan()
    {
        return $this->belongsTo(KategoriAduan::class, 'kategori_id');
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'aduan_id');
    }
}
