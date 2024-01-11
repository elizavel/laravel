<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    
    public function listBankAccount($user){
        return $this::where('uid',$user)->get();
    }
 
    public function viewBankAccount($baid){
        return $this::where('baid',$baid)->get();
    }

    public function createBankAccount($data){
        $this->create($data);
    }

    public function updateBankAccount($baid,$data){
        $this::where('baid',$baid)->update($data);
    }

    public function deleteBankAccount($baid){
        $this::where('baid',$baid)->delete();
    }
}
