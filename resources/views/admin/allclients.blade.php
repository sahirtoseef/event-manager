@extends('layout.admin')

@section('head')
<link href="https://cdn.datatables.net/w/dt/dt-1.10.18/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--7">

    <div class="row col-md-12">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client )
                <tr>
                    <td>
                        <div class="avatar-group">
                            <a href="#" class="avatar avatar-sm" data-toggle="tooltip"
                                data-original-title="Ryan Tompson">
                                <img alt="Image placeholder"
                                    src="{{($client->avatar)?asset('img/userImages/'.$client->avatar):asset('img/avatar.png')}}"
                                    class="rounded-circle">
                            </a>
                        </div>
                    </td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->phone}}</td>
                    <td>{{$client->address}}</td>
                    <td class="text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item"
                                    href="{{route('edit-client-manager',['user_id' => $client->id])}}">Edit</a>
                                <a class="dropdown-item delete-user" href="javascript:void(0)" id="{{$client->id}}" >Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>

    </div>
    @endsection

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/w/dt/dt-1.10.18/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    @endsection