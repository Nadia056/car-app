<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class crud8Controller extends Controller
{
   
    public function index()
    {
        $items = Book::all();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $item = new Book();
        $item->title = $request->title;
        $item->author= $request->author;
        $item->description = $request->description;

    }

    public function update(Request $request, $id)
    {
        $item = Book::find($id);
        $item->title = $request->title;
        $item->author= $request->author;
        $item->description = $request->description;
        $item->save();

       

    }
    public function book($id)
    {
        $item = Book::find($id);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Book::find($id);
        $item->delete();

       
    }
    public function eventSource()
    {
        $start = time();
        $maxExecution = ini_get('max_execution_time');
        $response = new StreamedResponse(function() use ($start, $maxExecution) {
            while (true) {
                if (time() >= $start + $maxExecution) {
                    exit();
                }
                echo 'data: ' . json_encode(Book::all()) . "\n\n";
                flush();
            }
        });
    
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache');
    
        return $response;
    }
    
   
}
