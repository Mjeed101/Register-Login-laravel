<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{

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
