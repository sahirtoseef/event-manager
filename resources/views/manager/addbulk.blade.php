@extends('layout.manager')
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
        <div id="inputs-component" class="tab-pane tab-example-result fade show active col-md-12" role="tabpanel"
            aria-labelledby="inputs-component-tab">
            <form method="POST" action="{{route('csvStoreVisitor')}}" enctype="multipart/form-data">
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
                <div class="text-center drop-csv">
                    <i class="fas fa-upload"></i>
                    Select CSV file to upload
                     <input type="file" name="csv" id="csv_upload" class="form-control cursor-pointer">
                </div>
                <button class="btn btn-icon btn-3 btn-block btn-primary mt-3" type="submit">
                    <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
                    <span class="btn-inner--text">Upload</span>
                </button>
            </form>
        </div>
    </div>
    @section('body-script')
    <script>
        $(document).ready(function() {
            $( ".view-page-name" ).html( "Add Bulk" );
        });
    </script>
    @endsection
@endsection