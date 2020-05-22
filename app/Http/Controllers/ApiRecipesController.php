<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecipeRequest;
use App\Recipe;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiRecipesController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
    public function index()
    {
        $recipes = Recipe::all();
        return $recipes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recipe = new Recipe;

        $recipe->title = $request->input('title');
        $recipe->subject = $request->input('subject');
        $recipe->recipe= $request->input('recipe');
        $recipe->category = $request->input('category');
        $recipe->author_id = 1;
        $recipe->save();

        return 'New recipe successfully created. Recipe: '.$recipe;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::find($id);

        if(is_null($recipe))
        {
            throw new ModelNotFoundException('No recipe found', 404);
        }

        return $recipe;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        if(is_null($recipe))
        {
            throw new ModelNotFoundException('No recipe found', 404);
        }

        $recipe->title = $request->input('title');
        $recipe->subject = $request->input('subject');
        $recipe->recipe= $request->input('recipe');
        $recipe->category = $request->input('category');
        $recipe->author_id = 1;
        $recipe->image = $request->input('image');
        $recipe->update();

        return 'Recipe updated! Recipe: ' . $recipe;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if(is_null($recipe))
        {
            throw new ModelNotFoundException('No recipe found', 404);
        }

        $recipe->delete();

        return 'Recipe successfully deleted!';
    }
}
