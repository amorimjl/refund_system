<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{   
    protected $table = 'persons';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'identification',
        'jobRole',
        'createdAt',
        'timezone'
    ];

    public function refund(){
        return $this->hasOne(Refund::class);
    }
}
