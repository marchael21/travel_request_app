@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">My Booking<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;View Information</small></h4>
            <a href="javascript::void(0)" class="btn btn-sm btn-secondary mb-3 float-right" onclick="return window.history.back()"><i class="fas fas fa-arrow-left"></i> Go Back</a>
		</div>

		<!-- Page Content -->
        <div class="col-md-12">
            <div class="card border-primary">

                <h5 class="card-header bg-primary text-white text-center">Booking [{{ $booking->booking_number }}]</h5>
                        
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <h5 class="border-bottom mb-3 mt-3">User/Requestor Information</h5>    
                            <div class="row">
                                <div class="col-md-8 pr-0">
                                    <table class="table table-sm table-borderless table-striped">
                                        <tr>
                                            <td class="w-30 font-weight-bold">Name</td>
                                            <td>{{ $booking->requestor_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-30 font-weight-bold">Position</td>
                                            <td>{{ $booking->requestor_position }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4 pl-0">
                                    <table class="table table-sm table-borderless table-striped">
                                        <tr>
                                            <td class="w-40 font-weight-bold">Monthly Salary</td>
                                            <td>{{ $booking->requestor_monthly_salary }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-40 font-weight-bold">Official Station</td>
                                            <td>{{ $booking->requestor_official_station }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <h5 class="border-bottom mb-3 mt-3">Booking Information</h5>   

                            <div class="row">
                                <div class="col-md-12">
                                    <dl class="row">
                                        <dt class="col-sm-5">Booking Number:</dt>
                                        <dd class="col-sm-7">{{ $booking->booking_number }}</dd>
                                        
                                        <dt class="col-sm-5">Status:</dt>
                                        <dd class="col-sm-7">
                                            @if($booking->status == 1) <h6 class="badge badge-warning p-1">Pending</h6> @endif
                                            @if($booking->status == 2) <h6 class="badge badge-warning p-1">Processed</h6> @endif
                                            @if($booking->status == 3) <h6 class="badge badge-primary p-1">Approved</h6> @endif
                                            @if($booking->status == 4) <h6 class="badge badge-success p-1">Completed</h6> @endif
                                            @if($booking->status == 5) <h6 class="badge badge-danger p-1">Cancelled</h6> @endif
                                        </dd>

                                        <dt class="col-sm-5">Departure Date:</dt>
                                        <dd class="col-sm-7">{{ date('F j, Y', strtotime($booking->departure_date)) }}</dd>

                                        <dt class="col-sm-5">Return Date:</dt>
                                        <dd class="col-sm-7">{{ date('F j, Y', strtotime($booking->return_date)) }}</dd>

                                        <dt class="col-sm-5">Destination:</dt>
                                        <dd class="col-sm-7">{{ $booking->destination }}</dd>

                                        <dt class="col-sm-5">Specific Purpose of Trip:</dt>
                                        <dd class="col-sm-7">{{ $booking->purpose ? $booking->purpose :  'n/a' }}</dd>

                                        <dt class="col-sm-5">Objective/s:</dt>
                                        <dd class="col-sm-7">{{ $booking->objectives ? $booking->objectives : 'n/a' }}</dd>

                                        <dt class="col-sm-5">Per Diems Expenses Allowed:</dt>
                                        <dd class="col-sm-7">{{ $booking->daily_expenses_allowed ? number_format($booking->daily_expenses_allowed, 2) : 'n/a' }}</dd>

                                        <dt class="col-sm-5">Assistant or Laborers Allowed</dt>
                                        <dd class="col-sm-7">{{ $booking->assistant_laborers_allowed ? number_format($booking->assistant_laborers_allowed, 2) : 'n/a' }}</dd>

                                        <dt class="col-sm-5">Appropriation to which travel should be charged</dt>
                                        <dd class="col-sm-7">{{ $booking->appropriation_travel_charged ? number_format($booking->appropriation_travel_charged, 2) : 'n/a' }}</dd>

                                        <dt class="col-sm-5">Remarks or special instructions</dt>
                                        <dd class="col-sm-7">{{ $booking->remarks ? $booking->remarks : 'n/a' }}</dd>
                                    </dl>

                                </div>
                            </div>    

                            <h5 class="border-bottom mb-3 mt-3">Assigned Vehicle & Driver</h5>  

                            <div class="row">
                                <div class="col-md-12">
                                    <dl class="row">
                                        <dd class="col-sm-12 mb-0"><h6 class="">Driver Information</h6></dd>

                                        <dt class="col-sm-5">Driver Name:</dt>
                                        <dd class="col-sm-7">{{ isset($booking->driver) ? $booking->driver->name : 'n/a' }}</dd>

                                        <dd class="col-sm-12 mt-3 mb-0"><h6 class="">Vehicle Information</h6></dd>

                                        <dt class="col-sm-5">Plate No:</dt>
                                        <dd class="col-sm-7">{{ isset($booking->vehicle) && $booking->vehicle->plate_number ? $booking->vehicle->plate_number : 'n/a' }}</dd>

                                        <dt class="col-sm-5">Brand:</dt>
                                        <dd class="col-sm-7">{{ isset($booking->vehicle) && $booking->vehicle->brand ? $booking->vehicle->brand : 'n/a' }}</dd>

                                        <dt class="col-sm-5">Model:</dt>
                                        <dd class="col-sm-7">{{ isset($booking->vehicle) && $booking->vehicle->model ? $booking->vehicle->model : 'n/a' }}</dd>

                                        <dt class="col-sm-5">Year:</dt>
                                        <dd class="col-sm-7">{{ isset($booking->vehicle) && $booking->vehicle->year ? $booking->vehicle->year : 'n/a' }}</dd>
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button id="btn-back" class="btn btn-secondary" type="button" onclick="return window.history.back()"><i class="fas fa-arrow-left"></i>&nbsp;{{ __('Go Back') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')


<script type="text/javascript">
$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
