<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    
    public function listDeduction($user){
        return $this::where('uid',$user)->get();
    }
 
    public function viewDeduction($id){
        return $this::where('id',$id)->get();
    }

    public function createDeduction($data){
        $this->create($data);
    }

    public function updateDeduction($id,$data){
        $this::where('id',$id)->update($data);
    }

    public function deleteDeduction($id){
        $this::where('id',$id)->delete();
    }
}
