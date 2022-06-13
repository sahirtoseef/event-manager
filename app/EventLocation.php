<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
    protected $fillable = [
            'name', 'event_id'
	];

    public function visitor()
    {
        return $this->belongsTo('App\Visitor', 'visitor_id');
    }
}
