<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankAccountController extends Controller
{
    var $modelBankAccount;
    public function __construct()
    {
        $this->modelBankAccount = new BankAccount();
    }

    public function response($list){
        $data = array(
            'status'=>0,  
            'data'=>array(
                'list'=>$list
            )
        );
        return response($data,200);
    }

    public function create(Request $request){

        $validator = $this->validateFields($request);
        
        if($validator->fails()){ 
            $data = array(
                'status'=>1, 
                'errors'=>$validator->errors()
            );
            return response($data,422);
        }
        else {   
            BankAccount::create([ 
                'uid' => $request->input('uid'),
                'account_name' => $request->input('account_name'),
                'bank_name' => $request->input('bank_name'), 
                'account_number' => $request->input('account_number'),
                'purpose' => $request->input('purpose'),
                'account_type' => $request->input('account_type')
            ]); 
            $bankAccountList = $this->modelBankAccount->listBankAccount($request->input('uid'));
            return $this->response($bankAccountList); 
        }
    }

    public function list(Request $request){ 
        $bankAccountList = $this->modelBankAccount->listBankAccount($request->segment(4));
        return $this->response($bankAccountList); 
    }

    public function view(Request $request){
        $bankAccountList = $this->modelBankAccount->viewBankAccount($request->segment(4));
        return $this->response($bankAccountList); 
    }
    
    public function update(Request $request){
        $validator = $this->validateFields($request);
        
        if($validator->fails()){ 
            $data = array(
                'status'=>1, 
                'errors'=>$validator->errors()
            );
            return response($data,422);
        }
        else {   
            $updatedData = [    
                'uid' => $request->input('uid'),
                'account_name' => $request->input('account_name'),
                'bank_name' => $request->input('bank_name'), 
                'account_number' => $request->input('account_number'),
                'purpose' => $request->input('purpose'),
                'account_type' => $request->input('account_type')
            ]; 
            $this->modelBankAccount->updateBankAccount($request->input('baid'),$updatedData); 
            
            $bankAccountList = $this->modelBankAccount->listBankAccount($request->input('uid'));
            return $this->response($bankAccountList); 
        }
    }
    public function delete(Request $request){
        $this->modelBankAccount->deleteBankAccount($request->segment(4));

        $bankAccountList = $this->modelBankAccount->listBankAccount($request->input('uid'));
        return $this->response($bankAccountList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [ 
            'uid' => 'required|int|max:6', 
            'bank_name' => 'required|string|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' =>'required|int',
            'purpose' => 'required|string|max:255', 
            'account_type' => 'required|int', 
        ]);
        return $validator;
    }
}
