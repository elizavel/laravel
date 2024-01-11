<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    
    public function listPeriod(){
        return $this::get();
    }
 
    public function viewPeriod($id){
        return $this::where('id',$id)->get();
    }

    public function createPeriod($data){
        $this->create($data);
    }

    public function updatePeriod($id,$data){
        $this::where('id',$id)->update($data);
    }

    public function deletePeriod($id){
        $this::where('id',$id)->delete();
    }
}
