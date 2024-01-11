<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function listBudget($user){
        return $this::where('uid',$user)->get();
    }
 
    public function viewBudget($bid){
        return $this::where('bid',$bid)->get();
    }

    public function createBudget($data){
        $this->create($data);
    }

    public function updateBudget($bid,$data){
        $this::where('bid',$bid)->update($data);
    }

    public function deleteBudget($bid){
        $this::where('bid',$bid)->delete();
    }

}
