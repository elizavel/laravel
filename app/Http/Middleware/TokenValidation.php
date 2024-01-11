<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class TokenValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $encryptedToken = $request->header('Authorization');
        $decryptedToken = Crypt::decryptString($encryptedToken);
        $decodedUser = json_decode($decryptedToken); 
        $userModel = new User();
        $exists = $userModel->existingUserEmailToken($decodedUser->id,$decodedUser->email,$encryptedToken);
        $valid = false;
        if($exists && $decodedUser->exp > date('Y-m-d H:i:s')){ 
            $valid = true; 
        }
        if($valid){ 
            return $next($request);
        } 
        $data = array(
            'status'=>1, 
            'errors'=>array(
                'credentials' => 'Token Expired',
                'data'=>$decodedUser,
                'result'=>$valid
            )
        );
        return response($data,401); 
    }
}
