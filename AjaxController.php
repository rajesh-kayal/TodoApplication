<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(){
        return view('ajax/index');
    }
    public function users(){
        return view('users/users');

    }
}
