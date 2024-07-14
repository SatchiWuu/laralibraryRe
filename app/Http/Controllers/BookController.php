<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::orderBy('id', 'DESC')->get();

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
        $book = new  Book();

        $book->title = $request->title;

        $book->publication = $request->publication;
        $book->genre= $request->genre;
        $book->language = $request->language;
        $book->reviews = $request->reviews;
        $book->summary = $request->summary;

        $book->author_id = $request->authorBox;
        $book->publisher_id = $request->publisherBox;

        if($book->image_path == null) {
            if(request()->has('image_upload')){
                // $imagePath = request()->file('image')->store('product', 'public');
                $book->images = request()->file('image_upload')->store('images', 'public');
            }
        } else {
            if(request()->has('image_upload')){
                $image_path = $book->images;
                Storage::delete('public/'.$image_path);
                $book->images = request()->file('image_upload')->store('images', 'public');
            }
        }

        // $files = $request->file('image_upload');
        // $author->images = 'storage/images/' . $files->getClientOriginalName();
        $book->save();
        $data = ['status' => 'saved'];


        return response()->json([
            "success" => "Book created successfully.",
            "book" => $book,
            "status" => 200
        ]);
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
