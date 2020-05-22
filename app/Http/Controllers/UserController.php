<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;
use Excel;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users/user')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users/editUser')->with('user', $user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if($request->first_name && $request->last_name)
        {
	        $user->name = $request->last_name.", ".$request->first_name;
        }
        $user->city = $request->city;
        $user->country = $request->country;
        $user->info = $request->info;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = $file->getClientOriginalName();

            $thumbPath = public_path('/thumbnail/user_profile');
            $thumb = Image::make($file->getRealPath());
            $thumb->resize(300, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($thumbPath . '/' . $imageName);

            $imagePath = public_path('/images/user_profile');
            $thumb = Image::make($file->getRealPath());
            $thumb->resize(450, 650, function ($constraint) {
                $constraint->aspectRatio();
            })->save($imagePath . '/' . $imageName);

            $user->avatar = $imageName;
        }

        $user->save();
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect('/');
    }

    public function exportUsers()
    {
        $users = User::all();

        return Excel::create('Users_list', function($excel) use ($users){
            $excel->sheet('UsersList',function($sheet) use ($users)
            {
                $sheet->fromArray($users);
            });
        })->download('xls');

    }
}
