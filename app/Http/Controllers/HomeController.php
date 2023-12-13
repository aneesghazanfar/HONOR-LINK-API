<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }





    public function loginCheck(Request $request)
    {

        dd("loginCheck");
        // Your logic here to handle login check
        // Use $request->input('id') and $request->input('pass') to get the input values
        
        // Simulating the response based on your AJAX code logic
        // $status = 4; // Assuming the login is successful

        // return response()->json(['status' => $status]);
    }
}
