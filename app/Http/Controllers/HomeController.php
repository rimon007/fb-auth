<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function uploadFile(Request $request) {
        $this->validate($request, [
            'avatar' => ['required', 'image']
        ]);
        //$path = request()->file('avatar')->store('avatars', 'public');
        $ext = $request->file('avatar')->getClientOriginalExtension();
        $filename = $request->user()->provider_id.'.'.$ext;
        $path = $request->file('avatar')->storeAs(
            'public/avatars', $filename
        );

        User::where('id', auth()->user()->id)->update(['avatar'=> '/storage/avatars/'.$filename]);

        return response([], 204);
    }
}
