<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => ['required', 'min:3', 'max:255'],
    		'email'=> ['required', 'email', Rule::unique('users', 'email')],
    		'password'=> ['required', 'min:6'],
    	]);

    	return User::forceCreate([
    		'api_token' => str_random(60),
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
    	]);
    }

    public function update(Request $request, int $id)
    {
    	if ($id !== $request->user()->id) {
    		return abort(403, 'Unathorized');
    	}

    	$this->validate($request, [
    		'name' => ['required_without:password', 'min:3', 'max:255'],
    		'password'=> ['required_without:name', 'min:6'],
    	]);

    	$user = User::findOrFail($id);

    	if ($request->name) {
    		$user->name = $request->name;
    	}

    	if ($request->password) {
    		$user->password = bcrypt($request->password);
    	}

    	$user->save();
    }

    public function me(Request $request)
    {
    	return $request->user();
    }

    public function index()
    {
    	return Cache::remember('users', 1, function () {
	    	return User::all([
	    		'id',
	    		'name',
	    		'email',
	    		'created_at',
	        	'updated_at'
	    	]);
	    });
    }

    public function show(int $id)
    {
    	return User::findOrFail($id, [
    		'id',
    		'name',
    		'email',
    		'created_at',
        	'updated_at'
    	]);
    }

    public function destroy(Request $request, int $id)
    {
    	if ($id === $request->user()->id) {
    		return abort(403, 'You can\'t destroy yourself');
    	}

    	User::findOrFail($id)->delete();
    }
}
