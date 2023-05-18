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
        $item->save();

        $data = [
            'id' => $item->id,
            'title' => $item->title,
            'author' => $item->author,
            'description' => $item->description,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at
        ];
        
        $response = [
            'event' => 'item-created',
            'data' => $data
        ];

        $this->emitSSE($response['event'], $response['data']);
        return response()->json($data, 200);

    }

    public function update(Request $request, $id)
    {
        $item = Book::find($id);
        $item->title = $request->title;
        $item->author= $request->author;
        $item->description = $request->description;
        $item->save();

        $data = [
            'id' => $item->id,
            'title' => $item->title,
            'author' => $item->author,
            'description' => $item->description,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at
        ];

        $response = [
            'event' => 'item-updated',
            'data' => $data
        ];

        $this->emitSSE($response['event'], $response['data']);
        return response()->json($data, 200);


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

        // Emitir evento SSE
       
        $response = [
            'event' => 'item-deleted',
            'data' => $id
        ];

        $this->emitSSE($response['event'], $response['data']);
        return response()->json($response, 200);

    }

    protected function emitSSE($event, $data)
    {
        $response = [
            'event' => $event,
            'data' => $data
        ];
        

        // Enviar evento SSE
        event(new \App\Events\SSEEvent(json_encode($response)));
    }
    
    
   
}
