<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    var $modelBudget;

    public function __construct()
    {
        $this->modelBudget = new Budget();
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
            Budget::create([ 
                'uid' => $request->input('uid'),
                'period' => $request->input('period'),
                'item' => $request->input('item'),
                'amount' => $request->input('amount'),
                'due_date' => $request->input('due_date'),
                'remind_me' => $request->input('remind_me'),
                'remind_date' => $request->input('remind_date')
            ]); 
            $budgetList = $this->modelBudget->listBudget($request->input('uid'));
            return $this->response($budgetList); 
        }
    }

    public function list(Request $request){ 
        $budgetList = $this->modelBudget->listBudget($request->segment(4));
        return $this->response($budgetList); 
    }

    public function view(Request $request){
        $budgetList = $this->modelBudget->viewBudget($request->segment(4));
        return $this->response($budgetList); 
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
                'period' => $request->input('period'),
                'item' => $request->input('item'),
                'amount' => $request->input('amount'),
                'due_date' => $request->input('due_date'),
                'remind_me' => $request->input('remind_me'),
                'remind_date' => $request->input('remind_date')
            ]; 
            $this->modelBudget->updateBudget($request->input('bid'),$updatedData); 
            
            $budgetList = $this->modelBudget->listBudget($request->input('uid'));
            return $this->response($budgetList); 
        }
    }
    public function delete(Request $request){
        $this->modelBudget->deleteBudget($request->segment(4));

        $budgetList = $this->modelBudget->listBudget($request->input('uid'));
        return $this->response($budgetList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [ 
            'uid' => 'required|int|max:6',
            'period' => 'required|int|min:1',
            'item' => 'required|string|max:255',
            'amount' => 'required|int',
            'due_date' =>'required|string|max:12',
            'remind_me' => 'required',
            'remind_date' => 'required|string|max:12'
        ]);
        return $validator;
    }
}
