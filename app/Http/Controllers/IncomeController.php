<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    var $modelIncome;

    public function __construct()
    {
        $this->modelIncome = new Income();
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
            Income::create([ 
                'uid' => $request->input('uid'),
                'period' => $request->input('period'),
                'name' => $request->input('name'), 
                'category' => $request->input('category'),
                'gross_pay' => $request->input('gross_pay'),
                'net_pay' => $request->input('net_pay')
            ]); 
            $incomeList = $this->modelIncome->listIncome($request->input('uid'));
            return $this->response($incomeList); 
        }
    }

    public function list(Request $request){ 
        $incomeList = $this->modelIncome->listIncome($request->segment(4));
        return $this->response($incomeList); 
    }

    public function view(Request $request){
        $incomeList = $this->modelIncome->viewIncome($request->segment(4));
        return $this->response($incomeList); 
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
                'name' => $request->input('name'), 
                'category' => $request->input('category'),
                'gross_pay' => $request->input('gross_pay'),
                'net_pay' => $request->input('net_pay')
            ]; 
            $this->modelIncome->updateIncome($request->input('iid'),$updatedData); 
            
            $incomeList = $this->modelIncome->listIncome($request->input('uid'));
            return $this->response($incomeList); 
        }
    }
    public function delete(Request $request){
        $this->modelIncome->deleteIncome($request->segment(4));

        $incomeList = $this->modelIncome->listIncome($request->input('uid'));
        return $this->response($incomeList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [ 
            'uid' => 'required|int|max:6',
            'category' => 'required|int|min:1',
            'name' => 'required|string|max:255',
            'gross_pay' => 'required|max:12',
            'net_pay' =>'required|max:12',
            'period' => 'required|int', 
        ]);
        return $validator;
    }
}
