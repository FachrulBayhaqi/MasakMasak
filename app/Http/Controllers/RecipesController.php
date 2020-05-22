<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\UnauthorizedException;
use Intervention\Image\Facades\Image;

class RecipesController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$recipes = Recipe::all();

		return view('recipes/index', ['recipes' => $recipes]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('recipes/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$recipe = new Recipe;

        $this->validate($request, [
            'title' => 'required|max:255',
            'subject' => 'required|max:255',
            'recipe' => 'required|max:1500',
            'category' => 'required|max:500',

        ]);

		if($request->hasFile('image')) {
			$file = $request->file('image');
			$imageName = $file->getClientOriginalName();

			$thumbPath = public_path('/thumbnail');
			$thumb = Image::make($file->getRealPath());
			$thumb->resize(300, 350, function($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save($thumbPath . '/' . $imageName);

			$imagePath = public_path('/images/recipes');
			$thumb = Image::make($file->getRealPath());
			$thumb->resize(450, 650, function($constraint) {
				$constraint->aspectRatio();
			})->insert(public_path('/images/watermark.png'), 'bottom-left')->save($imagePath . '/' . $imageName);

			$recipe->image = $imageName;
		}
		$recipe->title = $request->title;
		$recipe->subject = $request->subject;
		$recipe->recipe = $request->recipe;
		$recipe->category = $request->category;
		$recipe->author_id = Auth::user()->id;

		$recipe->save();

		return redirect('/');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$recipe = Recipe::find($id);

		//return view('recipes/edit', ['recipe' => $recipe]);
		return view('recipes/showRecipe')->with('recipe', $recipe);
		//pass to the view
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$recipe = Recipe::find($id);
		$this->authorize('update-recipe', $recipe);

		//return view('recipes/edit', ['recipe' => $recipe]);
		return view('recipes/edit')->with('recipe', $recipe);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$recipe = Recipe::find($id);
		$this->authorize('update-recipe', $recipe);

		$this->validate($request, [
			'title' => 'required|max:255',
			'subject' => 'required|max:255',
			'recipe' => 'required|max:500',
			'category' => 'required|max:500',

		]);

		if($request->hasFile('image')) {
			$file = $request->file('image');
			$imageName = $file->getClientOriginalName();

			$thumbPath = public_path('/thumbnail');
			$thumb = Image::make($file->getRealPath());
			$thumb->resize(300, 350, function($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save($thumbPath . '/' . $imageName);

			$imagePath = public_path('/images/recipes');
			$thumb = Image::make($file->getRealPath());
			$thumb->resize(450, 650, function($constraint) {
				$constraint->aspectRatio();
			})->insert(public_path('/images/watermark.png'), 'bottom-left')->save($imagePath . '/' . $imageName);
			$recipe->image = $imageName;
		}

		$recipe->title = $request->title;
		$recipe->subject = $request->subject;
		$recipe->recipe = $request->recipe;
		$recipe->category = $request->category;
		$recipe->author_id = Auth::user()->id;
		$recipe->save();

		return redirect('/');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$recipe = Recipe::find($id);

		$this->authorize('update-recipe', $recipe);

		$recipe->delete();

		return redirect('/');
	}

	public function getUserRecipes($userID)
	{
		$recipes = Recipe::where('author_id', $userID)->get();

		return view('recipes/userRecipes')->with('recipes', $recipes);
	}


	public function search(Request $request)
	{
		$search = $request->get('q');
		$result = Recipe::where('title','LIKE', '%'. $search .'%')->paginate(10);

		return view('result', compact('search','result'));
	}

	public function searchbahan(Request $request)
	{
		$searchbahan = $request->get('b');
		$resultbahan = Recipe::where('subject','LIKE', '%'. $searchbahan .'%')->paginate(10);

		return view('resultbahan', compact('searchbahan','resultbahan'));
	}


}
