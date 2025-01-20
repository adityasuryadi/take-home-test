<?php 
namespace App\Services;
use App\Http\Requests\UserPostRequest;
use Illuminate\Http\Request;

interface UserService {
    public function create(UserPostRequest $request);
    public function update(UserPostRequest $request, $id);
    public function delete($id);
    public function show($id);
    public function index();
    public function search(Request $request);
}
?>