@extends('layout.admin')
@section('head')
<link href="https://cdn.datatables.net/w/dt/dt-1.10.18/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
    @include('includes.check_in_timings_content')
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