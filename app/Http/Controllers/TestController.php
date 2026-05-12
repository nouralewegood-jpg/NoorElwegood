<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index($id)
    {
        // dd($id);
        if(view()->exists($id)){
            return view("admin.$id");
        }
        else
        {
            return view('admin.404');
        }
    }
}
