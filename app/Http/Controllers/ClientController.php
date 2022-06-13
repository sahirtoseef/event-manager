<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Event;
use App\Visitor;
use Helper;

class ClientController extends Controller {

	public function index() {
		$auth = Auth::user();
		$clientId = $auth->id;
		$events = Event::all()->where( 'status', '=', 1 )->where( 'user_id', '=', $clientId )->pluck( 'id' )->toArray();
		$visitors = Visitor::whereIn( 'event_id', $events )->where( 'checked_in', '=', 1 )->orderBy( 'checkin_time', 'desc' )->get()->take( 5 );
		$events = Event::all()->whereIn( 'id', $events )->take( 5 );
		foreach( $events as $key => $event ) {
			$data = array();
			$peakHours = Helper::getPeakHoursFromData( $event->visitors );
			$maxs = array_keys( $peakHours, max( $peakHours ) );
			$event->checkin_count = $peakHours[ $maxs[ 0 ] ];
			$event->peakHourTime = $maxs[ 0 ];
			$events[ $key ] = $event;
		}
		return view( 'client.index', compact( 'auth', 'visitors', 'events' ) );
	}

	public function peakHourReport() {
		$events = Event::all();
		foreach( $events as $key => $event ) {
			$data = array();
			$peakHours = Helper::getPeakHoursFromData( $event->visitors );
			$maxs = array_keys( $peakHours, max( $peakHours ) );
			$event->checkin_count = $peakHours[ $maxs[ 0 ] ];
			$event->peakHourTime = $maxs[ 0 ];
			$events[ $key ] = $event;
		}
		return view( 'admin.admin-peak-hour-report', compact( 'events' ) );
	}

	public function allClients() {
		$clients = User::all()->where( 'role_id', '=', 3 )->where( 'status', '=', 1 );
		return view( 'admin.allclients' )->with( 'clients', $clients );
	}

	public function visitors() {
		$auth = Auth::user();
		$clientId = $auth->id;
		$events = Event::all()->where( 'status', '=', 1 )->where( 'user_id', '=', $clientId )->pluck( 'id' )->toArray();
		$visitors = Visitor::all()->whereIn( 'event_id', $events );
		return view( 'client.visitors', compact( 'visitors', 'auth' ) );
	}

	public function checkInTiming() {
		return view( 'client.checkintiming' );
	}

}
