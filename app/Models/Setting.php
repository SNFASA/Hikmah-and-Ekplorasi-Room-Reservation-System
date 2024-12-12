<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';

    // Add the short_des attribute to the fillable property
    protected $fillable = [
        'short_des', 
        'description', 
        'photo', 
        'logo', 
        'address', 
        'email', 
        'phone'
    ];
}
