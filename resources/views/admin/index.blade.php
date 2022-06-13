@extends('layout.admin')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Events</h5>
                                    <span class="h2 admin-event-count font-weight-bold mb-0">0</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="admin-event-percentage mr-2"><i class="fas fa-arrow-up"></i> 1.10%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Clients</h5>
                                    <span class="h2 font-weight-bold admin-client-count mb-0">0</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-danger admin-client-percentage mr-2"><i class="fas fa-arrow-up"></i>
                                    1.10%</span>
                                <span class="text-nowrap">Since last week</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Visitors</h5>
                                    <span class="h2 font-weight-bold mb-0 admin-visitor-count"></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 admin-visitor-percentage"><i class="fas fa-arrow-up"></i>
                                    1.10%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Peak Timings</h5>
                                    <span class="h2 font-weight-bold mb-0 admin-peak-hour-count">5-8 PM</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2  admin-peak-hour-percentage">12%</span>
                                <span class="text-nowrap">Total Check In</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                            <h2 class="text-white mb-0">System Statistics</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="visitors-graph" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-5">
        <div class="col-xl-6 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Peak Hours Report</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('peak-hour-report')}}" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Event name</th>
                                <th scope="col">Total Visitors</th>
                                <th scope="col">Event Start Date</th>
                                <th scope="col">Timings</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                            <tr>
                                <th scope="row">
                                    {{$event->title}}
                                </th>
                                <td>
                                    {{$event->checkin_count}}
                                </td>
                                <td>
                                    {{$event->start_date}}
                                </td>
                                <td>
                                    @if ($event->checkin_count)
                                    <i class="fas fa-clock text-success mr-3"></i> {{$event->peakHourTime}}
                                    @else
                                    <i class="fas fa-clock text-warning mr-3"></i> {{$event->peakHourTime}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Check-in Timings</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('admin-visitor-check-in-timings')}}" class="btn btn-sm btn-primary">See
                                all</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Event</th>
                                <th scope="col">Visitor Name</th>
                                <th scope="col">Timing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $visitor)
                            <tr>
                                <th scope="row">
                                    {{$visitor->event->title}}
                                </th>
                                <td>
                                    {{$visitor->display_name}}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span
                                            class="mr-2">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $visitor->checkin_time)->format('F j, Y')}}</span>
                                        <div>
                                            <i class="fas fa-clock"></i>
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
    </div>
    @endsection


    @section('scripts')
    <script src="{{asset('js/ajaxRequests.js')}}"></script>
    @endsection