<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if(auth()->attempt(array('email' => $email, 'password' => $password)))
        {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        }
        else
        {
            return response()->json([ [3] ]);
        }
    }

    public function check() {
        $user = Auth::user();
        return view('welcome');
    }

    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;

        if(auth()->attempt(array('email' => $email, 'password' => $password)))
        {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        }
        else
        {
            return response()->json([ [3] ]);
        }
    }

    public function register(Request $request) {
        DB::beginTransaction();

        try {
            // Create a new User
            $user = new User([
                'name' => $request->fname . ' ' . $request->lname,
                'email' => $request->email,
                'password' => bcrypt($request->input('password')),
                'role' => 1
            ]);

            $user->save();

            // Create a new Client
            $client = new Client();
            $client->id = $user->id;
            $client->lname = $request->lname;
            $client->fname = $request->fname;
            $client->address = $request->addressline;
            $client->phone = $request->phone;
            $client->age = $request->age;
            $client->gender = $request->gender;

            if ($request->has('image_upload')) {
                $files = $request->file('image_upload');
                $client->images = 'images/' . $files->getClientOriginalName();
                // Save the image to storage
                Storage::put(
                    'public/images/' . $files->getClientOriginalName(),
                    file_get_contents($files)
                );
            }

            $client->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $client->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $client->save();

            // Commit the transaction
            DB::commit();

            return response()->json([
                "success" => "Customer created successfully.",
                "client" => $client,
                "status" => 200
            ]);

        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception as needed (logging, notifying user, etc.)
            return response()->json([
                "error" => "Failed to create customer.",
                "message" => $e->getMessage(),
                "status" => 500
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
