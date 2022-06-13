<?php

namespace App\Http\Controllers;

use App\User;
use App\Visitor;
use App\Event;
use App\UserEvent;
use App\CheckinAttempt;
use App\EventLocation;
use Helper;
use Auth;
use Str;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use IsEmpty;
use Illuminate\Support\Facades\Mail;
use App\Mail\QRMail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;
class ManagerController extends Controller
{
    public function index()
    {
        Helper::setSessionData( 3 );
        $auth = Auth::user();
        $events_count = Event::join("user_events", "user_events.event_id", "=", "events.id")
                ->where( 'user_events.user_id', "=", $auth->id )->where('status', '=', 1)->count();
        $all_events = Event::join("user_events", "user_events.event_id", "=", "events.id")
                ->where( 'user_events.user_id', "=", $auth->id )->where('status', '=', 1)->get();
        
        $all_visitos = Visitor::all()->count();
        $av_events = Event::all()->count();
        $events = [];
        $user_count = 0;
        foreach ( $all_events as $k => $event ){
            $events[] = array( 
                'title' => $event->title,
                'venue_name' => $event->venue_name,
                'avatar' => $event->event_avatar,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                );
            try {
                $users = Visitor::where( 'event_id', "=", $event->id )->get();
                foreach( $users as $user ){
                    $user_count++;
                    $events[$k]['user'][] = array(
                        'name' => $user->display_name,
                        'avatar' => $user->photo
                    );
                }
            } catch (\Exception $ex) {
                $events[$k]['user'] = [];
            }
        }
        $user_count = $user_count;
        $user_average = ( $user_count / $all_visitos ) * 100;
        $events_average = ( $events_count / $av_events ) * 100;
        
        return view( 'manager.index', compact( 'auth', 'events', 'events_count', 'user_count','user_average', 'events_average' ) );
    }
    public function getChartData(){
        $auth = Auth::user();
        $all_events = Event::join("user_events", "user_events.event_id", "=", "events.id")
                ->where( 'user_events.user_id', "=", $auth->id )->where('status', '=', 1)->get();
        $events = [];
        foreach ( $all_events as $k => $event ){
            $events['labels'][] = $event->title;
            $events['datasets'] = [];
            $user_events = Visitor::where( 'event_id', "=", $event->id )->count();
            $user_event[] = $user_events;
            $events['datasets'][] = ["label" => 'Events',   "data" => $user_event ];
        
        }
            
        if( !empty( $events ) ){
            $data = array(
                'data' => $events,
                'success' => 1
            );
        }
        else{
            $data = array(
                'data' => 'No data found...',
                'error' => 1
            );
        }
                
        die( json_encode( $data ) );
    }

    public function registerManagers()
    {
        $managers = User::all()->where('role_id', '=', 2)->where('status', '=', 1);
        return view('admin.registermanagers')->with('managers', $managers);
    }
    public function createManager()
    {
        $auth = Auth::user();
        return view('admin.createmanager', compact( 'auth' ));
    }
    public function attendence()
    {
        $event_id = Helper::getSessionData();
        $auth = Auth::user();
        $visitors = Visitor::where( "checked_in" , "=", null )->get();
        return view('manager.attendence', compact( 'auth', 'visitors', 'events', 'event_id' ));
    }
    
    public function searchAttendee( Request $request ){
        $event_id = Helper::getSessionData();
        if( $request->search != "" ){
            $visitors = Visitor::where( 'email', 'like', "%$request->search%" )
                    ->where( "event_id", '=', $event_id )->get();
            if( !$visitors->isEmpty() ){
                $data = array(
                    'data' => $visitors,
                    'success' => 1
                );
            }
            else{
                $data = array(
                    'data' => 'No data found...',
                    'error' => 1
                );
            }
        
        }else{
            $data = array(
                'data' => 'No data found...',
                'error' => 1
            );
        }
                
        die( json_encode( $data ) );
    }
    
    public function eventLocation( Request $request ){
        $visitors = EventLocation::join('locations', 'locations.id', '=', 'event_locations.location_id')
                ->where( 'event_locations.event_id', '=', $request->event_id )->get();
        if( !$visitors->isEmpty() ){
            $data = array(
                'data' => $visitors,
                'success' => 1
            );
        }
        else{
            $data = array(
                'data' => 'No data found...',
                'error' => 1
            );
        }
                
        die( json_encode( $data ) );
    }
    
