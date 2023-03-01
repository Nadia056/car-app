<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function show()
    {
        $car = Car::all();
        return response()->json($car);

    }
    public function showone($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json('not found');
        }
        return response()->json(['car'=>$car]);

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
        $car = Car::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'color' => $request->color,
        ]);
        $car->save();
        return response()->json([
            'message' => 'Successfully created car!'
        ], 201);

    }
    public function update(Request $request, $id)
    {
        $car = Car::find($id);
        $car->update($request->all());
        return response()->json($car);
    }
    public function delete(Request $request, $id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json('not found');
        }
        $car->delete($request->all());
        return response()->json('deleted');
    }
}
