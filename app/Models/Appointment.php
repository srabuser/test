<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['day','time','available'];


    public function user()
    {
       return $this->belongsToMany(User::class);
    }
}
