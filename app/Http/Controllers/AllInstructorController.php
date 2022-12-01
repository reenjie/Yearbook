<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllInstructorController extends Controller
{
    public function students(){
        return view('Students.index');
    }
}
