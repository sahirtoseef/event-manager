@extends('layout.manager')

@section('head-style')
    <link href="https://cdn.datatables.net/w/dt/dt-1.10.18/datatables.min.css" rel="stylesheet" />
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
    <div class="row col-md-12">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>WATCHLIST</th>
                    <th>CHECKED IN</th>
                    <th>CHECKED IN AT</th>
                    <th>BUTTON ACTIONS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $visitors as $visitor )
                <tr>
                    <td>{{$visitor->first_name . " " . $visitor->last_name ? $visitor->first_name . " " . $visitor->last_name : "N/A"}}</td>
                    <td>{{$visitor->email ? $visitor->email : "N/A"}}</td>
                    <td>{{$visitor->watch_list == 1 ? "Yes" : "No"}}</td>
                    <td>{{ ($visitor->checked_in == "1") ? "Yes" : "No" }}</td>
                    <td>{{ (date('d-m-Y h:i:s', strtotime($visitor->checkin_time)) != "01-01-1970 12:00:00") ? date('d-m-Y h:i:s', strtotime($visitor->checkin_time)) : "N/A"}}</td>
                    <td>
                        <a class="btn btn-outline-success btn-sm mark-sngle-visit showAttendanceModal" data-toggle="modal" href="javascript:void(0);" event-id="{{$visitor->event_id}}" data-id="{{$visitor->id}}" data-target="#mark-attendance-modal">Mark Attendance</a>
                        <a href="{{route('history', [ 'visitor_id' => $visitor->id ])}}" class="btn btn-outline-info btn-sm history-single-visit">History</a>
                    </td>
                    <td class="text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" href="{{route('addvisitor', [ 'visitor_id' => $visitor->id ])}}">Edit</a>
                                <a class="dropdown-item" href="{{route('visitorDetails', [ 'visitor_id' => $visitor->id ])}}">Details</a>
                                <a class="dropdown-item delete_visitor" data-toggle="modal" href="javascript:void(0);" data-id="{{$visitor->id}}" data-target="#visitor_delete_modal">Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>WATCHLIST</th>
                    <th>CHECKED IN</th>
                    <th>CHECKED IN AT</th>
                    <th>BUTTON ACTIONS</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
        </table>

    </div>
    <div id="visitor_delete_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <!-- Modal content-->
          <div class="modal-content" style="height: 250px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are sure you want to delete this visitor...</p>
            </div>
            <form method="POST" action="{{route('deleteVisitor')}}">
                @csrf
                <input type="hidden" name="visitor_id" value="" class="del_visitor_id">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" >Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>

        </div>
      </div>
    
    <div class="modal fade modal-mark" id="mark-attendance-modal" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
	     aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-sucess">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                    <div class="row">
                        <div class="col-md-12 pr-0" style="">
                            <label class="form-control-label text-white">Location</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="get-location-url" value="{{route('eventLocation')}}">
                                    <select class="form-control event_location" name="event_location">
                                        <option class="location-val">Select Location</option>
                                    </select>
                                </div>
                                <p class="danger-content select-location" style="display: none;"> Please select location... </p>
                            </div>
                        </div>
                    </div>
                    <p class="mark-desc">Mark attendance for this visitor. Select above options...</p>
                    <input type="hidden" name="visitor_id" value="" class="attendence-visitor-id">
                    <input type="hidden" name="event_id" value="{{$event_id}}" class="event_id">
                    <input type="hidden" class="markSingleAttendance" value="{{route('markSingleAttendance')}}" >
                    @csrf
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary markSingleAttendance-btn" >Mark Attendance</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="modal-danger" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
	     aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-danger">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                    <i class="fa fa-times-circle fa-5x"></i>
                    <h1 class="text-white mt-2">Visitor does not exist</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Mark Another Visitor</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade modal-success" id="modal-success" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
	     aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-sucess">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                <i class="fa fa-check-circle fa-5x"></i>
                <!--<h2 class="text-white mt-2 mb-0 m-user_name"></h2>-->
                <h1 class="text-white">CheckedIn Successfull...</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Mark Another Visitor</button>
                </div>
            </div>
        </div>
    </div>
    
     <div class="modal fade modal-warning" id="modal-warning" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
	     aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-warning">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                    <i class="fa fa-exclamation-circle fa-5x"></i>
                    <!--<h2 class="text-white mt-2 mb-0 m-user_name"></h2>-->
                    <h1 class="text-white">Already CheckedIn</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Mark Another Visitor</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade modal-warning" id="modal-warninges" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
	     aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-warning">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                    <i class="fa fa-exclamation-circle fa-5x"></i>
                    <!--<h2 class="text-white mt-2 mb-0 m-user_name"></h2>-->
                    <h1 class="text-white">No code found...</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Mark Another Visitor</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('body-script')
    <!--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
    <script src="https://cdn.datatables.net/w/dt/dt-1.10.18/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $( "footer.footer" ).addClass( "container-fluid" );
            $( ".view-page-name" ).html( "All Visitors" );
            $( ".delete_visitor" ).on( "click", function(){
                $( ".del_visitor_id" ).val( $( this ).attr( "data-id" ) );
            } );
            $( ".showAttendanceModal" ).on( "click", function(){
                $(".event_id")[0].selectedIndex = 0;
                $(".event_location")[0].selectedIndex = 0;
                $( ".attendence-visitor-id" ).val( $( this ).attr( "data-id" ) );
                var event = $( this ).attr( "event-id" );
                $( ".event_id" ).val( event );
                $( ".event_id option" ).each( function(){
                    if( $(this).val() == event ){
                        $(this).prop( "selected", true );
                        $( ".event_id" ).change();
                    }
                } );
            } );
            
            $('#example').DataTable();
            
            $( document ).delegate( ".markSingleAttendance-btn",'click', function(){
                if( $( ".event_id").val() == "Select Event" ){
                    $( ".select-event" ).show();
                }else{
                    $( ".select-event" ).hide();
                }
                if( $( ".event_location" ).val() == "Select Location" || $( ".event_location" ).val() == null ){
                    $( ".select-location" ).show();
                }else{
                    $( ".select-location" ).hide();
                }
                if( ( $( ".event_location" ).val() != "Select Location") && $( ".event_id").val() != "Select Event" ){
                    $( ".loader-container" ).show();
                    $( "#mark-attendance-modal" ).modal( "hide" );
                    $.ajax({
                    type: "POST",
                    url: $( this ).parent().parent().find( ".markSingleAttendance" ).val(),
                    data: { 
                        visitor_id: $( ".attendence-visitor-id" ).val(),
                        event_location: $( ".event_location" ).val(),
                        event_id: $( ".event_id" ).val(),
                    },
                    cache: false,
                    headers: {
                        "X-CSRF-TOKEN": $( this ).parent().parent().find('input[name="_token"]').val()
                    },
                    success: function(data, status, jqXHR) {
                        var visitors = JSON.parse(data);
                        var response = visitors.data;
                        var popup;
                        if( typeof visitors.success != "undefined" && visitors.success == 1  ){
                            $( ".loader-container" ).hide();
                            $( "#mark-attendance-modal" ).modal( "hide" );
                            popup = $( "#modal-success" );
                            popup.modal( "show" );
                            popup.find( ".m-user_name" ).text( response.display_name );
                        }else if( typeof visitors.errors != "undefined" && visitors.errors == 1  ){
                            $( ".loader-container" ).hide();
                            $( "#mark-attendance-modal" ).modal( "hide" );
                            popup = $( "#modal-warning" ).modal( );
//                            popup.modal("show");
                            popup.find( ".m-user_name" ).text( response.display_name );
                        }else if( typeof visitors.errores != "undefined" && visitors.errores == 1  ){
                            $( ".loader-container" ).hide();
                            $( "#mark-attendance-modal" ).modal( "hide" );
                            popup = $( "#modal-warninges" );
                            popup.modal("show");
                            popup.find( ".m-user_name" ).text( response.first_name + " " + response.last_name );
                        }else{
                            $( ".loader-container" ).hide();
                            $( "#mark-attendance-modal" ).modal( "hide" );
                            popup = $( "#modal-danger" );
                            popup.modal("show");
                        }
                    },
                    error: function(error, jqXHR, status) {
                        $( ".loader-container" ).hide();
                        $( "#mark-attendance-modal" ).modal( "hide" );
                        popup = $( "#modal-danger" );
                        popup.modal("show");
                    }
                  });
              }
            } );
            $( ".event_location" ).on( "change", function(){
                if( $( ".event_id").val() == "Select Event" ){
                    $( ".select-event" ).show();
                }else{
                    $( ".select-event" ).hide();
                }
                if( $( ".event_location" ).val() == "Select Location" || $( ".event_location" ).val() == null ){
                    $( ".select-location" ).show();
                }else{
                    $( ".select-location" ).hide();
                }
            } );
            
                if( $( ".event_id").val() == "Select Event" ){
                    $( ".select-event" ).show();
                }else{
                    $( ".select-event" ).hide();
                }
                if( $( ".event_location" ).val() == "Select Location" || $( ".event_location" ).val() == null ){
                    $( ".select-location" ).show();
                }else{
                    $( ".select-location" ).hide();
                }
                $( '.location-val' ).not( ":first" ).remove();
                $( ".loader-container" ).show();
                $.ajax({
                type: "POST",
                    url: $( ".get-location-url" ).val(),
                data: { 
                    event_id: $( '.event_id' ).val(),
                },
                cache: false,
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                success: function(data, status, jqXHR) {
                    var visitors = JSON.parse(data);
                    if( visitors.success == 1  ){
                        $( ".location-not-found" ).hide();
                        var response = visitors.data;
                        if( typeof response != "undefined" ){
                          for( var i = 0; i < response.length; i++ ){
                              var visitor = response[i];
                              var clone = $( '.location-val:first' ).clone();
                                clone.val( visitor.id );
                                clone.html( visitor.name );
    //                            clone.find( '.visitor_id' ).val( visitor.uni_id );
                                clone.show().appendTo( $( ".event_location" ) );
                            }
                            $( ".loader-container" ).hide();
                        }else{
                            $( ".loader-container" ).hide();
                            $( ".location-not-found" ).show();
                            $( ".select-location" ).hide();
                        }
                    }else{
                        $( ".loader-container" ).hide();
                        $( ".location-not-found" ).show();
                        $( ".select-location" ).hide();
                    }
                },
                error: function(error, jqXHR, status) {
                    $( ".loader-container" ).hide();
                    $( ".location-not-found" ).show();
                    $( ".select-location" ).hide();
                }
            } );
            
        });
    </script>
@endsection
@endsection
