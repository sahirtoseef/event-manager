@extends('layout.manager')
@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
<link href="{{asset('css/jquery.datetimepicker.css')}}" rel="stylesheet" />
@endsection
@section('content')
<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="header-body">
            <!-- Card stats -->

        </div>
    </div>
</div>
<div class="container-fluid mt--7">

    <div class="row col-md-12">
        @if( $visitor )
            <form class="col-md-8" style="margin: 0 auto;" method="POST" action="{{route('editVisitor', [ 'id' => $visitor->id])}}" enctype="multipart/form-data">
                @csrf
                @if(session()->has('success'))
                <div class="alert alert-success"> {{session()->get('success')}} </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger"> {{session()->get('error')}} </div>
                @endif
                @if (count($errors) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-12 mb-4">
                    <div class="add-visitor-avatar">
                        @if( $visitor->photo )
                            <img src="{{ asset('img/userImages/' . $visitor->photo)}}" id="visitor-avatar-img" height="150" width="150" alt="image">
                        @else
                            <img src="{{ asset('img/avatar.png')}}" height="150" id="visitor-avatar-img" width="150" alt="image">
                        @endif
                        <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg"  id="visitor-avatar" class="form-control pointer-event">
                    </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Event</label>
                            <div class="input-group mb-4">
                                <select class="form-control" name="event_id">
                                    <option> Select Event</option>
                                    @foreach( $events as $event )
                                    @if( $visitor->event_id == $event->event_id )
                                        <option value="{{$event->event_id}}" selected="selected"> {{$event->title}} </option>
                                    @else
                                        <option value="{{$event->event_id}}"> {{$event->title}} </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Email</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input class="form-control" name="email" placeholder="Email" type="text" value="{{$visitor->email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">First Name</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" name="first_name" placeholder="First Name" type="text" value="{{$visitor->first_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Last Name</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" name="last_name" placeholder="Last Name" type="text" value="{{$visitor->last_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Display Name</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" name="display_name" placeholder="Display Name" type="text" value="{{$visitor->display_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Attendee Type</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                                </div>
                                <input class="form-control" name="attendee_type" placeholder="Attendee Type" type="text" value="{{$visitor->attendee_type}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Occupation</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                </div>
                                <input class="form-control" name="occupation" placeholder="Occupation" type="text" value="{{$visitor->occupation}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Country</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                </div>
                                <input class="form-control" name="country" placeholder="Country" type="text" value="{{$visitor->country}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Watch List</label>
                            <div class="input-group mb-4">
                                <select class="form-control" name="watch_list">
                                    <option> Select Watch List</option>
                                    @if($visitor->watch_list == 1)
                                        <option value="Yes" selected="selected"> Yes </option>
                                        <option value="No"> No </option>
                                    @elseif($visitor->watch_list == 0)
                                        <option value="Yes"> Yes </option>
                                        <option value="No" selected="selected"> No </option>
                                    @else
                                        <option value="Yes"> Yes </option>
                                        <option value="No"> No </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Phone</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input class="form-control" name="phone" placeholder="Phone" type="text" value="{{$visitor->phone}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Mobile Phone</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                                </div>
                                <input class="form-control" name="mobile_phone" placeholder="Mobile Phone" type="text" value="{{$visitor->mobile_phone}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Interest Tags</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                </div>
                                <input class="form-control" name="tags" placeholder="Interest Tags" type="text" value="{{$visitor->tags}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Language</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-language"></i></span>
                                </div>
                                <input class="form-control" name="language" placeholder="Language" type="text" value="{{$visitor->language}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Location</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                </div>
                                <input class="form-control" name="location" placeholder="Location" type="text" value="{{$visitor->location}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">City</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                </div>
                                <input class="form-control" name="city" placeholder="City" type="text" value="{{$visitor->city}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">State</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-compass"></i></span>
                                </div>
                                <input class="form-control" name="state" placeholder="State" type="text" value="{{$visitor->state}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Company</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                                <input class="form-control" name="company" placeholder="Company" type="text" value="{{$visitor->company}}">
                            </div>
                        </div>
                    </div>
                    </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">Update Visitor</button>
            </form>
        @else
            <form class="col-md-8" style="margin: 0 auto;" method="POST" action="{{route('storeVisitor')}}" enctype="multipart/form-data">
                @csrf
                @if(session()->has('success'))
                <div class="alert alert-success"> {{session()->get('success')}} </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger"> {{session()->get('error')}} </div>
                @endif
                @if (count($errors) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-12 mb-4">
                    <div class="add-visitor-avatar pointer-event">
                        <img src="{{ asset('img/avatar.png')}}" height="150" id="visitor-avatar-img" width="150" alt="image">
                        <input type="file" name="image" id="visitor-avatar" class="form-control pointer-event">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-control-label">Event</label>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <select class="form-control" name="event_id">
                                    <option> Select Event</option>
                                    @foreach( $events as $event )
                                        @if( $event_id == $event->event_id )
                                            <option value="{{$event->event_id}}" selected="selected"> {{$event->title}} </option>
                                        @else
                                            <option value="{{$event->event_id}}" > {{$event->title}} </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Email</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input class="form-control" name="email" placeholder="Email" type="text" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">First Name</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" name="first_name" placeholder="First Name" type="text" value="{{old('first_name')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Last Name</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" name="last_name" placeholder="Last Name" type="text" value="{{old('last_name')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Display Name</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" name="display_name" placeholder="Display Name" type="text" value="{{old('display_name')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Attendee Type</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                                </div>
                                <input class="form-control" name="attendee_type" placeholder="Attendee Type" type="text" value="{{old('attendee_type')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Occupation</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                </div>
                                <input class="form-control" name="occupation" placeholder="Occupation" type="text" value="{{old('occupation')}}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Country</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                </div>
                                <input class="form-control" name="country" placeholder="Country" type="text" value="{{old('country')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Watch List</label>
                            <div class="input-group mb-4">
                                <select class="form-control" name="watch_list">
                                    <option> Select Watch List</option>
                                    <option value="Yes"> Yes </option>
                                    <option value="No"> No </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Phone</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input class="form-control" name="phone" placeholder="Phone" type="text" value="{{old('phone')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Mobile Phone</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                                </div>
                                <input class="form-control" name="mobile_phone" placeholder="Mobile Phone" type="text" value="{{old('mobile_phone')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Interest Tags</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                </div>
                                <input class="form-control" name="tags" placeholder="Interest Tags" type="text" value="{{old('tags')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Language</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-language"></i></span>
                                </div>
                                <input class="form-control" name="language" placeholder="Language" type="text" value="{{old('language')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Location</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                </div>
                                <input class="form-control" name="location" placeholder="Location" type="text" value="{{old('location')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">City</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                </div>
                                <input class="form-control" name="city" placeholder="City" type="text" value="{{old('city')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">State</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-compass"></i></span>
                                </div>
                                <input class="form-control" name="state" placeholder="State" type="text" value="{{old('state')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Company</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                                <input class="form-control" name="company" placeholder="Company" type="text" value="{{old('company')}}">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">Add Visitor</button>
            </form>
        @endif
    </div>
    @section('body-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/jquery.datetimepicker.js')}}"></script>
    <script>
        $(document).ready(function() {
            if( getUrlParameter( "visitor_id" ) )
                $( ".view-page-name" ).html( "Edit Visitor" );
            else
                $( ".view-page-name" ).html( "Add Visitor" );
            $("#visitor-avatar").change( function() {
              readURL1(this);
            });
            function readURL1(input) {
              if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                  $("#visitor-avatar-img").attr("src", e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
              }
            }
            function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
            };

        });

    </script>
    @endsection
    @endsection