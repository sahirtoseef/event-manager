@extends('layout.admin')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="header-body">
            <!-- Card stats -->

        </div>
    </div>
</div>
<div class="container-fluid mt--7">

    <div class="row">
        @foreach ($managers as $manager)
        <div class="col-xl-6 mt-4">
            <a href="javascript:void()">
                <div class="contact-box shadow py-4" style="background: white; border-radius: 10px;">
                    <div class="" style="width: 25%; float:left;">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive"
                                src="{{($manager->avatar)?asset('img/userImages/'.$manager->avatar):asset('img/avatar.png')}}"
                                height="80" style="border-radius: 100px;">

                        </div>
                    </div>

                    <div style="width:65%; float:left">
                        <h3><strong>{{$manager->name}}</strong></h1>
                            <p><i class="fas fa-envelope"></i></i> {{$manager->email}}</p>
                            <p><i class="fas fa-phone"></i></i> {{$manager->phone}}</p>
                            <p><i class="fa fa-map-marker"></i> {{$manager->address}}</p>
                    </div>
                    <div class="dropdown" style="width:10%; float:right">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item"
                                href="{{route('edit-client-manager',['user_id' => $manager->id])}}">Edit</a>
                            <a class="dropdown-item delete-user" href="javascript:void(0)"
                                id="{{$manager->id}}">Delete</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection