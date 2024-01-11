<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    var $modelCategory;
    public function __construct()
    {
        $this->modelCategory = new Category();
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
            Category::create([  
                'name' => $request->input('name'), 
            ]); 
            $categoryList = $this->modelCategory->listCategory();
            return $this->response($categoryList); 
        }
    }

    public function list(){ 
        $categoryList = $this->modelCategory->listCategory();
        return $this->response($categoryList); 
    }

    public function view(Request $request){
        $categoryList = $this->modelCategory->viewCategory($request->segment(4));
        return $this->response($categoryList); 
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
            $this->modelCategory->updateCategory($request->input('id'),$updatedData); 
            
            $categoryList = $this->modelCategory->listCategory();
            return $this->response($categoryList); 
        }
    }
    public function delete(Request $request){
        $this->modelCategory->deleteCategory($request->segment(4));

        $categoryList = $this->modelCategory->listCategory();
        return $this->response($categoryList); 
    }

    private function validateFields($request){
        $validator = Validator::make($request->all(), [  
            'name' => 'required|string|string|max:255',  
        ]);
        return $validator;
    }
}
