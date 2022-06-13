<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Event;
use App\UserEvent;
use Helper;

class EventController extends Controller
{
    public function allevents()
    {
        $events = Event::all()->where('status', '=', 1);
        return view('admin.allevents')->with('events', $events);
    }
    public function addevent()
    {
        $clients = User::all()->where('role_id', '=', 3)->where('status', '=', 1);
        $managers = User::all()->where('role_id', '=', 2)->where('status', '=', 1);
        return view('admin.addevent', compact('clients', 'managers'));
    }
    public function storeEvent(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'venue_name' => 'required',
            'event-start-date' => 'required',
            'event-end-date' => 'required',
            'client' => 'required',
        ]);
        $event = new Event();
        $event->title = $request->get('title');
        $event->venue_name = $request->get('venue_name');
        $event->start_date = $request->get('event-start-date');
        $event->end_date = $request->get('event-end-date');
        $event->description = $request->get('description');
        $event->user_id = $request->get('client');
        if ($request->hasfile('event-avatar')) {
            $file = $request->file('event-avatar');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('img/userImages'), $filename);
            $event->event_avatar = $filename;
        } else {
            $event->event_avatar = '';
        }
        if ($event->user_id != -1) {
            $event->save();
            if ($request->get('managers')) {
                foreach ($request->get('managers') as $manager_id) {
                    $manager_event = new UserEvent();
                    $manager_event->user_id = $manager_id;
                    $manager_event->event_id = $event->id;
                    $manager_event->save();
                }
            }
            session()->flash('success', "Event created successfully");
        } else {
            session()->flash('error', "Client is required");
        }



        return redirect('admin/addevent');
    }

    public function editEvent($id)
    {
        $clients = User::all()->where('role_id', '=', 3)->where('status', '=', 1);
        $managers = User::all()->where('role_id', '=', 2)->where('status', '=', 1);
        $event = Event::find($id);
        return view('admin.editevent', compact('event', 'managers', 'clients'));
    }
    public function updateEvent(Request $request, $event_id)
    {
        $this->validate($request, [
            'title' => 'required',
            'venue_name' => 'required',
            'event-start-date' => 'required',
            'event-end-date' => 'required',
            'client' => 'required',
        ]);
        $event = Event::find($event_id);
        $event->title = $request->get('title');
        $event->venue_name = $request->get('venue_name');
        $event->start_date = $request->get('event-start-date');
        $event->end_date = $request->get('event-end-date');
        $event->description = $request->get('description');
        $event->user_id = $request->get('client');

        $avatar_link = Helper::saveFileToFolder($request, 'event-avatar');
        if ($avatar_link) {
            $event->event_avatar = $avatar_link;
        }

        foreach ($event->managers as $manager) {
            //Delete all the managers for this event
            $manager->pivot->delete();
        }
        if ($request->get('managers')) {
            foreach ($request->get('managers') as $manager_id) {
                //Update the latest managers
                $manager_event = new UserEvent();
                $manager_event->user_id = $manager_id;
                $manager_event->event_id = $event->id;
                $manager_event->save();
            }
        }

        if ($event->user_id != -1) {
            $event->save();
            session()->flash('success', "Event updated successfully");
        } else {
            session()->flash('error', "Client is required");
        }
        return Redirect::route('editevent', ['event_id' => $event_id]);
    }

    public function deleteEvent($event_id)
    {
        $response = array('error' => false, 'message' => 'User deleted');
        try {
            $event = Event::find($event_id);
            $event->status = 0;
            $event->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            $response['error'] = true;
            $response['message'] = "Error happend";
        }
        die(json_encode($response));
    }
}
