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
        			<a href="{{ url('my-bookings/all') }}" class="nav-item nav-link {{ (request()->is('my-bookings/all*')) ? 'active' : '' }}">All</a>
        			<a href="{{ url('my-bookings/pending') }}" class="nav-item nav-link {{ (request()->is('my-bookings/pending*')) ? 'active' : '' }}">Pending</a>
        			<a href="{{ url('my-bookings/processing') }}" class="nav-item nav-link {{ (request()->is('my-bookings/processing*')) ? 'active' : '' }}">Processing</a>
        			<a href="{{ url('my-bookings/approved') }}" class="nav-item nav-link {{ (request()->is('my-bookings/approved*')) ? 'active' : '' }}">Approved</a>
        			<a href="{{ url('my-bookings/completed') }}" class="nav-item nav-link {{ (request()->is('my-bookings/completed*')) ? 'active' : '' }}">Completed</a>
        			<a href="{{ url('my-bookings/cancelled') }}" class="nav-item nav-link {{ (request()->is('my-bookings/cancelled*')) ? 'active' : '' }}">Cancelled</a>
        		</div>
        	</nav>
        	<div class="tab-content">
        		@yield('tab')
        	</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

function searchFilter() {
	$("#search-form").submit();
	
	// Un-disable form fields when page loads, in case they click back after submission
	$( "#search-form" ).find( ":input" ).prop( "disabled", false );
}

function confirmDelete(id, name) {

    swal.fire({
        title: "Delete Vehicle " + name + "?",
        text: "Are you sure you want to proceed? This cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        dangerMode: true,
    }).then((e) => {
        if (e.value) {
            $("#delete"+id).submit();
        }
    })
}

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
