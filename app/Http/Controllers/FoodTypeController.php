<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\FoodType;

class FoodTypeController extends Controller
{
    public function index(Request $request)
    {
        $food_type = FoodType::all();
        
        return view('food_type.index')->with('food_type',$food_type);
    }

    public function create()
    {
        return view('food_type.create');
    }

    public function store(Request $request)
    {
        FoodType::create($request->all());
        
        return redirect()->route('food_type.index');
    }

    public function edit(FoodType $food_type)
    {
        return view('food_type.create')->with('food_type',$food_type);
    }

    public function update(Request $request, FoodType $food_type)
    {
        $food_type->update($request->all());
        
        return redirect()->route('food_type.index');
    }

    public function destroy(FoodType $food_type)
    {
        $food_type->delete();

        return redirect()->route('food_type.index');
    }
   
}
