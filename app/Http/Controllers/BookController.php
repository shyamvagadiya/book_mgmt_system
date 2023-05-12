<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     * @param  \Illuminate\Http\Request  $request = search (for searching specific data from database)
     * @return \Illuminate\Http\Response : List of Books
     */
    public function index(Request $request)
    {
        if($request->has("search") && $request->search != null)
        {
            $books=Book::search($request->search)->paginate(10);
        }
        else{
            $books=Book::paginate(10);   
        }
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created book in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response: success response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>"required",
            'author'=>"required",
            'genre'=>"required",
            'description'=>"required",
            'isbn'=>"required",
            'published'=>"required",
            'publisher'=>"required",
            'image'=>"required"
        ]);

        $img = $request->image;

        $folderPath = public_path()."/images/";

        $imageParts = explode(";base64,", $img);
        $imageTypeAux = explode("image/", $imageParts[0]);
        $imageType = $imageTypeAux[1];
        $imageBase64 = base64_decode($imageParts[1]);
        $imageName=uniqid() . '.'.$imageType;
        $file = $folderPath . $imageName;
        file_put_contents($file, $imageBase64);
        $url=url("images/".$imageName);

        $addBook=new Book;
        $addBook->title=$request->title;
        $addBook->author=$request->author;
        $addBook->genre=$request->genre;
        $addBook->description=$request->description;
        $addBook->isbn=$request->isbn;
        $addBook->published=$request->published;
        $addBook->publisher=$request->publisher;
        $addBook->image=$url;
        $addBook->save();
        return response()->json(['status'=>200,'message'=>'Book added succesfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified book in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id = for identification of row
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'title'=>"required",
            'author'=>"required",
            'genre'=>"required",
            'description'=>"required",
            'isbn'=>"required",
            'published'=>"required",
            'publisher'=>"required"
        ]);

        $updateBook=Book::find($id);
        $updateBook->title=$request->title;
        $updateBook->author=$request->author;
        $updateBook->genre=$request->genre;
        $updateBook->description=$request->description;
        $updateBook->isbn=$request->isbn;
        $updateBook->published=$request->published;
        $updateBook->publisher=$request->publisher;
        if($request->has('image') && $request->image != null)
        {
            $getImageName=explode("/",$request->imgshow);
            if (file_exists( public_path() . '/images/'.$getImageName[count($getImageName)-1])) {
                unlink(public_path() . '/images/'.$getImageName[count($getImageName)-1]);
            }
            $img = $request->image;
            $folderPath = public_path()."/images/";
            $imageParts = explode(";base64,", $img);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            $imageName=uniqid() . '.'.$imageType;
            $file = $folderPath . $imageName;
            file_put_contents($file, $imageBase64);
            $url=url("images/".$imageName);
            $updateBook->image=$url;
        }
        $updateBook->save();
        return response()->json(['status'=>200,'message'=>'Book updated succesfully.']);
    }

    /**
     * Remove the specified book from database.
     *
     * @param  $id = for identification of row
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$getData=Book::where("id",$id)->first();
    	if($getData && $getData->image != null)
    	{
    		$getImageName=explode("/",$getData->image);
            if (file_exists( public_path() . '/images/'.$getImageName[count($getImageName)-1])) {
                unlink(public_path() . '/images/'.$getImageName[count($getImageName)-1]);
            }
    	}
        Book::where("id",$id)->delete();
        return response()->json(['status'=>200,'message'=>'Book deleted succesfully.']);
    }
}
