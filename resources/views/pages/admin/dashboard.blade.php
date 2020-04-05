@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle fa-lg"></i>&nbsp;Welcome {{ Auth::user()->name }}!</strong> You are logged in.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center">
                <h6 class="card-header">All</h6>
                <div class="card-body">
                    <h4>{{ $bookingCount['all'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center">
                <h6 class="card-header">Pending</h6>
                <div class="card-body">
                    <h4>{{ $bookingCount['pending'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center">
                <h6 class="card-header">Processed</h6>
                <div class="card-body">
                    <h4>{{ $bookingCount['processed'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center">
                <h6 class="card-header">Approved</h6>
                <div class="card-body">
                    <h4>{{ $bookingCount['approved'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center">
                <h6 class="card-header">Completed</h6>
                <div class="card-body">
                    <h4>{{ $bookingCount['completed'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center">
                <h6 class="card-header">Cancelled</h6>
                <div class="card-body">
                    <h4>{{ $bookingCount['cancelled'] }}</h4>
                </div>
            </div>
        </div>

    </div>

    <div class="row justify-content-center">    
        <div class="col-md-10 mt-5">
            <div class="card">
                <h5 class="card-header text-center">Schedule</h5>
                        
                <div class="card-body">
                    <div id='schedule'></div>
                </div>
            </div>
        </div>

        <div class="col-md-2 mt-5">
            <div class="card">
                <h5 class="card-header text-center">Legends</h5>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Pending</td>
                            <td><span class="bg-warning">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td>Processed</td>
                            <td><span class="bg-warning">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td>Approved</td>
                            <td><span class="bg-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td>Completed</td>
                            <td><span class="bg-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td>Cancelled</td>
                            <td><span class="bg-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script type="text/javascript">
    $(function() {

        $('#schedule').fullCalendar({
            themeSystem: 'bootstrap4',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: "{!! url('scheduleList') !!}",
            displayEventTime: true,
            // defaultDate: '2014-06-12',
            defaultView: 'month',
            // editable: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            // eventClick:function(event){

            // }
        });

    });

// $(function() {
//     // toastr.success('message', 'title')
//     // alert( "ready!" );
// });   

</script>
@endpush
