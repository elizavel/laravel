<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodController extends Controller
{
    var $modelPeriod;
    public function __construct()
    {
        $this->modelPeriod = new Period();
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
            Period::create([  
                'name' => $request->input('name'), 
            ]); 
            $periodList = $this->modelPeriod->listPeriod();
            return $this->response($periodList); 
        }
    }

    public function list(){ 
        $periodList = $this->modelPeriod->listPeriod();
        return $this->response($periodList); 
    }

    public function view(Request $request){
        $periodList = $this->modelPeriod->viewPeriod($request->segment(4));
        return $this->response($periodList); 
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
                'name' => $request->input('name'), 
            ]; 
            $this->modelPeriod->updatePeriod($request->input('id'),$updatedData); 
            
            $periodList = $this->modelPeriod->listPeriod();
            return $this->response($periodList); 
        }
    }
    public function delete(Request $request){
        $this->modelPeriod->deletePeriod($request->segment(4));

        $periodList = $this->modelPeriod->listPeriod();
        return $this->response($periodList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [  
            'name' => 'required|string|string|max:255',  
        ]);
        return $validator;
    }
}
