<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    
    public function listCashflow($user){
        return $this::where('uid',$user)->get();
    }
 
    public function viewCashflow($cid){
        return $this::where('cid',$cid)->get();
    }

    public function createCashflow($data){
        $this->create($data);
    }

    public function updateCashflow($cid,$data){
        $this::where('cid',$cid)->update($data);
    }

    public function deleteCashflow($cid){
        $this::where('cid',$cid)->delete();
    }
}
