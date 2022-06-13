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
                    <th>LOCATION</th>
                    <th>CHECKED IN</th>
                    <th>ATTEMPTED AT</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $visitors as $visitor )
                    <tr>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>{{ $visitor->name ? $visitor->name : "N/A"}}</td>
                        <td>No</td>
                        <td>{{ $visitor->created_at ? $visitor->created_at : "N/A"}}</td>
                        <td>Not Found</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>LOCATION</th>
                    <th>CHECKED IN</th>
                    <th>ATTEMPTED AT</th>
                    <th>STATUS</th>
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

    @endsection


@section('body-script')
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/w/dt/dt-1.10.18/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $( ".view-page-name" ).html( "Visitors History" );
            $( ".delete_visitor" ).on( "click", function(){
                $( ".del_visitor_id" ).val( $( this ).attr( "data-id" ) );
            } );
            
            $('#example').DataTable();
        });
    </script>
@endsection