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
        <div class="col-md-12 mb-4">
            <div class="add-visitor-avatar" style="margin: 0px 40%;">
                @if( $visitor->photo )
                    <img src="{{ asset('img/userImages/' . $visitor->photo)}}" id="visitor-avatar-img" height="150" width="150" alt="image">
                @else
                    <img src="{{ asset('img/avatar.png')}}" height="150" id="visitor-avatar-img" width="150" alt="image">
                @endif
            </div>
        </div>
        <div class="row col-md-12">
            <div class="col-md-6" style="pointer-events: none;">
                <div class="form-group">
                    <label class="form-control-label">Event</label>
                    <div class="input-group mb-4">
                        <div class="form-control">{{$event->title ? $event->title : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Email</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->email ? $visitor->email : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">First Name</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->first_name ? $visitor->first_name : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Last Name</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->last_name ? $visitor->last_name : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Display Name</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->display_name ? $visitor->display_name : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Type</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->attendee_type ? $visitor->attendee_type : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Occupation</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->occupation ? $visitor->occupation : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Completed Registration</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->completed_registration ? "Yes" : "No"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Terms And Conditions Accepted</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->terms_and_conditions_accepted ? "Yes" : "No"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Directory Opt In</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->directory_opt_in ? $visitor->directory_opt_in : "No"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Directory Opt Out</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->directory_opt_out ? $visitor->directory_opt_out : "No"}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="pointer-events: none;">
                <div class="form-group">
                    <label class="form-control-label">Company</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->company ? $visitor->company : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Phone Number</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->phone ? $visitor->phone : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Mobiles Number</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->mobile_phone ? $visitor->mobile_phone : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Tags</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->tags ? $visitor->tags : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Language</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-language"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->language ? $visitor->language : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Location</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->location ? $visitor->location : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">City</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->city ? $visitor->city : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">State</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-compass"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->state ? $visitor->state : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Country</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->country ? $visitor->country : "N/A"}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Score</label>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-star-half-alt"></i></span>
                        </div>
                        <div class="form-control">{{$visitor->score ? $visitor->score : "N/A"}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('body-script')
    <script>
        $(document).ready(function() {
            $( ".view-page-name" ).html( "Visitor Detail" );
        });
    </script>
    @endsection
    @endsection