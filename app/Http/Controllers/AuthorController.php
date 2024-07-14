<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\User;
use Storage;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Author::orderBy('id', 'DESC')->get();

        return response()->json($data);
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
        
        $author = new Author();

        $author->lname = $request->lname;
        $author->fname = $request->fname;
        $author->gender = $request->gender;
        $author->address = $request->address;
        $author->phone = $request->phone;

        if($author->image_path == null) {
            if(request()->has('image_upload')){
                // $imagePath = request()->file('image')->store('product', 'public');
                $author->images = request()->file('image_upload')->store('images', 'public');
            }
        } else {
            if(request()->has('image_upload')){
                $image_path = $author->images;
                Storage::delete('public/'.$image_path);
                $author->images = request()->file('image_upload')->store('images', 'public');
            }
        }

        // $files = $request->file('image_upload');
        // $author->images = 'storage/images/' . $files->getClientOriginalName();
        $author->save();
        $data = ['status' => 'saved'];


        return response()->json([
            "success" => "author created successfully.",
            "author" => $author,
            "status" => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::where('id', $id)->first();
        return response()->json($author);
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
        $author = Author::find($id);
        $author->lname = $request->lname;
        $author->fname = $request->fname;
        $author->gender = $request->gender;
        $author->address = $request->address;
        $author->phone = $request->phone;

        if($author->image_path == null) {
            if(request()->has('image_upload')){
                // $imagePath = request()->file('image')->store('product', 'public');
                $author->images = request()->file('image_upload')->store('images', 'public');
            }
        } else {
            if(request()->has('image_upload')){
                $image_path = $author->images;
                Storage::delete('public/'.$image_path);
                $author->images = request()->file('image_upload')->store('images', 'public');
            }
        }

        // $files = $request->file('image_upload');
        // $author->images = 'storage/images/' . $files->getClientOriginalName();
        $author->save();

        return response()->json([
            "success" => "author update successfully.",
            "author" => $author,
            "status" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $authors = Author::findOrFail($id);
        $authors->delete();
		$data = array('success' => 'deleted','code'=>200);
        return response()->json($data);
    }
}
