<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Refund extends Model
{   
    use SoftDeletes;

    public $timestamps = false;
    protected $fillable = [
        'date', 
        'type', 
        'description', 
        'value',
        'timezone'
    ];
    protected $dates = ['deleted_at'];

    public function person(){
    	return $this->hasOne(Person::class);
    }

    public function photos(){
        return $this->hasOne(RefundPhoto::class);
    }

}
