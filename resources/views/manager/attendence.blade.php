@extends('layout.manager')

@section('head-style')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content')
<style>
    #scanCont svg{
        width: 100%;
        height: 100%;
    }
</style>
<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
@if(session()->has('success'))
<div class="alert alert-success" style="z-index: 1;margin-top: 10px;"> {{session()->get('success')}} </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger" style="z-index: 1;margin-top: 10px;"> {{session()->get('error')}} </div>
@endif
@if (count($errors) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="alert alert-danger" style="z-index: 1;margin-top: 10px;">
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
<div style="">
    
</div>
<div class="attendence container-fluid mt--7">
    <input type="hidden" class="event_id" value="{{$event_id}}">
    <input type="hidden" class="get-location-url" value="{{route('eventLocation')}}">
    <div class="col-md-12 pr-0">
        <label class="form-control-label text-white">Location</label>
        <div class="form-group">
            <div class="input-group mb-4">
                <select class="form-control event_location" name="event_location">
                    <option class="location-val">Select Location</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-5 scan-btns qr" id="scanQrBtn">
            <div class="overlay">
                <h1>By QR Code</h1>
            </div>
        </div>
        <div class="col-md-2 or-btn">
            <!--<h1 style="text-align: center;width: 100%;margin-top: 20px;">OR</h1>-->   
        </div>
        
        <div class="col-md-5 scan-btns id" id="open-exampleModal2">
            <div class="overlay">
                <h1>By Registration ID</h1>
            </div>
        </div>
        <!--<button class="btn btn-primary" data-toggle="modal" data-target="#modal-warning"></button>-->
        
    </div>
    
    

    <div class="modal fade" id="scanQrModel" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0px;">
                    <div class="ocrloader">
                        <em></em>
                        <div id="scanCont">
                            <video id="preview" height="250" style="width: 100%;height: 70%;margin-top: 30px;"></video>
                            <p class="text-center" style="font-size: 25px;">
                                Scanning the QR Code
                            </p>
                        </div>
                    </div>
                    <div class="ocrloader" id="scanProcessCont" style="display:none;">
                         <em></em>
                        <p class="text-center" style="margin-top:40%; font-size: 25px;">
                           Processing the QR Code
                        </p> 
                    </div>
                    <div class="text-center" id="qrUserCont" style="height: 100%;">
                        <input type="hidden" class="mark-usr-by-qr" value="{{route('markQRAttendance')}}">
                        <h1 id="qrUserInfo"></h1>
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
   </div>

    
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header" style="padding-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="">
                    <form action="{{route('searchAttendee')}}">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                                    </div>
                                    <input class="search-visitor form-control" placeholder="Search" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary btn-block btn-id search-visitor-btn">Search</button>
                        </div>
                    </form>
                    
                        <div class="outer-results">
                            <div class="user-found text-center inner-results" style="display: none; height: 100%;">
                                <form class="mark-attandance-form" method="POST" action="{{route('markAttendance')}}">
                                    @csrf
                                    <input type="hidden" name="visitor_id" class="visitor_id" value="">
                                    <img src="{{asset('img/theme/team-1-800x800.jpg')}}"
                                         style="border-radius: 100px; margin: 0 auto; display:block;" height="150" alt="">
                                    <h1></h1>
                                    <button type="button" class="btn btn-primary btn-s mark-attendance" id="mark-attendance">Mark Attendence</button>
                                </form>
                                <h2 class="m-user_name"></h2>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
                <h2 class="text-white mt-2 mb-0 m-user_name"></h2>
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
                    <h2 class="text-white mt-2 mb-0 m-user_name"></h2>
                    <h1 class="text-white">Already CheckedIn</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Mark Another Visitor</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade modal-danger" id="select-modal-danger" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
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
                    <h1 class="text-white mt-2">Select Event</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade modal-danger" id="location-modal-danger" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
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
                    <h1 class="text-white mt-2">Select Location</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade modal-danger" id="no-location-modal-danger" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel"
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
                    <h1 class="text-white mt-2">No Location Found</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body-script')
<!--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
<script src="{{asset('js/instascan.js')}}"></script>
<script>
$( document ).ready( function() {
    $( ".view-page-name" ).html( "Attendance" );
    $( "footer.footer" ).addClass( "container-fluid" );
    $( ".search-qr-visitors-btn" ).on( "click", function(){
        var value = $( ".search-qr-visitor" ).val().toLowerCase();
        $("#inner-qr-results h1").filter(function() {
          $(this).parent().toggle( $(this).text().toLowerCase().indexOf(value) > -1 )
        });
    } );
    var hostname = window.location.origin;
    $( ".search-visitor-btn" ).on( 'click', function(){
        $( ".loader-container" ).show();
        $( ".outer-results" ).find( ".inner-results" ).not( ".inner-results:first" ).remove();
        $.ajax({
        type: "POST",
        url: $( this ).parent().parent().attr( "action" ),
        data: { 
            search: $( ".search-visitor" ).val(),
        },
        cache: false,
        headers: {
            "X-CSRF-TOKEN": $('input[name="_token"]').val()
        },
        success: function(data, status, jqXHR) {
            var visitors = JSON.parse(data);
            if( visitors.success == 1  ){
                var response = visitors.data;
                if( typeof response != "undefined" ){
                  for( var i = 0; i < response.length; i++ ){
                      var visitor = response[i];
                      var clone = $( '.inner-results:first' ).clone();
                      if( typeof response.photo == "undefined" || response.photo == "" )
                            clone.find( 'img' ).attr( "src", hostname + "/img/avatar.png/" );
                        else
                            clone.find( 'img' ).attr( "src", hostname + "/img/userImages/" + visitor.display_name );
                        clone.find( 'h1' ).html( visitor.display_name );
                        clone.find( '.visitor_id' ).val( visitor.id );
                        clone.show().appendTo( ".outer-results" );
                    }
                    $( ".loader-container" ).hide();
                }else{
                    $( ".loader-container" ).hide();
                    popup = $( "#modal-danger" );
                    popup.modal("show");
                }
            }else{
                $( ".loader-container" ).hide();
                popup = $( "#modal-danger" );
                popup.modal("show");
            }
        },
        error: function(error, jqXHR, status) {
            $( ".loader-container" ).hide();
            popup = $( "#modal-danger" );
            popup.modal("show");
        }
      });
    } );
    
    $( document ).delegate( "#mark-attendance",'click', function(){
        $( "#exampleModal2" ).modal( "hide" );
        $( ".loader-container" ).show();
        $.ajax({
        type: "POST",
        url: $( this ).parent().attr( "action" ),
        data: { 
            visitor_id: $(this).parent().find( ".visitor_id" ).val(),
            event_location: $( ".event_location" ).val(),
            event_id: $( ".event_id").val()
        },
        cache: false,
        headers: {
            "X-CSRF-TOKEN": $('input[name="_token"]').val()
        },
        success: function(data, status, jqXHR) {
            var visitors = JSON.parse(data);
            var response = visitors.data;
            var popup;
            $( ".inner-results" ).each( function(){
                if( $( this ).length > 1 )
                    $( this ).remove();
            } );
            if( typeof visitors.success != "undefined" && visitors.success == 1  ){
                $( ".loader-container" ).hide();
                popup = $( "#modal-success" );
                popup.modal("show");
//                popup.find( ".m-user_name" ).text( response.uni_id );
            }else if( typeof visitors.errors != "undefined" && visitors.errors == 1  ){
                $( ".loader-container" ).hide();
                popup = $( "#modal-warning" );
                popup.modal("show");
//                popup.find( ".m-user_name" ).text( response.uni_id );
            }else{
                $( ".loader-container" ).hide();
                popup = $( "#modal-danger" );
                popup.modal("show");
            }
        },
        error: function(error, jqXHR, status) {
            $( ".loader-container" ).hide();
            popup = $( "#modal-danger" );
            popup.modal("show");
        }
      });
    } );
    
	$( '#scanQrBtn' ).click( function() {
            if( $( ".event_id").val() == "Select Event" ){
                $( "#select-modal-danger" ).modal( "show" );
            }
            if( $( ".event_location" ).val() == "Select Location" || $( ".event_location" ).val() == null ){
                $( "#location-modal-danger" ).modal( "show" );
            }
            if( ( $( ".event_location" ).val() != "Select Location") && $( ".event_id").val() != "Select Event" ){
                $( "#scanQrModel" ).modal( "show" );
                $( "#scanCont" ).show();
                $( "#qrUserCont" ).hide();

                scanUser();
            }
	} );

	$( '.ocrloader' ).click( function() {
		$( '.verified' ).fadeIn();
		setTimeout( function() {
			$( '.ocrloader' ).css( 'display', 'none' );
//			$( '#exampleModal .user-found' ).fadeIn();
		}, 2000 );
	} );
	$( '#exampleModal .btn-s' ).click( function() {
		$( '#exampleModal .alert-s' ).fadeIn();
	} );
	$( '#exampleModal2 .btn-s' ).click( function() {
            $( '#exampleModal2 .alert-s' ).fadeIn();
	} );
	$( '#open-exampleModal2' ).click( function() {
            if( $( ".event_id").val() == "Select Event" ){
                $( "#select-modal-danger" ).modal( "show" );
            }
            if( $( ".event_location" ).val() == "Select Location" || $( ".event_location" ).val() == null ){
                $( "#location-modal-danger" ).modal( "show" );
            }
            if( ( $( ".event_location" ).val() != "Select Location") && $( ".event_id").val() != "Select Event" ){
                $( "#exampleModal2" ).modal( "show" );
                $( ".search-visitor" ).val( "" );
                $( ".modal-footer" ).find( "button" ).removeClass( "verify-again" );
                $( ".modal-footer" ).find( "button" ).addClass( "markAttendanceOther" );
                $( ".outer-results" ).find( ".inner-results" ).not( ".inner-results:first" ).remove();
            }
	} );
	$( document ).delegate( '.markAttendanceOther', 'click', function() {
            $( "#modal-warning" ).modal( 'hide' );
            setTimeout( function(){ 
                $( "#exampleModal2" ).modal( "show" );
                $( ".search-visitor" ).val( "" );
                $( ".outer-results" ).find( ".inner-results" ).not( ".inner-results:first" ).remove();
            }, 500);
	} );
	$( document ).delegate( '.verify-again', 'click' ,function() {
		$( "#qrUserCont" ).hide();
		$( "#scanQrModel" ).modal( "show" );
		$( "#scanCont" ).show();
                scanUser();
	} );
        function scanUser(){
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(cameras => {
              scanner.camera = cameras[cameras.length - 1];
              scanner.start();
            }).catch(e => console.error(e));
            if ( !scanner ) {
                scanner = new Instascan.Scanner(
                    {video: document.getElementById( 'preview' )} );
            }
            scanner.addListener( 'scan', function( content ) {
                $( ".modal-footer" ).find( "button" ).removeClass( "markAttendanceOther" );
                $( ".modal-footer" ).find( "button" ).addClass( "verify-again" );
                $( "#scanCont" ).hide();
                $( "#scanProcessCont" ).show();
                setTimeout( function() {
                        $( "#qrUserCont" ).show();
                        $( "#scanProcessCont" ).hide();
                }, 2000 );
//			$( "#qrUserInfo" ).text( content );
                $.ajax({
                    type: "POST",
                    url: $( ".mark-usr-by-qr" ).val(),
                    data: { 
                        visitor_id: content,
                        event_location: $( ".event_location" ).val(),
                        event_id: $( ".event_id").val()
                    },
                    cache: false,
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').val()
                    },
                    success: function(data, status, jqXHR) {
                        var visitors = JSON.parse(data);
                        response = visitors.data;
                        if( typeof visitors.success != "undefined" && visitors.success == 1  ){
                            $( "#scanQrModel" ).modal( "hide" );
                            $( ".loader-container" ).hide();
                            popup = $( "#modal-success" );
                            popup.modal("show");
//                            popup.find( ".m-user_name" ).text( response.uni_id );
                        }else if( typeof visitors.errors != "undefined" && visitors.errors == 1  ){
                            $( "#scanQrModel" ).modal( "hide" );
                            $( ".loader-container" ).hide();
                            popup = $( "#modal-warning" );
                            popup.modal("show");
//                            popup.find( ".m-user_name" ).text( response.uni_id );
                        }else{
                            $( "#scanQrModel" ).modal( "hide" );
                            $( ".loader-container" ).hide();
                            popup = $( "#modal-danger" );
                            popup.modal("show");
                        }
                    },
                    error: function(error, jqXHR, status) {
                        $( "#scanQrModel" ).modal( "hide" );
                        $( ".loader-container" ).hide();
                        popup = $( "#modal-danger" );
                        popup.modal("show");
                    }
                  });
                scanner.stop();
            } );
        }
            $( ".loader-container" ).show();
            $.ajax({
            type: "POST",
                url: $( ".get-location-url" ).val(),
            data: { 
                event_id: $( ".event_id" ).val(),
            },
            cache: false,
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').val()
            },
            success: function(data, status, jqXHR) {
                var visitors = JSON.parse(data);
                if( visitors.success == 1  ){
                    var response = visitors.data;
                    if( typeof response != "undefined" ){
                        console.log( response );
                      for( var i = 0; i < response.length; i++ ){
                          var visitor = response[i];
                          console.log( visitor );
                          var clone = $( '.location-val:first' ).clone();
                            clone.val( visitor.id );
                            clone.html( visitor.name );
//                            clone.find( '.visitor_id' ).val( visitor.uni_id );
                            clone.show().appendTo( $( ".event_location" ) );
                        }
                        $( ".loader-container" ).hide();
                    }else{
                        $( ".loader-container" ).hide();
                        popup = $( "#no-location-modal-danger" );
                        popup.modal("show");
                    }
                }else{
                    $( ".loader-container" ).hide();
                    popup = $( "#no-location-modal-danger" );
                    popup.modal("show");
                }
            },
            error: function(error, jqXHR, status) {
                $( ".loader-container" ).hide();
                popup = $( "#no-location-modal-danger" );
                popup.modal("show");
            }
        } );
        
} );
</script>
@endsection