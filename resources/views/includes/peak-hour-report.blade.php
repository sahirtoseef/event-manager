<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">

    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row mt-5">
        <div class="col-xl-12 mb-10 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Check In Timings</h3>
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
                                <th scope="col">Event Location</th>
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
                                    {{$event->venue_name}}
                                </td>
                                <td>
                                    {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $event->start_date)->format('F j, Y')}}
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

                        <tfoot class="thead-light">
                            <tr>
                                <th scope="col">Event name</th>
                                <th scope="col">Total Visitors</th>
                                <th scope="col">Event Location</th>
                                <th scope="col">Event Start Date</th>
                                <th scope="col">Timings</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>