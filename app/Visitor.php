<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
            'manager_id', 'event_id', 'uni_id', 'watch_list', 'display_name', 'first_name', 'last_name', 'email', 'password', 'attendee_type', 'occupation', 'company',
            'phone', 'mobile_phone', 'photo', 'tags', 'language', 'location', 'city', 'state', 'country', 'completed_registration', 'checked_in',
            'terms_and_conditions_accepted', 'directory_opt_in', 'directory_opt_out', 'score', 'kliks', 'number_of_connections', 'registration_status',
            'checkin_time', 'login_link', 'wearable_id', 'wearable_rf_id'
	];

    public function client()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }
}
