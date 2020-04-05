@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">Process Booking<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;List</small></h4>
		</div>

		<!-- Page Content -->
        <div class="col-md-12">
            <form id="search-form" method="GET" action="{{ url('process-booking') }}">
            <div class="float-left mb-3">
                <select class="form-control form-control-sm rounded-0" id="page-limit" name="page_limit">
                    <option value="10" @if('10' == $searchFilter['page_limit'])) selected @endif>10</option>
                    <option value="25" @if('25' == $searchFilter['page_limit'])) selected @endif>25</option>
                    <option value="50" @if('50' == $searchFilter['page_limit'])) selected @endif>50</option>
                    <option value="100" @if('100' == $searchFilter['page_limit'])) selected @endif>100</option>
                </select>
            </div>
            <div class="float-right mb-3">
                <a href="{{ url('booking/pending') }}" class="btn btn-warning btn-sm" id="clear-search-btn" type="button"><i class="fas fa-sync-alt"></i>&nbsp;Clear Search</a>
                <button class="btn btn-primary btn-sm" id="search-btn" type="button" onclick="return searchFilter()"><i class="fas fa-search"></i>&nbsp;Search</button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th class="w-15">Booking No.</th>
                            <th>Destination</th>
                            <th>Trip Purpose</th>
                            <th class="text-center">Schedule</th>
                            <th class="w-10 text-center">Action</th>
                        </tr>         
                    </thead>
                    </form>
                    <tbody>
                        @if(count($bookings) > 0)
                        @foreach($bookings as $i => $booking)
                        <tr>
                            <td><a href="{{ url('/booking/view/' . $booking->booking_number) }}">{{ $booking->booking_number }}</a></td>
                            <td>{{ $booking->destination }}</td>
                            <td>{{ $booking->purpose }}</td>
                            <th class="text-center font-weight-light">
                                {{ $booking->schedule }}
                            </th>
                            <td class="text-center">
                                <a class="btn btn-success btn-sm" href="{{ url('process-booking/'.$booking->booking_number) }}" title="Process Booking"><i class="fas fa-clipboard-check fa-lg"></i>&nbsp;Process</a>
                            </td>
                        </tr>
                        @endforeach
                        @else 
                        <tr>
                            <td class="text-center" colspan="5">No booking/s yet for processing</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $bookings->links() }}
        </div>
    </div>
</div>

@include('elements.admin.modals.cancel_booking_modal')

@endsection

@push('scripts')

@if(!empty(Session::get('cancelModalData')))
<script>
$(function() {
    // var cancelModalData = ;
    var cancelModalData = '{!! json_encode(Session::get('cancelModalData'), true) !!}';
    showCancelBookingModal(cancelModalData);
});
</script>
@endif


<script type="text/javascript">

function searchFilter() {
	$("#search-form").submit();
	
	// Un-disable form fields when page loads, in case they click back after submission
	$( "#search-form" ).find( ":input" ).prop( "disabled", false );
}


function clearModalData() {
    $('#c-booking-id').val('');
    $('#c-booking-no').empty();
    $('#c-schedule').empty();
    $('#c-destination').empty();
}

function showCancelBookingModal(data) {

    clearModalData();

    cancelBookingData = JSON.parse(data);

    $('#c-booking-id').val(cancelBookingData.id);
    $('#c-booking-no').append(cancelBookingData.booking_number);
    $('#c-schedule').append(cancelBookingData.schedule);
    $('#c-destination').append(cancelBookingData.destination);

    console.log(cancelBookingData);

    $('#cancel-booking-modal').modal('show');
}

function confirmCancelBooking(id, name) {

    swal.fire({
        title: "Cancel Booking?",
        text: "Are you sure you want to proceed? This cannot be undone.",
        icon: "warning",
        customClass: {
            confirmButton: 'btn btn-danger btn-lg ml-1 mr-1',
            cancelButton: 'btn btn-success btn-lg ml-1 mr-1',
        },
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'Don\'t',
        reverseButtons: true,
        dangerMode: true,
    }).then((e) => {
        if (e.value) {
            $("#btn-cancel-booking").attr("disabled", true);
            $("#btn-submit-booking").attr("disabled", true);
            $("#form-cancel-booking").submit();
        }
    })
}

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
