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

  public function getUser($id){

    $user = User::find($id);

    if(!$user){
        return response()->json(['message'=> 'User not found'],404);
    }

    return response()->json([
        'username'=> $user->username,
        'name'=> $user->name,
        'email'=> $user->email

  ]);

}



    public function updateUser(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $request->validate([
        'username' => 'required',
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:6',
    ]);

    // Prepare update data
    $updateData = [
        'username' => $request->username,
        'name' => $request->name,
        'email' => $request->email,
    ];

    // If password is provided, add it
    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
    }

    // Save updates
    $user->update($updateData);

    // Return JSON response (this was missing!)
    return response()->json(['message' => 'User information updated successfully.']);
}



}
