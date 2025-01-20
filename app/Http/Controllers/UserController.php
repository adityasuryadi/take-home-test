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
          return response()->ok($user);
      }
  
      // Show a specific user
      public function show($id)
      {
        $user = $this->userService->show($id);
        return response()->ok($user);
      }
  
      // Update a user
      public function update(Request $request, $id)
      {
        $user = $this->userService->update($request,$id);
        return response()->ok($user);
      }
  
      // Delete a user
      public function destroy($id)
      {
        $user = $this->userService->delete($id);
        return response()->ok([]);
      }

      public function search(Request $request){
        $response = $this->userService->search($request);
      return response()->ok($response);
      }
}
