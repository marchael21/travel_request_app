@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">Booking<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;List</small></h4>
		</div>

		<!-- Page Content -->
        <div class="col-md-12">
        	<nav>
        		<div class="nav nav-tabs" role="tablist">
        			<a href="{{ url('booking/all') }}" class="nav-item nav-link {{ (request()->is('booking/all*')) ? 'active' : '' }}">All ({{ $bookingCount['all'] }})</a>
        			<a href="{{ url('booking/pending') }}" class="nav-item nav-link {{ (request()->is('booking/pending*')) ? 'active' : '' }}">Pending ({{ $bookingCount['pending'] }})</a>
        			<a href="{{ url('booking/processed') }}" class="nav-item nav-link {{ (request()->is('booking/processed*')) ? 'active' : '' }}">Processed ({{ $bookingCount['processed'] }})</a>
        			<a href="{{ url('booking/approved') }}" class="nav-item nav-link {{ (request()->is('booking/approved*')) ? 'active' : '' }}">Approved ({{ $bookingCount['approved'] }})</a>
        			<a href="{{ url('booking/completed') }}" class="nav-item nav-link {{ (request()->is('booking/completed*')) ? 'active' : '' }}">Completed ({{ $bookingCount['completed'] }})</a>
        			<a href="{{ url('booking/cancelled') }}" class="nav-item nav-link {{ (request()->is('booking/cancelled*')) ? 'active' : '' }}">Cancelled ({{ $bookingCount['cancelled'] }})</a>
        		</div>
        	</nav>
        	<div class="tab-content">
        		@yield('tab')
        	</div>
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

function confirmCancelBooking(id, bookingNumber) {

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

function confirmComplete(id, bookingNumber) {
    swal.fire({
        title: "Mark as complete?",
        text: "Mark as complete this booking [" + bookingNumber + "]? Click \"Yes\" to proceed.",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true,
        dangerMode: true,
    }).then((e) => {
        if (e.value) {
            $("#complete-booking"+id).submit();
        }
    })
}

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
