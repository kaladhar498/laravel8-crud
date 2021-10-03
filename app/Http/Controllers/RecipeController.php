<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes.index',compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'ingredients' => 'required'
        ]);

        $save = [
            "name" => $data['name'],
            "description" => $data['description'],
            "ingredients" => $data['ingredients'],
            "isFavourite" => (int) $data['favourite']
        ];

        Recipe::create($save);

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $data = $request->all();

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'ingredients' => 'required'
        ]);

        $save = [
            "name" => $data['name'],
            "description" => $data['description'],
            "ingredients" => $data['ingredients'],
            "isFavourite" => (int) $data['favourite']
        ];

        $recipe = Recipe::where('id', $id)->update($save);
        
        return redirect()->route('recipes.index')
                        ->with('success','Recipe updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
    
        return redirect()->route('recipes.index')
                        ->with('success','Recipe deleted successfully');
    }

    /**
     * bookmark the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bookmark(Recipe $recipe)
    {
        $recipe->update(['isFavourite' => !$recipe->isFavourite]);

        if ($recipe->isFavourite == true) {
            return redirect()->route('recipes.index')->with('success', 'Recipe Favourited Successfully!');
        } else {
            return redirect()->route('recipes.index')->with('success', ' Recipe UnFavourited Successfully!');
        }        
    }
}
