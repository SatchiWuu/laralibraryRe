<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Publisher::orderBy('id', 'DESC')->get();

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
        $publisher = new Publisher();

        $publisher->name = $request->name;
        $publisher->country = $request->country;
        $publisher->email = $request->email;
        $publisher->phone = $request->phone;
        $publisher->status = $request->status;


        if($publisher->images == null) {
            if(request()->has('image_upload')){
                // $imagePath = request()->file('image')->store('product', 'public');
                $publisher->images = request()->file('image_upload')->store('images', 'public');
            }
        } else {
            if(request()->has('image_upload')){
                $image_path = $publisher->images;
                Storage::delete('public/'.$image_path);
                $publisher->images = request()->file('image_upload')->store('images', 'public');
            }
        }

        // $files = $request->file('image_upload');
        // $author->images = 'storage/images/' . $files->getClientOriginalName();
        $publisher->save();
        $data = ['status' => 'saved'];


        return response()->json([
            "success" => "author created successfully.",
            "publisher" => $publisher,
            "status" => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $publisher = Publisher::where('id', $id)->first();
        return response()->json($publisher);
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
        $publisher = Publisher::find($id);
        $publisher->name = $request->name;
        $publisher->country = $request->country;
        $publisher->email = $request->email;
        $publisher->phone = $request->phone;
        $publisher->status = $request->status;


        if($publisher->images == null) {
            if(request()->has('image_upload')){
                // $imagePath = request()->file('image')->store('product', 'public');
                $publisher->images = request()->file('image_upload')->store('images', 'public');
            }
        } else {
            if(request()->has('image_upload')){
                $image_path = $publisher->images;
                Storage::delete('public/'.$image_path);
                $publisher->images = request()->file('image_upload')->store('images', 'public');
            }
        }

        // $files = $request->file('image_upload');
        // $author->images = 'storage/images/' . $files->getClientOriginalName();
        $publisher->save();

        return response()->json([
            "success" => "publisher update successfully.",
            "publisher" => $publisher,
            "status" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->delete();
		$data = array('success' => 'deleted','code'=>200);
        return response()->json($data);
    }
}
