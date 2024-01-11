<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{    
    const URI_DASHBOARD = '/dashboard';
    
    public function signUp(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'pin'=>'required|int|min:6'
        ]);

        if($validator->fails()){ 
            $data = array(
                'status'=>1, 
                'errors'=>$validator->errors()
            );
            return response($data,422);
        }
        else { 
            $user = User::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'password'=>$this->hashingPassword($request->input('password')),
                'password_renew_date'=>$this->renewPasswordDate(),
                'pin'=>$request->input('pin')
            ]); 
            $token = $user->id;
            $data = array(
                'status'=>0,  
                'data'=>array(
                    'token' => $token,
                    'redirect'=>1,
                    'redirect_uri'=>$this::URI_DASHBOARD
                )
            );
            return response($data,200);
        }
    }  
    
    public function logIn(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6', 
        ]); 
        
        if($validator->fails()){ 
            $data = array(
                'status'=>1, 
                'errors'=>$validator->errors()
            );
            return response($data,422);
        }
        else {  
           
            if(Auth::attempt($request->all())){ 
                $id = Auth::user();
                $token = $this->generateToken($id); 
                $data = array(
                    'status'=>0, 
                    'data'=>array(
                        'token' => $token,
                        'user'=> $request->user(),
                        'exp'=>$this->tokenExpiration()
                    )
                );
                return response($data,200);
            }else{
                $data = array(
                    'status'=>1, 
                    'errors'=>array(
                        'credentials' => 'The provided credentials do not match our records.',
                    )
                );
                return response($data,422);
            } 
        }
    }

    public function resetPassword(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email', 
        ]); 
        
        if($validator->fails()){ 
            $data = array(
                'status'=>1, 
                'errors'=>$validator->errors()
            );
            return response($data,422);
        }
        else {   
            $userModel = new User();
            if($userModel->validateEmail($request->input('email'))){

                $randomPassword = rand();
                $temporaryPassword = $this->hashingPassword($randomPassword);

               

                $rawToken = array( 
                    'email'=>$request->input('email'),
                    'exp'=>$this->tokenExpiration()
                );
                $rawToken = json_encode($rawToken); 
                $tokenPassword = Crypt::encryptString($rawToken); 

                $dataToUpdate = array(
                    'password'=>$temporaryPassword,
                    'reset_token'=>$tokenPassword
                );
                $userModel->updateViaEmail($request->input('email'),$dataToUpdate);  

                $link = env("APP_URL")."resetting-password/?token={$tokenPassword}";
                Mail::to($request->input('email'))->send(new ResetPassword($randomPassword,$link));
               
                $data = array(
                    'status'=>0, 
                    'data'=>array( 
                        'message' => "Reset Password link has been sent to {$request->input('email')}",
                        'link'=>$link
                    )
                );
                return response($data,200);
            }else{
                $data = array(
                    'status'=>1, 
                    'errors'=>array(
                        'credentials' => 'The provided credentials do not match our records.',
                    )
                );
                return response($data,422);
            } 
        }
        
 
    }

    private function generateToken($user){ 
        $rawToken = array(
            'id'=>$user->id,
            'email'=>$user->email,
            'exp'=>$this->tokenExpiration()
        );
        $rawToken = json_encode($rawToken); 
        $encryptedToken = Crypt::encryptString($rawToken); 
        $userUpdate = User::find($user->id); 
        $userUpdate->token = $encryptedToken; 
        $userUpdate->save(); 
        return $encryptedToken;
    }

    private function tokenExpiration(){ 
        $currentDate = new DateTime();
        $currentDate->modify('+90 mins');
        $result = $currentDate->format('Y-m-d H:i:s'); 
        return $result;
    } 

    private function hashingPassword($rawPassword){
        return bcrypt($rawPassword);
    }

    private function renewPasswordDate(){ 
        $currentDate = new DateTime();
        $currentDate->modify('+90 days');
        $result = $currentDate->format('Y-m-d'); 
        return $result;
    }
}
