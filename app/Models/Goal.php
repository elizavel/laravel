<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    
    public function listGoal($user){
        return $this::where('uid',$user)->get();
    }
 
    public function viewGoal($gid){
        return $this::where('gid',$gid)->get();
    }

    public function createGoal($data){
        $this->create($data);
    }

    public function updateGoal($gid,$data){
        $this::where('gid',$gid)->update($data);
    }

    public function deleteGoal($gid){
        $this::where('gid',$gid)->delete();
    }
}
