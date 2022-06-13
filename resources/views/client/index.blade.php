@extends('layout.client')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')
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
								<span class="admin-event-percentage mr-2"><i class="fas fa-arrow-up"></i> 0%</span>
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
									<h5 class="card-title text-uppercase text-muted mb-0">Registrations</h5>
									<span class="h2 font-weight-bold client-registrations-count mb-0">0</span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
										<i class="fas fa-chart-pie"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-muted text-sm">
								<span class="client-registrations-percentage mr-2"><i class="fas fa-arrow-up"></i>
									0%</span>
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
									<h5 class="card-title text-uppercase text-muted mb-0">Visitors</h5>
									<span class="h2 font-weight-bold mb-0 client-visitors-count"></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
										<i class="fas fa-users"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-muted text-sm">
								<span class="mr-2 client-visitors-percentage"><i class="fas fa-arrow-up"></i>
									0%</span>
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
									<span class="h2 font-weight-bold mb-0 client-peak-hour-time">0</span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-info text-white rounded-circle shadow">
										<i class="fas fa-percent"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-muted text-sm">
								<span class="mr-2 client-peak-hour-percentage">0</span>
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
							<h2 class="text-white mb-0">Registration / Visit Peak Hours</h2>
						</div>
					</div>
				</div>
				<div class="col-xl-12 mb-12 mb-xl-0" id="chart-container">FusionCharts XT will load here!</div>
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
<!--						<div class="col text-right">
							<a href="{{route('peak-hour-report')}}" class="btn btn-sm btn-primary">See all</a>
						</div>-->
					</div>
				</div>
				<div class="table-responsive">
					<!-- Projects table -->
					<table class="table align-items-center table-flush">
						<thead class="thead-light">
							<tr>
								<th scope="col">Event name</th>
								<th scope="col">Total Visitors</th>
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
<!--						<div class="col text-right">
							<a href="{{route('admin-visitor-check-in-timings')}}" class="btn btn-sm btn-primary">See
								all</a>
						</div>-->
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

	@section('body-script')
	<!--   Optional JS   -->
	<script src="{{asset('js/clientAjaxRequests.js')}}"></script>
	<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
	<script type="text/javascript"
        src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
	<script type="text/javascript">
FusionCharts.ready( function() {
	var chartObj = new FusionCharts( {
		type: 'heatmap',
		renderAt: 'chart-container',
		width: '100%',
		height: '500',
		dataFormat: 'json',
		dataSource: {
			"chart": {
				"xAxisName": "Hours",
				"yAxisName": "Type",
				"showplotborder": "1",
				"showValues": "1",
				"xAxisLabelsOnTop": "1",
				"plottooltext": "<div id='nameDiv' style='font-size: 12px; border-bottom: 1px dashed #666666; font-weight:bold; padding-bottom: 3px; margin-bottom: 5px; display: inline-block; color: #888888;' >$rowLabel :</div>{br}Count : <b>$dataValue</b>{br}$columnLabel : <b>$tlLabel</b>{br}<b>$trLabel</b>",
				//Cosmetics
				"baseFontColor": "#333333",
				"baseFont": "Helvetica Neue,Arial",
				"toolTipBorderRadius": "2",
				"toolTipPadding": "5",
				"theme": "fusion"
			},
			"dataset": [{
					"data": [{
							"rowid": "Visit Hours",
							"columnid": "1-2AM",
							"value": "10"
						}, {
							"rowid": "Registration Hours",
							"columnid": "1-2AM",
							"value": "5"
						}, {
							"rowid": "Visit Hours",
							"columnid": "3-4AM",
							"value": "9"
						}, {
							"rowid": "Registration Hours",
							"columnid": "3-4AM",
							"value": "2"
						}, {
							"rowid": "Visit Hours",
							"columnid": "4-6AM",
							"value": "7"
						}, {
							"rowid": "Registration Hours",
							"columnid": "4-6AM",
							"value": "7"
						}, {
							"rowid": "Visit Hours",
							"columnid": "1-2AM",
							"value": "10"
						}, {
							"rowid": "Registration Hours",
							"columnid": "1-2AM",
							"value": "5"
						}, {
							"rowid": "Visit Hours",
							"columnid": "1-2AM",
							"value": "10"
						}, {
							"rowid": "Registration Hours",
							"columnid": "1-2AM",
							"value": "5"
						}]
				}],
			"colorrange": {
				"gradient": "0",
				"minvalue": "0",
				"code": "E24B1A",
				"startlabel": "Poor",
				"endlabel": "Good",
				"color": [{
						"code": "E24B1A",
						"minvalue": "1",
						"maxvalue": "5",
						"label": "Bad"
					}, {
						"code": "F6BC33",
						"minvalue": "5",
						"maxvalue": "8.5",
						"label": "Average"
					}, {
						"code": "6DA81E",
						"minvalue": "8.5",
						"maxvalue": "10",
						"label": "Good"
					}]
			}
		}
	} );
	chartObj.render();
} );
	</script>
	@endsection