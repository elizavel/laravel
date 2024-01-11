<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LogController extends Controller
{
    public function logRequest($request){
        $log = new Log();
        $uid = 0;
        if($request->has('uid')){
            $uid = $request->input('uid');
        }else{
            $encryptedToken = $request->header('Authorization');
            if(!empty($encryptedToken)){
                $decryptedToken = Crypt::decryptString($encryptedToken);
                $decodedUser = json_decode($decryptedToken); 
                $uid = $decodedUser->id;
            } 
        }
        $log->uid=$uid;
        $log->url=$request->path();
        $log->request=json_encode($request->all());
        $log->save();
    }
}
