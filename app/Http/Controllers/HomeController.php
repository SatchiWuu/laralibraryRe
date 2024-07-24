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

    public function bookDetails() {
        $query = "
        SELECT b.id, b.title, b.genre, b.summary, b.language, au.lname, au.fname, b.images
        FROM books b
        INNER JOIN authors au ON au.id = b.author_id
        INNER JOIN publisher p ON p.id = b.publisher_id
    ";
    
    $data = DB::select($query);
    
    return response()->json($data);
    }
}
