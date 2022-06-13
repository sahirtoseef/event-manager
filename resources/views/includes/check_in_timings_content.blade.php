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
                    <table id="example" class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Event</th>
                                <th scope="col">Visitor Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone#</th>
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
                                    {{($visitor->email)?$visitor->email:'N/A'}}
                                </td>
                                <td>
                                    {{($visitor->phone)?$visitor->phone:'N/A'}}
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
                        <tfoot>
                            <tr>
                                <th scope="col">Event</th>
                                <th scope="col">Visitor Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone#</th>
                                <th scope="col">Timing</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>