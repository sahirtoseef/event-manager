<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $checkin_count = 0;
    public $peakHourTime = '12-2 AM';

    public function managers()
    {
        return $this->belongsToMany('App\User', 'user_events');
    }

    public function client()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function visitors()
    {
        return $this->hasMany('App\Visitor');
    }
}
