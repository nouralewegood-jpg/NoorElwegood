<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IconsController extends Controller
{
    /**
     * عرض مكتبة الأيقونات
     */
    public function index()
    {
        return view('admin.icons.index');
    }
}
