<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //PHP/Laravel 19 課題 2021.9.18
    public function index(Request $request)
    {
        $profile = Profile::find($request->id);
        dd($profile);
        return view('admin.profile.index', ['form' => $profile]); 
    }
}
