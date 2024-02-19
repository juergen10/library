<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Response\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed'
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $success['token'] =  $user->createToken('library_app')->plainTextToken;
        $success['name'] =  $user->name;

        return Response::send(200, $success, 'user_register_successfully');
    }
}
