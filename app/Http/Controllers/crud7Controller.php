<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Stream;

class crud7Controller extends Controller
{
 
    public function index()
{
    $books = Book::all();
    return response()->json($books);
}

public function store(Request $request)
{
    $book = Book::create($request->all());
    return response()->json($book, 201);
}




public function delete(Request $request, $id)
{
    $book = Book::find($id);
    if (!$book) {
        return response()->json('not found');
    }
    $book->delete($request->all());
    return response()->json('deleted');
}
public function update(Request $request, $id)
{
    $book = Book::find($id);
    $book->update($request->all());
    return response()->json($book);
}





}