    public function markQRAttendance( Request $request ){
        $event_id = Helper::getSessionData();
        $input = $request->all();
        $auth = Auth::user();
        $visitor = Visitor::where( "uni_id", "=", $input['visitor_id'] )->where( "event_id", '=', $event_id )->first();
        if( !empty( $visitor ) ){
            $id = $visitor->id;
            if( $visitor->checked_in == null  ){
                $input['checked_in'] = 1;
                $datetime = Carbon::now();
                $input[ 'checkin_time' ] = $datetime->toDateTimeString();
                $visitor = $visitor->update( $input );
                $checkin = array(
                    'manager_id' => $auth->id,
                    'visitor_id' => $id,
                    'location' => '',
                    'status' => 1,
                    'event_id' => $event_id,
                    'qr_code' => $input['visitor_id'],
                    'location' => $input['event_location'],
                );
                CheckinAttempt::create( $checkin );
                $visitors = Visitor::findOrFail( $id );
                $data = array(
                    'data' => $visitors,
                    'success' => 1
                );
            }else{
                $checkin = array(
                    'manager_id' => $auth->id,
                    'visitor_id' => $visitor->id,
                    'location' => '',
                    'status' => 2,
                    'qr_code' => $input['visitor_id'],
                    'location' => $input['event_location'],
                    'event_id' => $event_id,
                );
                CheckinAttempt::create( $checkin );
                $data = array(
                    'data' => $visitor,
                    'errors' => 1
                );
            }
        }
        else{
            $checkin = array(
                    'manager_id' => $auth->id,
                    'location' => '',
                    'status' => 3,
                    'qr_code' => $input['visitor_id'],
                    'location' => $input['event_location'],
                    'event_id' => $event_id,
                );
            CheckinAttempt::create( $checkin );
            $data = array(
                'data' => 'No data found...',
                'error' => 1
            );
        }
                
        die( json_encode( $data ) );
    }
    
    public function markAttendance( Request $request ){
        $event_id = Helper::getSessionData();
        $input = $request->all();
        $auth = Auth::user();
        
        $visitor = Visitor::where( "id", "=", $input['visitor_id'] )->where( "event_id", '=', $event_id )->first();
        if( !empty( $visitor ) ){
            $id = $visitor->id;
            if( $visitor->checked_in == null  ){
                $input['checked_in'] = 1;
                $datetime = Carbon::now();
                $input[ 'checkin_time' ] = $datetime->toDateTimeString();
                $visitor = $visitor->update( $input );
                $checkin = array(
                    'manager_id' => $auth->id,
                    'visitor_id' => $id,
                    'location' => '',
                    'status' => 1,
                    'qr_code' => $input['visitor_id'],
                    'location' => $input['event_location'],
                    'event_id' => $event_id,
                );
                CheckinAttempt::create( $checkin );
                $visitors = Visitor::findOrFail( $id );
                $data = array(
                    'data' => $visitors,
                    'success' => 1
                );
            }else{
                $checkin = array(
                    'manager_id' => $auth->id,
                    'visitor_id' => $visitor->id,
                    'location' => '',
                    'status' => 2,
                    'qr_code' => $input['visitor_id'],
                    'location' => $input['event_location'],
                    'event_id' => $event_id,
                );
                CheckinAttempt::create( $checkin );
                $data = array(
                    'data' => $visitor,
                    'errors' => 1
                );
            }
        }
        else{
            $checkin = array(
                    'manager_id' => $auth->id,
                    'location' => '',
                    'status' => 3,
                    'qr_code' => $input['visitor_id'],
                    'visitor_id' => 1,
                    'location' => $input['event_location'],
                    'event_id' => $event_id,
                );
            CheckinAttempt::create( $checkin );
            $data = array(
                'data' => 'No data found...',
                'error' => 1
            );
        }
                
        die( json_encode( $data ) );
    }
    public function markSingleAttendance( Request $request ){
        $input = $request->all();
        $auth = Auth::user();
        $visitor = Visitor::where( "id", "=", $input['visitor_id'] )
                ->where( "event_id", "=", $input['event_id'] )->first();
        if( !empty( $visitor ) ){
                $id = $visitor->id;
                if( $visitor->checked_in == null  ){
                    $input['checked_in'] = 1;
                    $datetime = Carbon::now();
                    $input[ 'checkin_time' ] = $datetime->toDateTimeString();
                    $visitor = $visitor->update( $input );
                    $visitors = Visitor::findOrFail( $id );
                    $checkin = array(
                        'manager_id' => $auth->id,
                        'visitor_id' => $id,
                        'location' => '',
                        'status' => 1,
                        'qr_code' => $visitors->uni_id,
                        'location' => $input['event_location'],
                        'event_id' => $input['event_id'],
                    );
                    CheckinAttempt::create( $checkin );
                    $data = array(
                        'data' => $visitors,
                        'success' => 1
                    );
                }else{
                    $checkin = array(
                        'manager_id' => $auth->id,
                        'visitor_id' => $visitor->id,
                        'location' => '',
                        'status' => 2,
                        'qr_code' => $visitor->uni_id,
                        'location' => $input['event_location'],
                        'event_id' => $input['event_id'],
                    );
                    CheckinAttempt::create( $checkin );
                    $data = array(
                        'data' => $visitor,
                        'errors' => 1
                    );
                }
        }
        else{
            $checkin = array(
                    'manager_id' => $auth->id,
                    'location' => '',
                    'status' => 3,
                    'qr_code' => $visitor->uni_id,
                    'visitor_id' => 1,
                    'location' => $input['event_location'],
                    'event_id' => $input['event_id'],
                );
            CheckinAttempt::create( $checkin );
            $data = array(
                'data' => 'No data found...',
                'error' => 1
            );
        }
                
        die( json_encode( $data ) );
    }
    
