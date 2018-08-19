<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    	$this->validate($request, [
    		'email'=> ['required', 'email', Rule::exists('users','email')],
    		'password'=> ['required'],
    	]);

    	$user = User::where('email', $request->email)->first();

    	if (Hash::check($request->password, $user->password)) {
    		return $user;
    	}

    	return response()->json([], 403);
    }
}
