<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
   public function search(Request $request){
      $search = Recipe::where('title', 'LIKE', "%{$request->q}%");
      return view('recipes/search', compact('recipes/search'));
   }
}