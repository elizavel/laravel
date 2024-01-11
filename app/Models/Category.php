<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    
    public function listCategory(){
        return $this::get();
    }
 
    public function viewCategory($id){
        return $this::where('id',$id)->get();
    }

    public function createCategory($data){
        $this->create($data);
    }

    public function updateCategory($id,$data){
        $this::where('id',$id)->update($data);
    }

    public function deleteCategory($id){
        $this::where('id',$id)->delete();
    }
}
