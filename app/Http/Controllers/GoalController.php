<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoalController extends Controller
{
    var $modelGoal;
    public function __construct()
    {
        $this->modelGoal = new Goal();
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
            Goal::create([ 
                'uid' => $request->input('uid'),
                'name' => $request->input('name'),
                'description' => $request->input('description'), 
                'amount' => $request->input('amount'),
                'date' => $request->input('date'),
                'remind_me' => $request->input('remind_me'),
                'remind_date' => $request->input('remind_date')
            ]); 
            $goalList = $this->modelGoal->listGoal($request->input('uid'));
            return $this->response($goalList); 
        }
    }

    public function list(Request $request){ 
        $goalList = $this->modelGoal->listGoal($request->segment(4));
        return $this->response($goalList); 
    }

    public function view(Request $request){
        $goalList = $this->modelGoal->viewGoal($request->segment(4));
        return $this->response($goalList); 
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
                'description' => $request->input('description'), 
                'amount' => $request->input('amount'),
                'date' => $request->input('date'),
                'remind_me' => $request->input('remind_me'),
                'remind_date' => $request->input('remind_date')
            ]; 
            $this->modelGoal->updateGoal($request->input('gid'),$updatedData); 
            
            $goalList = $this->modelGoal->listGoal($request->input('uid'));
            return $this->response($goalList); 
        }
    }
    public function delete(Request $request){
        $this->modelGoal->deleteGoal($request->segment(4));

        $goalList = $this->modelGoal->listGoal($request->input('uid'));
        return $this->response($goalList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [ 
            'uid' => 'required|int|max:6', 
            'name' => 'required|string|string|max:255',
            'description' => 'required|string|max:255',
            'amount' =>'required|string|max:20',
            'date' => 'required|string|max:20', 
            'remind_me' => 'required|int|max:1', 
            'remind_date' => 'required|string|max:20', 
        ]);
        return $validator;
    }
}
