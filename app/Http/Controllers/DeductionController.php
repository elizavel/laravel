<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeductionController extends Controller
{
    var $modelDeduction;
    public function __construct()
    {
        $this->modelDeduction = new Deduction();
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
            Deduction::create([ 
                'uid' => $request->input('uid'),
                'iid' => $request->input('iid'),
                'item' => $request->input('item'), 
                'amount' => $request->input('amount'), 
            ]); 
            $deductionList = $this->modelDeduction->listDeduction($request->input('uid'));
            return $this->response($deductionList); 
        }
    }

    public function list(Request $request){ 
        $deductionList = $this->modelDeduction->listDeduction($request->segment(4));
        return $this->response($deductionList); 
    }

    public function view(Request $request){
        $deductionList = $this->modelDeduction->viewDeduction($request->segment(4));
        return $this->response($deductionList); 
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
                'iid' => $request->input('iid'),
                'item' => $request->input('item'), 
                'amount' => $request->input('amount'), 
            ]; 
            $this->modelDeduction->updateDeduction($request->input('id'),$updatedData); 
            
            $deductionList = $this->modelDeduction->listDeduction($request->input('uid'));
            return $this->response($deductionList); 
        }
    }
    public function delete(Request $request){
        $this->modelDeduction->deleteDeduction($request->segment(4));

        $deductionList = $this->modelDeduction->listDeduction($request->input('uid'));
        return $this->response($deductionList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [ 
            'uid' => 'required|int|max:6',  
            'iid' => 'required|int|max:6', 
            'item' => 'required|string|max:255',
            'amount' =>'required|string|max:20', 
        ]);
        return $validator;
    }
}