    public function addVisitor(Request $request)
    {
        $event_id = Helper::getSessionData();
        $auth = Auth::user();
        $id = $request->all();
        $visitor = [];
        if( !empty( $id ) )
            $visitor = Visitor::findOrFail( $id[ 'visitor_id' ] );
        $events = Event::join("user_events", "user_events.event_id", "=", "events.id")
                ->where( 'user_events.user_id', "=", $auth->id )->where('status', '=', 1)->get();
        return view( 'manager.addvisitor', compact( 'events', 'visitor', 'auth', 'event_id' ) );
    }
    
    public function visitorDetails(Request $request)
    {
        $event_id = Helper::getSessionData();
        $event = Event::findOrFail( $event_id );
        $auth = Auth::user();
        $id = $request->all();
        $visitor = Visitor::findOrFail( $id[ 'visitor_id' ] );
        $events = Event::join("user_events", "user_events.event_id", "=", "events.id")
                ->where( 'user_events.user_id', "=", $auth->id )->where('status', '=', 1)->get();
        return view( 'manager.visitordetails', compact( 'events', 'visitor', 'auth', 'event' ) );
    }

    public function addBulk()
    {
        $auth = Auth::user();
        $events = Event::join("user_events", "user_events.event_id", "=", "events.id")
                ->where( 'user_events.user_id', "=", $auth->id )->where('status', '=', 1)->get();
        return view('manager.addbulk', compact( 'auth', 'events' ));
    }

    public function allVisitors()
    {
        $event_id = Helper::getSessionData();
        $auth = Auth::user();
        $visitors = Visitor::all()->where( "manager_id", "=", $auth->id );
        $events = Event::join("user_events", "user_events.event_id", "=", "events.id")
                ->where( 'user_events.user_id', "=", $auth->id )->where('status', '=', 1)->get();
        
        return view( 'manager.allvisitors', compact( 'visitors', 'auth', 'events', 'event_id' ) );
    }
    
