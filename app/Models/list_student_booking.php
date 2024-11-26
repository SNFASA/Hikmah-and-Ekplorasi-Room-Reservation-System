<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class list_student_booking extends Model
{
    use HasFactory;

    protected $table = 'list_student_booking';
    protected $primaryKey = 'id';
    protected $fillable = [
       'user_no_matriks1',
       'user_no_matriks2',
       'user_no_matriks3',
       'user_no_matriks4',
       'user_no_matriks5',
       'user_no_matriks6',
       'user_no_matriks7',
       'user_no_matriks8',
       'user_no_matriks9',
       'user_no_matriks10',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_no_matriks1');
    }
    public function user2(){
        return $this->belongsTo(User::class, 'user_no_matriks2');
    }
    public function user3(){
        return $this->belongsTo(User::class, 'user_no_matriks3');
    }
    public function user4(){
        return $this->belongsTo(User::class, 'user_no_matriks4');
    }
    public function user5(){
        return $this->belongsTo(User::class, 'user_no_matriks5');
    }
    public function user6(){
        return $this->belongsTo(User::class, 'user_no_matriks6');
    }
    public function user7(){
        return $this->belongsTo(User::class, 'user_no_matriks7');
    }
    public function user8(){
        return $this->belongsTo(User::class, 'user_no_matriks8');
    }
    public function user9(){
        return $this->belongsTo(User::class, 'user_no_matriks9');
    }
    public function user10(){
        return $this->belongsTo(User::class, 'user_no_matriks10');
    }
}
