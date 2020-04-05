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
        			<a href="{{ url('assigned-booking/all') }}" class="nav-item nav-link {{ (request()->is('assigned-booking/all*')) ? 'active' : '' }}">All ({{ $bookingCount['all'] }})</a>
        			<a href="{{ url('assigned-booking/approved') }}" class="nav-item nav-link {{ (request()->is('assigned-booking/approved*')) ? 'active' : '' }}">Approved ({{ $bookingCount['approved'] }})</a>
        			<a href="{{ url('assigned-booking/completed') }}" class="nav-item nav-link {{ (request()->is('assigned-booking/completed*')) ? 'active' : '' }}">Completed ({{ $bookingCount['completed'] }})</a>
        			<a href="{{ url('assigned-booking/cancelled') }}" class="nav-item nav-link {{ (request()->is('assigned-booking/cancelled*')) ? 'active' : '' }}">Cancelled ({{ $bookingCount['cancelled'] }})</a>
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

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
