<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\FoodType;
use App\Models\Food;
use Carbon\Carbon;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $food = Food::all();
        
        return view('food.index')->with('food',$food);
    }

    public function create()
    {
        $food_type = FoodType::all();
        return view('food.create')->with('food_type',$food_type);
    }

    public function store(Request $request)
    {
        $array = explode("-",$request->date_of_food);
        $foodtype = FoodType::find($request->food_type_id);
        $total = round($foodtype->price*$request->quantity,2);
        $request->merge(['month'=>$array[1],'year'=>$array[0],'total'=>$total]);
        Food::create($request->all());
        
        return redirect()->route('food.index');
    }

    public function edit(Food $food)
    {
        $food_type = FoodType::all();
        return view('food.create')->with('food',$food)->with('food_type',$food_type);
    }

    public function update(Request $request, Food $food)
    {
        $array = explode("-",$request->date_of_food);
        $foodtype = FoodType::find($request->food_type_id);
        $total = round($foodtype->price*$request->quantity,2);
        $request->merge(['month'=>$array[1],'year'=>$array[0],'total'=>$total]);
        $food->update($request->all());
        
        return redirect()->route('food.index');
    }

    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('food.index');
    }
   
}
