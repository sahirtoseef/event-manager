<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Event;
use App\Visitor;
use Illuminate\Support\Carbon;
use App\Helpers\Helper;

class AjaxRequests extends Controller {

	public function handleAjaxRequests( Request $request ) {
		switch ( $request->get( 'action' ) ) {
			case 'GET-EVENTS':
				$this->getEventsDataForAdmin( $request );
				break;
			case 'GET-CLIENTS':
				$this->getClientsDataForAdmin( $request );
				break;
			case 'GET-VISITORS':
				$this->getVisitorsDataForAdmin( $request );
				break;
			case 'POPULATE-GRAPH':
				$this->getGraphDataVisitors( $request );
				break;
			case 'PEAK-TIMINGS':
				$this->getPeakHours( $request );
				break;
			case 'GET-CLIENT-EVENTS':
				$this->getEventsDataForClient( $request );
				break;
			case 'GET-CLIENT-REGISTRATIONS':
				$this->getRegistrationsDataForClient( $request );
				break;
			case 'GET-CLIENT-VISITORS':
				$this->getVisitorsDataForClient( $request );
				break;
			case 'GET-CLIENT-PEAK-TIMINGS':
				$this->getClientPeakHours( $request );
				break;
		}
	}

	public function getEventsDataForAdmin( $request ) {


		$eventsData = array( 'totalEvents' => 0, 'action' => $request->get( 'action' ) );
		$events = Event::all()->where( 'status', '=', 1 );
		$eventsData[ 'totalEvents' ] = count( $events );

		//Current month events
		$currentMonthEvents = Event::whereMonth(
				'created_at', '=', Carbon::now()->month
			)->count();

		//Past Month events
		$previousMonthEvents = Event::whereMonth(
				'created_at', '=', Carbon::now()->subMonth()->month
			)->count();

		$eventsData[ 'difference' ] = Helper::differenceBetweenTwoNumbers( $previousMonthEvents, $currentMonthEvents );
		die( json_encode( $eventsData ) );
	}

	public function getClientsDataForAdmin( $request ) {
		$clientsData = array( 'totalClients' => 0, 'action' => $request->get( 'action' ) );
		$clients = User::all()->where( 'status', '=', 1 )->where( 'role_id', '=', 3 );
		$clientsData[ 'totalClients' ] = count( $clients );
		$clientsData[ 'difference' ] = Helper::differenceBetweenTwoNumbers( Helper::getPreviousWeekClients( User::class ), Helper::getCurrentWeekClients( User::class ) );
		die( json_encode( $clientsData ) );
	}

	public function getVisitorsDataForAdmin( $request ) {
		$visitorsData = array( 'totalVisitors' => 0, 'action' => $request->get( 'action' ) );
		$visitors = Visitor::all();
		$visitorsData[ 'totalVisitors' ] = count( $visitors );
		//Current month events
		$currentMonthVisitors = Visitor::whereMonth(
				'created_at', '=', Carbon::now()->month
			)->count();

		//Past Month events
		$previousMonthVisitors = Visitor::whereMonth(
				'created_at', '=', Carbon::now()->subMonth()->month
			)->count();

		$visitorsData[ 'difference' ] = Helper::differenceBetweenTwoNumbers( $previousMonthVisitors, $currentMonthVisitors );

		die( json_encode( $visitorsData ) );
	}

	public function getGraphDataVisitors( $request ) {
		$array = array( 'action' => $request->get( 'action' ) );
		$currentYearEvents = Event::whereBetween( 'created_at', [
			    Carbon::now()->startOfYear(),
			    Carbon::now()->endOfYear(),
			] )->get();
		$array[ 'graphData' ] = Helper::buildGraphData( $currentYearEvents );
		die( json_encode( $array ) );
	}

	public function getPeakHours( $request ) {
		$array = array( 'action' => $request->get( 'action' ) );
		$visitors = Visitor::all()->where( 'checked_in', '=', 1 );
		$peakHours = Helper::getPeakHoursFromData( $visitors );
		$maxs = array_keys( $peakHours, max( $peakHours ) );
		$array[ 'peakHourTime' ] = $maxs[ 0 ];
		$data[ 'colorType' ] = 'yellowColor';
		$data[ 'percentage' ] = $peakHours[ $maxs[ 0 ] ];
		$array[ 'difference' ] = $data;
		die( json_encode( $array ) );
	}

