@extends('layout.manager')

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">

        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">My Total Events</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$events_count}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{$events_average}}%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">My Total Visitors</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$user_count}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> {{$user_average}}%</span>
                                <span class="text-nowrap">Since last week</span>
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
        <div class="col-xl-12">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Statistics</h6>
                            <h2 class="mb-0">Visitors</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        @csrf
                        <input type="hidden" class="url-dash-barchart" value="{{route('getChartData')}}">
                        <canvas id="chart-orders" class="chart-canvas chartjs-render-monitor" width="374" height="454"
                            style="display: block; height: 350px; width: 288px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-12 mt-3" style="background: white;">
        <h2 class="col-md-12 py-3">My Events</h2>
        <div class="table-responsive">
            <div>
                <table class="table align-items-center">
                    <thead class="">
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
                            <th scope="col">Visitors</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach( $events as $k => $event )
                        <tr>
                            <th scope="row" class="name">
                                <div class="media align-items-center">
                                    <a href="javascript:void(0);" class="avatar rounded-circle mr-3">
                                        @if( $event['avatar'] )
                                            <img src="{{ asset( 'img/userImages/' . $event['avatar'] )}}">
                                        @else
                                            <img src="{{ asset('img/avatar.png')}}">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <span class="mb-0 text-sm">{{$event['title']}}</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                {{$event['start_date']}} - {{$event['end_date']}}
                            </td>
                            <td class="status">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-warning"></i> {{$event['venue_name']}}
                                </span>
                            </td>
                            <td>
                                <div class="avatar-group">
                                    @if( isset($event['user']) )
                                        @foreach( $event['user'] as $user )
                                            <a href="javascript:void(0);" class="avatar avatar-sm" data-toggle="tooltip"
                                                data-original-title="{{$user['name']}}">
                                                @if( $user['avatar'] )
                                                <img src="{{asset('img/userImages/'. $user['avatar'] )}}"
                                                    class="rounded-circle">
                                                @else
                                                    <img src="{{ asset('img/avatar.png')}}">
                                                @endif
                                            </a>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @section('body-script-optionals')
        <!--   Optional JS   -->
        <script src="{{asset('js/plugins/chart.js/dist/Chart.min.js')}}"></script>
        <script src="{{asset('js/plugins/chart.js/dist/Chart.extension.js')}}"></script>
        <script>
            $( ".view-page-name" ).html( "Dashboard" );
//        var $chart = document.getElementById('myChar1t').getContext('2d');
        var $chart = $('#chart-orders1');
        var ordersChart = new Chart($chart, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            lineWidth: 1,
                            color: '#dfe2e6',
                            zeroLineColor: '#dfe2e6'
                        },
                        ticks: {
                            callback: function(value) {
                                if (!(value % 10)) {
                                    return '' + value + ''
                                        // return value
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data) {
                            var label = data.datasets[item.datasetIndex].label || '';
                            var yLabel = item.yLabel;
                            var content = '';

                            if (data.datasets.length > 1) {
                                content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                            }

                            content += '<span class="popover-body-value">' + yLabel + '</span>';

                            return content;
                        }
                    }
                }
            },
            data: {
                labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales',
                    data: [25, 20, 30, 22, 17, 29]
                }]
            }
        });

        // Save to jQuery object
        $chart.data('chart', ordersChart);
        </script>
    @endsection
    @endsection

    