    public function visitorHistory()
    {
        $auth = Auth::user();
        $visitors = DB::table('checkin_attempts')
            ->join('events', 'events.id', '=', 'checkin_attempts.event_id')
            ->join('visitors', 'checkin_attempts.visitor_id', '=', 'visitors.id')
            ->join('locations', 'locations.id', '=', 'checkin_attempts.location')
            ->select('visitors.*', 'checkin_attempts.status', 'checkin_attempts.qr_code', 'locations.name', 'events.title')
            ->where( "checkin_attempts.manager_id", "=", $auth->id )
            ->get();
        return view( 'manager.visitorshistory', compact( 'visitors', 'auth' ) );
    }
    public function existsHistory()
    {
        $auth = Auth::user();
        $visitors = DB::table('checkin_attempts')
            ->join('events', 'events.id', '=', 'checkin_attempts.event_id')
            ->join('locations', 'locations.id', '=', 'checkin_attempts.location')
            ->select('checkin_attempts.status', 'checkin_attempts.qr_code', 'locations.name', 'checkin_attempts.created_at', 'events.title')
            ->where( "checkin_attempts.manager_id", "=", $auth->id )
            ->where( "checkin_attempts.visitor_id", "=", null )
            ->get();
        return view( 'manager.existshistory', compact( 'visitors', 'auth' ) );
    }
    
    public function history( Request $request )
    {
        $auth = Auth::user();
        $visitors = DB::table('checkin_attempts')
            ->join('events', 'events.id', '=', 'checkin_attempts.event_id')
            ->join('visitors', 'checkin_attempts.visitor_id', '=', 'visitors.id')
            ->join('locations', 'locations.id', '=', 'checkin_attempts.location')
            ->select('visitors.*', 'checkin_attempts.status', 'checkin_attempts.qr_code', 'locations.name', 'checkin_attempts.created_at', 'events.title')
            ->where( "checkin_attempts.visitor_id", "=", $request->visitor_id )
            ->get();
        
        return view( 'manager.history', compact( 'visitors', 'auth' ) );
    }
    
    public function storeVisitor( Request $request ){
        $valid = $request->validate([
                'email' => 'required|email',
                'display_name' => 'required|min:3',
                'first_name' => 'required',
                'last_name' => 'required',
                'image' => 'required|image|mimes:jpg,png,gif,jpeg',
        ]);
        if( $valid ){
            $auth = Auth::user();
            $input = $request->all();
            try {
                $image = Helper::saveFileToFolder($request, 'image');
                $input[ 'photo' ] = $image;
                $input[ 'manager_id' ] = $auth->id;
                $input[ 'uni_id' ] = Str::random(20);
                $input[ 'password' ] = "123";
                if( $input[ 'watch_list' ] == "Yes" )
                    $input[ 'watch_list' ] = 1;
                else
                    $input[ 'watch_list' ] = 0;
                
                try {
                    $visitor = Visitor::create($input);
                } catch (\Exception $ex) {
                    session()->flash('error', "Visitor not added. Please check all fields...");
                    return back();
                }
                
                $email = $visitor->email;
                $uni_id = $visitor->uni_id;
                $qr = QrCode::format('png')
                            ->size(250)
                            ->generate(  $uni_id );
                $output_file = 'img-' . $uni_id . '.png';
                $image = Storage::disk('publics')->put( $output_file, $qr );
                if( $qr ){
                    if( $visitor->watch_list == 1 ){
                        try {
                            Mail::to( 'testtinngs@gmail.com' )->send( new QRMail($output_file) );
                        } catch (\Exception $ex) {
                            session()->flash('success', "Special Guest added successfully...");
                            return redirect('manager/allvisitors');
                        }
                    }else{
                        try {
                            Mail::to( $email )->send( new QRMail($output_file) );
                        } catch (\Exception $ex) {
                            session()->flash('success', "Visitor added successfully...");
                            return redirect('manager/allvisitors');
                        }
                    }
                }
                
                session()->flash('success', "Visitor added successfully...");
                return redirect('manager/allvisitors');
            } catch ( \Exception $ex ) {
                session()->flash('error', "Something went wrong...");
            }    
        }else{
            session()->flash('error', "Fields are required...");
        }
        
    }
    
