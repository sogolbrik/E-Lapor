<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function create()
    {
        return view("warga.create");
    }

    public function store(Request $request){
        
    }
}
