@extends('layout.admin')
@section('content')

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="header-body">
            <!-- Card stats -->

        </div>
    </div>
</div>
<div class="container-fluid mt--7">

    <div class="row col-md-12">
        <div class="col-md-12">
            <img src="{{asset('img/avatar.png')}}" height="150" class="cursor-pointer" id="select-avatar-image"
                style="margin: 20px auto; display: block; border-radius: 100px;" alt="">
        </div>


        <form class="col-md-8" style="margin: 0 auto;" method="POST" action="{{route('storeClient')}}"
            enctype="multipart/form-data">
            @csrf

            @include('includes.actionMessage')
            @include('includes.validationErrors')

            <input type="hidden" name="role_id" value="3">
            <input type="file" accept="image/x-png,image/gif,image/jpeg" name="avatar" id='avatar' style="display:none">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input class="form-control" placeholder="Name" type="text" name="name" id="name">
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input class="form-control" placeholder="Email" type="email" name="email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input class="form-control" placeholder="Phone Number" type="text" name="phone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                            </div>
                            <input class="form-control" placeholder="Address" type="address" name="address">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input class="form-control" placeholder="Password" type="password" name="password"
                                id="password">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input class="form-control" placeholder="Confirm Password" type="password"
                                name="password_confirmation">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="send-email">
                            <label class="custom-control-label" for=" customCheckLogin">
                                <span class="text-muted">Notify User Via Email</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Create Client</button>
        </form>
    </div>
    @endsection