<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckinAttempt extends Model
{
    protected $fillable = [
            'manager_id', 'event_id','visitor_id', 'location', 'qr_code','status'
	];

    public function visitor()
    {
        return $this->belongsTo('App\Visitor', 'visitor_id');
    }
}
