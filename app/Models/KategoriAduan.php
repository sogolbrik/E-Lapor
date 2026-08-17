<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'deskripsi', 'is_active'])]
#[Guarded(['id'])]
class KategoriAduan extends Model
{
    //
}
