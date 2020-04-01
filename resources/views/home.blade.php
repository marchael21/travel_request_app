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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Welcome {{ Auth::user()->name }}!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div id='calendar'></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('#calendar').fullCalendar({
            themeSystem: 'bootstrap4',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '2014-06-12',
            defaultView: 'month',
            // editable: true,
            events: [
                {
                    title: 'All Day Event',
                    start: '2014-06-01'
                },
                {
                    title: 'Long Event',
                    start: '2014-06-07',
                    end: '2014-06-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2014-06-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2014-06-16T16:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2014-06-12T10:30:00',
                    end: '2014-06-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2014-06-12T12:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2014-06-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2014-06-28'
                }
            ]
        });
        
    });

// $(function() {
//     // toastr.success('message', 'title')
//     // alert( "ready!" );
// });   

</script>
@endpush
