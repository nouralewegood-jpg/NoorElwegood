<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('moderator');
    }

    /**
     * Display the moderator dashboard.
     */
    public function dashboard()
    {
        return view('moderator.index');
    }

    /**
     * Display the moderator profile.
     */
    public function profile()
    {
        return view('moderator.profile');
    }

    /**
     * Display a specific moderator page.
     */
    public function viewPage(string $page)
    {
        // Check if the view exists
        if (view()->exists("moderator.{$page}")) {
            return view("moderator.{$page}");
        }

        // If view does not exist, return 404
        abort(404);
    }
}
