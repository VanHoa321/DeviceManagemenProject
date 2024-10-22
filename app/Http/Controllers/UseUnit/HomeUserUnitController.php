<?php

namespace App\Http\Controllers\UseUnit;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeUserUnitController extends Controller
{
    public function index(){
        return view("useunit.pages.home.index");
    }
}
