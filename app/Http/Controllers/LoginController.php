<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponse;
    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        $user = User::where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return $this->apiresponse('Invalid credentials', 401);
        }
        $token  = $user->createToken('auth_token')->plainTextToken;
        return $this->apiresponse('Login successful', 200, ['token' => $token]);
    }
}
