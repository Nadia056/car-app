<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikeCar;
use App\Models\CarBike;
use App\Models\Client;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function RegisterCar(Request $request)
    {
       $bike=CarBike::create([ 
       'user_id'=>$request->user_id,
        'car_id'=>$request->car_id
        ]);
       
        $bike->save();
        return response()->json(200);
        

    }
    public function RegisterBike(Request $request)
    {
       $bike=BikeCar::create([ 
       'user_id'=>$request->user_id,
        'bike_id'=>$request->bike_id
        ]);
       
        $bike->save();
        return response()->json(200);
        

    }
    public function CarUSer($id)
    {
       //retur all the cars that a user has
         $car=CarBike::where('user_id',$id)->get();
            return response()->json($car);

        
    }
    public function BikeUSer($id)
    {
       //retur all the bikes that a user has
         $bike=BikeCar::where('user_id',$id)->get();
            return response()->json($bike);

        
    }
   
}
