<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BikeController extends Controller
{
    public function show()
    {
        $bike = Bike::all();
        return response()->json($bike);

    }
    public function showone($id)
    {
        $bike = Bike::find($id);
        if (!$bike) {
            return response()->json('not found');
        }
        return response()->json(['bike'=>$bike]);

    }

    public function store (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'color' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $bike = Bike::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'color' => $request->color,
        ]);
        $bike->save();
        return response()->json([
            'message' => 'Successfully created bike!'
        ], 201);

    }
    public function update(Request $request, $id)
    {
        $bike = Bike::find($id);
        $bike->update($request->all());
        return response()->json($bike);
    }
    public function delete(Request $request, $id)
    {
        $bike = Bike::find($id);
        if (!$bike) {
            return response()->json('not found');
        }
        $bike->delete($request->all());
        return response()->json('deleted');
    }

}
