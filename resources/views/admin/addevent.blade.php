@extends('layout.admin')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
<link href="{{asset('css/jquery.datetimepicker.css')}}" rel="stylesheet" />
@endsection
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
        <div id="inputs-component" class="tab-pane tab-example-result fade show active col-md-12" role="tabpanel"
            aria-labelledby="inputs-component-tab">
            <form method="POST" action="{{route('storeEvent')}}" class="dropzone" enctype="multipart/form-data">
                @csrf

                @include('includes.actionMessage')

                <div class="text-center event-avatar-click cursor-pointer" >
                    <img src=" {{asset('img/brand/white-2.png')}}" class="cursor-pointer" alt="" width="200px;" height="150px;"
                        id='actual-image-event'>

                    <i class="fas fa-upload"></i> Click here to upload
                </div>
                <input type="file" accept="image/x-png,image/gif,image/jpeg" name="event-avatar" id='event-avatar'
                    style="display:none">


                @include('includes.validationErrors')

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="title"
                                placeholder="Event Title">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input class="form-control" id='event-start-date' name="event-start-date"
                                    placeholder="Select date" type="text" value="2019-06-20 00:00">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input class="form-control" placeholder="Select date" type="text" id='event-end-date'
                                    name="event-end-date" value="2019-06-20 00:00">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="Event Vanue Name" name="venue_name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control" name="client">
                                <option value="-1">Select Event Client</option>
                                @foreach ($clients as $client )
                                <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="select-manager-for-events form-control" multiple="multiple" name="managers[]"
                                id="managers">
                                @foreach ($managers as $manager)
                                <option value="{{$manager->id}}">{{$manager->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="description" class="form-control form-control-alternative" rows="3"
                                placeholder="Enter event description"></textarea>
                        </div>
                    </div>
                </div>


                <button class="btn btn-icon btn-3 btn-primary mt-3" type="submit">
                    <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                    <span class="btn-inner--text">Submit</span>
                </button>
            </form>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/jquery.datetimepicker.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.select-manager-for-events').select2({
                placeholder: "Select managers"
            });
            $.datetimepicker.setDateFormatter({
                parseDate: function (date, format) {
                    var d = moment(date, format);
                    return d.isValid() ? d.toDate() : false;
                },
                formatDate: function (date, format) {
                    return moment(date).format(format);
                },
            });
    
            $('#event-start-date').datetimepicker({format: 'YYYY-MM-DD HH:mm',
                formatTime: 'HH:mm',
                lang: 'en'});
            $('#event-end-date').datetimepicker({format: 'YYYY-MM-DD HH:mm',
                formatTime: 'HH:mm',
                lang: 'en'});
        });

    </script>
    @endsection