    public function editVisitor( Request $request ){
        $valid = $request->validate([
                'email' => 'required|email',
                'display_name' => 'required|min:3',
                'first_name' => 'required',
                'last_name' => 'required',
        ]);
        $input = $request->all();
        $visitor = Visitor::findOrFail( $input['id'] );
        
        if( $valid ){
            $auth = Auth::user();
            try {
                $code = 0;
                $image = Helper::saveFileToFolder($request, 'image');
                $input[ 'photo' ] = $image;
                if( isset( $input[ 'password' ] ) != "" && isset( $input[ 'confirm_password' ] ) != "" ){
                    if( isset( $input[ 'password' ] ) == isset( $input[ 'confirm_password' ] ) )
                        $input[ 'password' ] = $input[ 'password' ];
                    else
                        $input[ 'password' ] = $visitor->password;
                }else{
                    $input[ 'password' ] = $visitor->password;
                }
                if( $input[ 'watch_list' ] == "Yes" )
                    $input[ 'watch_list' ] = 1;
                else
                    $input[ 'watch_list' ] = 0;
                
                $input[ 'manager_id' ] = $auth->id;
                if( $visitor->uni_id == null ){
                    $input[ 'uni_id' ] = Str::random(20);
                    $code = 1;
                }
                
                $visitor = $visitor->update( $input );
                if( $code == 1 ){
                    $visitors = Visitor::findOrFail( $input['id'] );
                    $email = $visitors->email;
                    $qr = QrCode::format('png')
                                ->size(250)
                                ->generate(  $visitors->uni_id );
                    $output_file = 'img-' . $visitors->uni_id . '.png';
                    $image = Storage::disk('publics')->put( $output_file, $qr );
                    try {
                        Mail::to( $email )->send( new QRMail($output_file) );
                    } catch (\Exception $ex) {
                        session()->flash('success', "Visitor added successfully, Email is not send to his/her email...");
                        return redirect('manager/allvisitors');
                    }
                }
                
                session()->flash('success', "Visitor updated successfully...");
                return redirect('manager/allvisitors');
            } catch ( \Exception $ex ) {
                session()->flash('error', "Something went wrong...");
                return back();
            }    
        }else{
            session()->flash('error', "Fields are required...");
            return back();
        }
        
    }
    public function deleteVisitor( Request $request ){
        $id = $request->all();
        
        $visitor = Visitor::findOrFail( $id['visitor_id'] );
        $visitor->delete();
        
        session()->flash('error', "Visitor deleted successfully...");
        return redirect('manager/allvisitors');
        
    }
    
