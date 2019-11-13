<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundPhoto extends Model
{   
    protected $table = 'refunds_photos';
    protected $fillable = [
        'image',
        'refund_id'
    ];

    public function realState()
    {
    	return $this->belongsTo(Refund::class);
    }
}
