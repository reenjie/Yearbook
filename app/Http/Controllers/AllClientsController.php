<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllClientsController extends Controller
{
    public function yearbook(){
        
   return view('Yearbook.index');
    }
}
