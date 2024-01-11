<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    
    public function listIncome($user){
        return $this::where('uid',$user)->get();
    }
 
    public function viewIncome($iid){
        return $this::where('iid',$iid)->get();
    }

    public function createIncome($data){
        $this->create($data);
    }

    public function updateIncome($iid,$data){
        $this::where('iid',$iid)->update($data);
    }

    public function deleteIncome($iid){
        $this::where('iid',$iid)->delete();
    }
}