    public function csvStoreVisitor( Request $request ){
            $valid = $request->validate([
                'csv' => 'required',
            ]);
            $auth = Auth::user();
            $success = 0;
            $file = $request->file('csv');
            $event_id = Helper::getEventId();
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            $valid_extension = array("csv");

            // 2MB in Bytes
            $maxFileSize = 2097152123213; 

            
            if(in_array(strtolower($extension),$valid_extension)){
              if($fileSize <= $maxFileSize){
                $location = 'files';
                try {
                    $file->move($location,$filename);
                    $filepath = public_path($location."/".$filename);
                    $customerArr = $this->csvToArray($filepath);   
                } catch (Exception $ex) {
                    session()->flash('error', "Something went wrong with file...");
                    return back();
                }
                 try {
                    for ($i = 0; $i < count($customerArr); $i ++){
                        $input = array( 
                            'manager_id' => $auth->id,
                            'event_id' => $event_id,
                            'email' => isset( $customerArr[$i]['Email']) ? $customerArr[$i]['Email'] : "N/A",
                            'uni_id' => isset( $customerArr[$i]['Client Custom ID'] ) ? $customerArr[$i]['Client Custom ID'] : null,
                            'first_name' => isset( $customerArr[$i]['First Name'] ) ? $customerArr[$i]['First Name'] : "N/A",
                            'last_name' => isset( $customerArr[$i]['Last Name'] ) ? $customerArr[$i]['Last Name'] : "N/A",
                            'attendee_type' => isset( $customerArr[$i]['Attendee Type'] ) ? $customerArr[$i]['Attendee Type'] : null,
                            'occupation' => isset( $customerArr[$i]['Occupation'] ) ? $customerArr[$i]['Occupation'] : null,
                            'company' => isset( $customerArr[$i]['Company'] ) ? $customerArr[$i]['Company'] : null,
                            'location' => isset( $customerArr[$i]['Location'] ) ? $customerArr[$i]['Location'] : null,
                            'phone' => isset( $customerArr[$i]['Phone'] ) ? $customerArr[$i]['Phone'] : null,
                            'mobile_phone' => isset( $customerArr[$i]['Mobile Phone'] ) ? $customerArr[$i]['Mobile Phone'] : null,
                            'photo' => isset( $customerArr[$i]['Photo'] ) ? $customerArr[$i]['Photo'] : null,
                            'client_id' => isset( $customerArr[$i]['Client Custom ID'] ) ? $customerArr[$i]['Client Custom ID'] : null,
                            'tags' => isset( $customerArr[$i]['Interest Tags'] ) ? $customerArr[$i]['Interest Tags'] : null,
                            'language' => isset( $customerArr[$i]['Language'] ) ? $customerArr[$i]['Language'] : null,
                            'city' => isset( $customerArr[$i]['City'] ) ? $customerArr[$i]['City'] : null,
                            'state' => isset( $customerArr[$i]['State'] ) ? $customerArr[$i]['State'] : null,
                            'country' => isset( $customerArr[$i]['Country'] ) ? $customerArr[$i]['Country'] : null,
                            'display_name' => isset( $customerArr[$i]['Display Name'] ) ? $customerArr[$i]['Display Name'] : "N/A",
                            'completed_registration' => isset( $customerArr[$i]['Completed Registration'] ) ? $customerArr[$i]['Completed Registration'] : null,
                            'checked_in' => isset( $customerArr[$i]['Checked In'] ) ? $customerArr[$i]['Checked In'] : null,
                            'terms_and_conditions_accepted' => isset( $customerArr[$i]['Terms And Conditions Accepted'] ) ? $customerArr[$i]['Terms And Conditions Accepted'] : null,
                            'directory_opt_in' => isset( $customerArr[$i]['Directory Opt In'] ) ? $customerArr[$i]['Directory Opt In'] : null,
                            'directory_opt_out' => isset( $customerArr[$i]['Opt Out'] ) ? $customerArr[$i]['Opt Out'] : null,
                            'score' => isset( $customerArr[$i]['Score'] ) ? $customerArr[$i]['Score'] : "null",
                            'password' => isset( $customerArr[$i]['Password'] ) ? $customerArr[$i]['Password'] : "N/A",
                            'kliks' => isset( $customerArr[$i]['Kliks'] ) ? $customerArr[$i]['Kliks'] : null,
                            'number_of_connections' => isset( $customerArr[$i]['Number Of Connections'] ) ? $customerArr[$i]['Number Of Connections'] : null,
                            'registration_status' => isset( $customerArr[$i]['Registration Status'] ) ? $customerArr[$i]['Registration Status'] : null,
                            'checkin_time' => isset( $customerArr[$i]['Checkin Time'] ) ? $customerArr[$i]['Checkin Time'] : null,
                            'login_link' => isset( $customerArr[$i]['Login Link'] ) ? $customerArr[$i]['Login Link'] : null,
                            'wearable_id' => isset( $customerArr[$i]['Wearable ID'] ) ? $customerArr[$i]['Wearable ID'] : null,
                            'wearable_rf_id' => isset( $customerArr[$i]['Wearable RFID'] ) ? $customerArr[$i]['Wearable RFID'] : null,
                            'watch_list' => 0
                        );
                        try {
                            $visitors = Visitor::where( 'email' , '=', isset( $customerArr[$i]['Email']) )
                                    ->where( "event_id", "=", $event_id )->first();
                            if( !empty( $visitors ) ){
                                $update = $visitors->update( $input );
                                $success = 1;
                            }else{
                                $visitor = Visitor::create( $input );
                                $success = 1;
                            }   
                        } catch (\Exception $ex) {
                            session()->flash('error', "Something went wrong...");
                            return back();
                        }
                    }
                    if( $success == 1 ){
                        session()->flash('success', "Visitor added successfully...");
                        return redirect('manager/allvisitors');
                    }else{
                        session()->flash('erorr', "Visitors not added. Something went wrong...");
                        return back();
                    }
                 } catch (Exception $ex) {
                    session()->flash('error', "CSV data is not formated...");
                    return back();
                 }
              }else{
                  session()->flash('error', "File too large. File must be less than 2MB...");
                  return back();
              }

            }else{
                session()->flash('error', "Invalid File Extension...");
                return back();
            }
    }
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
}
}
