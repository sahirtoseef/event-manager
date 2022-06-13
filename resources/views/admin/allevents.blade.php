@extends('layout.admin')

@section('head')
<link href="https://cdn.datatables.net/w/dt/dt-1.10.18/datatables.min.css" rel="stylesheet" />
@endsection

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

    <div class="row col-md-12" style="background: white;">
        <div class="table-responsive">
            <div>
                <table id="example" class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">
                                Events
                            </th>
                            <th scope="col">
                                Date
                            </th>
                            <th scope="col">
                                Location
                            </th>
                            <th scope="col">Client</th>
                            <th scope="col">Managers</th>

                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="list">

                        @foreach ($events as $event)
                        <tr>
                            <th scope="row" class="name">
                                <div class="media align-items-center">
                                    <a href="#" class="avatar rounded-circle mr-3">
                                        <img alt="Image placeholder"
                                            src="{{($event->event_avatar)?asset('img/userImages/'.$event->event_avatar):asset('img/avatar.png')}}">
                                    </a>
                                    <div class="media-body">
                                        <span class="mb-0 text-sm">{{$event->venue_name}}</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                {{$event->start_date.' - '.$event->end_date}}
                            </td>
                            <td class="status">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-warning"></i> {{$event->venue_name}}
                                </span>
                            </td>

                            <td>
                                <div class="avatar-group">
                                    <a href="#" class="avatar avatar-sm" data-toggle="tooltip"
                                        data-original-title="{{$event->client->name}}">
                                        <img alt="Image placeholder"
                                            src="{{($event->client->avatar)?asset('img/userImages/'.$event->client->avatar):asset('img/avatar.png')}}"
                                            class="rounded-circle">
                                    </a>
                                    <div class="media-body">
                                        <span class="mb-0 text-sm">{{$event->client->name}}</span>
                                    </div>
                                </div>

                            </td>
                            <td>

                                <div class="avatar-group">
                                    @foreach ($event->managers as $manager)
                                    <a href="#" class="avatar avatar-sm" data-toggle="tooltip"
                                        data-original-title="{{$manager->name}}">
                                        <img alt="Image placeholder"
                                            src="{{($manager->avatar)?asset('img/userImages/'.$manager->avatar):asset('img/avatar.png')}}"
                                            class="rounded-circle">
                                    </a>
                                    @endforeach
                                </div>

                            </td>

                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item"
                                            href="{{route('editevent',['event_id'=>$event->id])}}">Edit</a>
                                        <a class="dropdown-item delete-event" href="javascript:void(0)"
                                            id="{{$event->id}}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
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