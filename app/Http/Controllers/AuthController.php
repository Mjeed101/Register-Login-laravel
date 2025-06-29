<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

   public function register(Request $request){

    // note here we have to get the naem from front now its static
     $request->validate([
        'username'=>'required',
        'name'=>'required',
        'email'=> 'required|email|unique:users,email',
        'password'=> 'required|min:6',
        ]);


        $user = User::create([
            'username'=> $request->username,
            'name'=> $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            ]);

        return response()->json(['message'=> 'user registered successfuly'],201);
}


    public function login(Request $request)
{
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
 ]);

 $user = User::where('email', $request->email)->first();

  if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }



 return response()->json([
    'message'=> 'login successful',
    'user' => [
    'id'=> $user->id,
    'username'=> $user->username,
    'name'=> $user->name,
    'email'=> $user->email
    ]
],200);

}

}
