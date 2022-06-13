@extends('layout.manager')
@section('content')
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
    style="min-height: 600px; background-image: url({{($user->avatar)?asset('img/userImages/'.$user->avatar):asset('img/theme/team-1-800x800.jpg')}}); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="" style="width: 100%; z-index: 9999">
                <h1 class="display-2 text-white px-3">{{$user->name}}</h1>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">My account</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('managerProfileUpdate',['id'=>$user->id])}}"
                        enctype="multipart/form-data">
                        @csrf
                        @include('includes.validationErrors')
                        @include('includes.actionMessage')
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Name</label>
                                        <input type="text" id="input-username" name="name"
                                            class="form-control form-control-alternative" placeholder="Username"
                                            value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" id="input-email" value="{{$user->email}}" name="email"
                                            class="form-control form-control-alternative"
                                            placeholder="jesse@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Contact information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Address</label>
                                        <input id="input-address" class="form-control form-control-alternative"
                                            placeholder="Home Address" value="{{$user->address}}" type="text"
                                            name="address">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Phone</label>
                                        <input id="input-address" class="form-control form-control-alternative"
                                            placeholder="Phone Number" value="{{$user->phone}}" type="text"
                                            name="phone">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (Auth::user()->id == $user->id )
                        <h6 class="heading-small text-muted mb-4">Password</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Old Password" type="password"
                                                name="old-password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="New Password" type="password"
                                                name="new-password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <h6 class="heading-small text-muted mb-4">Change Profile Image</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Select Image</label>
                                        <input type="file" name="avatar" id="avatar" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-icon btn-3 btn-primary mt-3" type="submit">
                            <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                            <span class="btn-inner--text">Submit</span>
                        </button>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('body-script')
    <script>
        $(document).ready(function() {
            $( ".view-page-name" ).html( "Profile" );
        });
    </script>
    @endsection
    @endsection