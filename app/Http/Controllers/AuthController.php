<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Response\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

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

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        $user = $this->user->store($data);

        $success['token'] =  $user->createToken('library_app')->plainTextToken;
        $success['name'] =  $user->name;

        return Response::send(200, $success);
    }

    public function login(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'  => 'required'
        ]);

        if ($rules->fails()) {
            return Response::send(422, $rules->errors());
        }

        $user = $this->user->getByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return Response::message('unknown_credentials');
        }

        $success['token'] =  $user->createToken('library_app')->plainTextToken;
        $success['user'] =  $user;

        return Response::send(200, $success);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return Response::send(200, null, 'logged_out');
    }
}
