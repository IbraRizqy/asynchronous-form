<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::find(1);
        return view('home', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(1);
        $user->name = $request->namee;
        $user->email = $request->email;
        $user->message = $request->bio;
        $user->save();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'message' => $user->message,
        ]);
    }
}