	public function getEventsDataForClient( $request ) {

		$client_id = Auth::user()->id;
		$eventsData = array( 'totalEvents' => 0, 'action' => $request->get( 'action' ) );
		$events = Event::all()->where( 'status', '=', 1 )->where( 'user_id', '=', $client_id );
		$eventsData[ 'totalEvents' ] = count( $events );

		//Current month events
		$currentMonthEvents = Event::whereMonth(
				'created_at', '=', Carbon::now()->month
			)->where( 'status', '=', 1 )->where( 'user_id', '=', $client_id )->count();

		//Past Month events
		$previousMonthEvents = Event::whereMonth(
				'created_at', '=', Carbon::now()->subMonth()->month
			)->where( 'status', '=', 1 )->where( 'user_id', '=', $client_id )->count();

		$eventsData[ 'difference' ] = Helper::differenceBetweenTwoNumbers( $previousMonthEvents, $currentMonthEvents );
		die( json_encode( $eventsData ) );
	}

	public function getRegistrationsDataForClient( $request ) {

		$clientId = Auth::user()->id;

		$visitorsData = array( 'totalRegistrations' => 0, 'totalVisitors' => 0, 'action' => $request->get( 'action' ) );
		$events = Event::all()->where( 'status', '=', 1 )->where( 'user_id', '=', $clientId )->pluck( 'id' )->toArray();

		$visitors = Visitor::all()->whereIn( 'event_id', $events );
		$visitorsData[ 'totalRegistrations' ] = count( $visitors );
		//Current month events
		$currentMonthVisitors = Visitor::whereMonth(
				'created_at', '=', Carbon::now()->month
			)->whereIn( 'event_id', $events )->count();

		//Past Month events
		$previousMonthVisitors = Visitor::whereMonth(
				'created_at', '=', Carbon::now()->subMonth()->month
			)->whereIn( 'event_id', $events )->count();

		$visitorsData[ 'difference' ] = Helper::differenceBetweenTwoNumbers( $previousMonthVisitors, $currentMonthVisitors );

		die( json_encode( $visitorsData ) );
	}
	
	public function getVisitorsDataForClient( $request ) {

		$clientId = Auth::user()->id;

		$visitorsData = array( 'totalRegistrations' => 0, 'totalVisitors' => 0, 'action' => $request->get( 'action' ) );
		$events = Event::all()->where( 'status', '=', 1 )->where( 'user_id', '=', $clientId )->pluck( 'id' )->toArray();
		
		$visitors = Visitor::all()->whereIn( 'event_id', $events )->where( 'checked_in', '=', 1 );
		$visitorsData[ 'totalVisitors' ] = count( $visitors );
		//Current month events
		$currentMonthVisitors = Visitor::whereMonth(
				'created_at', '=', Carbon::now()->month
			)->whereIn( 'event_id', $events )->where( 'checked_in', '=', 1 )->count();

		//Past Month events
		$previousMonthVisitors = Visitor::whereMonth(
				'created_at', '=', Carbon::now()->subMonth()->month
			)->whereIn( 'event_id', $events )->where( 'checked_in', '=', 1 )->count();

		$visitorsData[ 'difference' ] = Helper::differenceBetweenTwoNumbers( $previousMonthVisitors, $currentMonthVisitors );

		die( json_encode( $visitorsData ) );
	}
	
	public function getClientPeakHours( $request ) {
		
		$clientId = Auth::user()->id;
		
		$events = Event::all()->where( 'status', '=', 1 )->where( 'user_id', '=', $clientId )->pluck( 'id' )->toArray();
		
		$array = array( 'action' => $request->get( 'action' ) );
		$visitors = Visitor::all()->whereIn( 'event_id', $events )->where( 'checked_in', '=', 1 );
		$peakHours = Helper::getPeakHoursFromData( $visitors );
		$maxs = array_keys( $peakHours, max( $peakHours ) );
		$array[ 'peakHourTime' ] = $maxs[ 0 ];
		$data[ 'colorType' ] = 'greenColor';
		$data[ 'percentage' ] = $peakHours[ $maxs[ 0 ] ];
		$array[ 'difference' ] = $data;
		die( json_encode( $array ) );
	}

}
