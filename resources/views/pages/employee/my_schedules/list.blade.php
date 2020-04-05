@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">My Schedule<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;List</small></h4>
		</div>

		<div class="col-md-10 mt-2">
            <div class="card">
                <h5 class="card-header text-center">Schedule</h5>
                        
                <div class="card-body">
                	<div id='my-schedule'></div>
                </div>
            </div>
        </div>

        <div class="col-md-2 mt-2">
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

        $('#my-schedule').fullCalendar({
            themeSystem: 'bootstrap4',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: "{!! url('myScheduleList') !!}",
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

  //       var moment = $('#my-schedule').fullCalendar('getDate');
		// 	alert("The current date of the calendar is " + moment.format());
		// });  
</script>
@endpush