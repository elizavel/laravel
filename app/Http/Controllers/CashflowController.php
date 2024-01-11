<?php

namespace App\Http\Controllers;

use App\Models\Cashflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CashflowController extends Controller
{
    var $modelCashflow;
    public function __construct()
    {
        $this->modelCashflow = new Cashflow();
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
            Cashflow::create([ 
                'uid' => $request->input('uid'),
                'name' => $request->input('name'),
                'date' => $request->input('date'), 
                'amount' => $request->input('amount'),
                'type' => $request->input('type'), 
            ]); 
            $cashflowList = $this->modelCashflow->listCashflow($request->input('uid'));
            return $this->response($cashflowList); 
        }
    }

    public function list(Request $request){ 
        $cashflowList = $this->modelCashflow->listCashflow($request->segment(4));
        return $this->response($cashflowList); 
    }

    public function view(Request $request){
        $cashflowList = $this->modelCashflow->viewCashflow($request->segment(4));
        return $this->response($cashflowList); 
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
                'name' => $request->input('name'),
                'date' => $request->input('date'), 
                'amount' => $request->input('amount'),
                'type' => $request->input('type'), 
            ]; 
            $this->modelCashflow->updateCashflow($request->input('cid'),$updatedData); 
            
            $cashflowList = $this->modelCashflow->listCashflow($request->input('uid'));
            return $this->response($cashflowList); 
        }
    }
    public function delete(Request $request){
        $this->modelCashflow->deleteCashflow($request->segment(4));

        $cashflowList = $this->modelCashflow->listCashflow($request->input('uid'));
        return $this->response($cashflowList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [ 
            'uid' => 'required|int|max:6', 
            'name' => 'required|string|string|max:255',
            'date' => 'required|string|max:20',
            'amount' =>'required|string|max:20',
            'type' => 'required|int',  
        ]);
        return $validator;
    }
}
