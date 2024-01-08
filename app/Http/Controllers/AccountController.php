<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function response($code,$message,$data){
        $response = [
            'message'=>$message,
            'data'=>$data
        ];  
        return response(json_encode($response),$code);
    }
    
    public function signup(Request $request){
        return $this->response(200,"good",$request->all()); 
    }   

    public function resetPassword(Request $request){
        return "hello world";
    }
}
