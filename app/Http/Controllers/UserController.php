<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\UserPostRequest;
class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
      // Display a listing of the users
      public function index()
      {
          $users = User::all();
          return response()->json($users);
      }
  
      // Store a new user
      public function store(UserPostRequest $request)
      {
          $user = $this->userService->create($request);
          return response()->json($user, 201);
      }
  
      // Show a specific user
      public function show($id)
      {
        $user = $this->userService->show($id);
        return response()->json($user, 202);
      }
  
      // Update a user
      public function update(Request $request, $id)
      {
        $user = $this->userService->update($request,$id);
        return response()->json($user, 201);
  
          return response()->json($user);
      }
  
      // Delete a user
      public function destroy($id)
      {
        $user = $this->userService->delete($id);
        return response()->json($user, 201);
  
          return response()->json(['message' => 'User deleted successfully']);
      }

      public function search(Request $request){
        $response = $this->userService->search($request);
      return response()->ok($response);
      }
}
