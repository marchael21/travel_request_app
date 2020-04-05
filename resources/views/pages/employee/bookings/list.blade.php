@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">My Booking<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;List</small></h4>
			<a href="{{ route('requestBooking') }}" class="btn btn-sm btn-success mb-3 float-right"><i class="fas fas fa-hand-point-up"></i> Request Booking</a>
		</div>

		<!-- Page Content -->
        <div class="col-md-12">
        	<nav>
        		<div class="nav nav-tabs" role="tablist">
                    <a href="{{ url('my-booking/all') }}" class="nav-item nav-link {{ (request()->is('my-booking/all*')) ? 'active' : '' }}">All ({{ $bookingCount['all'] }})</a>
                    <a href="{{ url('my-booking/pending') }}" class="nav-item nav-link {{ (request()->is('my-booking/pending*')) ? 'active' : '' }}">Pending ({{ $bookingCount['pending'] }})</a>
                    <a href="{{ url('my-booking/processed') }}" class="nav-item nav-link {{ (request()->is('my-booking/processed*')) ? 'active' : '' }}">Processed ({{ $bookingCount['processed'] }})</a>
                    <a href="{{ url('my-booking/approved') }}" class="nav-item nav-link {{ (request()->is('my-booking/approved*')) ? 'active' : '' }}">Approved ({{ $bookingCount['approved'] }})</a>
                    <a href="{{ url('my-booking/completed') }}" class="nav-item nav-link {{ (request()->is('my-booking/completed*')) ? 'active' : '' }}">Completed ({{ $bookingCount['completed'] }})</a>
                    <a href="{{ url('my-booking/cancelled') }}" class="nav-item nav-link {{ (request()->is('my-booking/cancelled*')) ? 'active' : '' }}">Cancelled ({{ $bookingCount['cancelled'] }})</a>
                </div>
        	</nav>
        	<div class="tab-content">
        		@yield('tab')
        	</div>
        </div>
    </div>
</div>

@include('elements.employee.modals.cancel_booking_modal')

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
