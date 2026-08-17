<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['aduan_id', 'user_id', 'tanggapan', 'foto_bukti', 'status_sebelumnya', 'status_setelahnya'])]
#[Guarded('id')]
class Tanggapan extends Model
{
    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
