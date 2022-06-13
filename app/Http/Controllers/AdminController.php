<?php

namespace App\Http\Controllers;

use App\Event;
use Auth;
use Illuminate\Http\Request;
use App\Visitor;
use Helper;

class AdminController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $visitors = Visitor::where('checked_in', '=', 1)->orderBy('checkin_time', 'desc')->get()->take(5);
        $events = Event::all()->take(5);
        foreach ($events as $key => $event) {
            $data = array();
            $peakHours = Helper::getPeakHoursFromData($event->visitors);
            $maxs = array_keys($peakHours, max($peakHours));
            $event->checkin_count = $peakHours[$maxs[0]];
            $event->peakHourTime = $maxs[0];
            $events[$key] = $event;
        }
        return view('admin.index', compact('auth', 'visitors', 'events'));
    }

    public function checkInTiming()
    {
        $visitors = Visitor::where('checked_in', '=', 1)->orderBy('checkin_time', 'desc')->get();
        return view('admin.admin-checkintiming', compact('visitors'));
    }

    public function peakHourReport()
    {
        $events = Event::all();
        foreach ($events as $key => $event) {
            $data = array();
            $peakHours = Helper::getPeakHoursFromData($event->visitors);
            $maxs = array_keys($peakHours, max($peakHours));
            $event->checkin_count = $peakHours[$maxs[0]];
            $event->peakHourTime = $maxs[0];
            $events[$key] = $event;
        }
        return view('admin.admin-peak-hour-report', compact('events'));
    }
}
