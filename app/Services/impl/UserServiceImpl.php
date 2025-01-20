<?php
namespace App\Services\Impl;
use App\Models\User;
use App\Http\Requests\UserPostRequest;
use App\Services\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
class UserServiceImpl implements UserService {
   
    public function create(UserPostRequest $request){
        try {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            return $user;
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->notFound('user not found'));
        }
        }
    
        public function update(UserPostRequest $request, $id){
           try {
            $user = User::findOrFail($id);
            if (!$user) {
                throw new HttpResponseException(response()->notFound('user not found'));
            }
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $user->update([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            return $user;
           } catch (\Throwable $th) {
                throw new HttpResponseException(response()->notFound('user not found'));
           }
        }
    
        public function delete($id){
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return $user;
            } catch (\Throwable $th) {
                throw new HttpResponseException(response()->notFound('user not found'));
            }
        }
    
        public function show($id){
            try {
                //code...
                $user = User::findOrFail($id);
                return $user;
            } catch (\Throwable $th) {
                throw new HttpResponseException(response()->notFound('user not found'));
            }
        }
    
        public function index(){
            $users = User::all();
            return $users;
        }

        public function search(Request $request){
            $response = Http::get("https://ogienurdiana.com/career/ecc694ce4e7f6e45a5a7912cde9fe131")->json();
    
            $data = $response['DATA'];
            
            $lines = explode("\n", $data);
        
            $label = $request->input('label');
            $value = $request->input('value');
        
            $headers = explode('|', $lines[0]);
            $key =array_search($label, $headers);
            $response = [];
        
            foreach ($lines as $line) {
                $columns = explode('|', $line);
                if($columns[$key] == $value){
                    $result = $columns;
                    break;
                }
            }
        
            foreach($headers as $key=>$header){
                $response[$header] = $result[$key];
            }

            return $response;
        }
}