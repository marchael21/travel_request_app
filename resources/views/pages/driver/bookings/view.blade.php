@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">Booking<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;View Information</small></h4>
            <a href="javascript::void(0)" class="btn btn-sm btn-secondary mb-3 float-right" onclick="return window.history.back()"><i class="fas fas fa-arrow-left"></i> Go Back</a>
		</div>

		<!-- Page Content -->
        <div class="col-md-12">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="booking-tab" data-toggle="tab" href="#booking" role="tab" aria-controls="booking" aria-selected="true">Booking Information</a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" id="driver-details-tab" data-toggle="tab" href="#driver-details" role="tab" aria-controls="driver-details" aria-selected="false">Booking Driver Details</a>
                </li>
                @if($booking->status == 3)
                <li class="nav-item">
                    <a class="nav-link" id="vehicle-stats-tab" data-toggle="tab" href="#vehicle-stats" role="tab" aria-controls="vehicle-stats" aria-selected="false">Vehicle CheckList/Stats</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="booking-tab-content">
                <div class="tab-pane fade show active" id="booking" role="tabpanel" aria-labelledby="booking-tab">
                    
                    <div class="card border-primary mt-4">

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

                        <div class="card-footer">
                            <button id="btn-back" class="btn btn-secondary" type="button" onclick="return window.history.back()"><i class="fas fa-arrow-left"></i>&nbsp;{{ __('Go Back') }}</button>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="driver-details" role="tabpanel" aria-labelledby="driver-details-tab">
                    <div class="card border-primary mt-4">

                        <h5 class="card-header bg-primary text-white text-center">Booking Other Details (Filled up by driver)</h5>
                                
                        <div class="card-body">
                        </div>

                        <div class="card-footer text-center">

                        </div>
                    </div>
                </div>

                @if($booking->status == 3)
                <div class="tab-pane fade" id="vehicle-stats" role="tabpanel" aria-labelledby="vehicle-stats-tab">
                    <form  id="form-vehicle-stats" method="POST" action="{{ route('driver.updateVehicleStats', $vehicleStat->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="card border-primary mt-4">

                            <h5 class="card-header bg-primary text-white text-center">Vehicle Checklist/Statistic (Filled up by driver)</h5>
                                    
                            <div class="card-body">
                                <h5 class="text-center mb-3">Vehicle Statistics</h5>
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-battery" name="stat_battery" value="1" @if($vehicleStat->battery) checked @endif>
                                                    <label class="custom-control-label" for="stat-battery">Battery</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-lights" name="stat_lights" value="1" @if($vehicleStat->lights) checked @endif>
                                                    <label class="custom-control-label" for="stat-lights">Lights</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-oil" name="stat_oil" value="1" @if($vehicleStat->oil) checked @endif>
                                                    <label class="custom-control-label" for="stat-oil">Oil</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-water" name="stat_water" value="1" @if($vehicleStat->water) checked @endif>
                                                    <label class="custom-control-label" for="stat-water">Water</label>
                                                </div>  
                                            </div>
                                            <div class="col-md-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-brake" name="stat_brake" value="1" @if($vehicleStat->brake) checked @endif>
                                                    <label class="custom-control-label" for="stat-brake">Brake</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-tire" name="stat_tire" value="1" @if($vehicleStat->tire) checked @endif>
                                                    <label class="custom-control-label" for="stat-tire">Tire/Air</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-gas" name="stat_gas" value="1" @if($vehicleStat->gas) checked @endif>
                                                    <label class="custom-control-label" for="stat-gas">Gas/Fuel</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-spare-tire" name="stat_spare_tire" value="1" @if($vehicleStat->spare_tire) checked @endif>
                                                    <label class="custom-control-label" for="stat-spare-tire">Spare Tire</label>
                                                </div>   
                                            </div>
                                            <div class="col-md-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-tool-set" name="stat_tool_set" value="1" @if($vehicleStat->tool_set) checked @endif>
                                                    <label class="custom-control-label" for="stat-tool-set">Tool Set</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-ewd" name="stat_ewd" value="1" @if($vehicleStat->ewd) checked @endif>
                                                    <label class="custom-control-label" for="stat-ewd">EWD</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-easytrip" name="stat_easytrip" value="1" @if($vehicleStat->easytrip) checked @endif>
                                                    <label class="custom-control-label" for="stat-easytrip">Easytrip</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="stat-fleet-card" name="stat_fleet_card" value="1" @if($vehicleStat->fleet_card) checked @endif>
                                                    <label class="custom-control-label" for="stat-fleet-card">Fleet Card</label>
                                                </div>  
                                            </div>

                                            <div class="col-md-12">
                                                <hr> 
                                                <div class="form-group">
                                                    <label for="stat-remarks">Remarks/Notes</label>
                                                    <textarea class="form-control text-left" id="stat-remarks" name="stat_remarks" rows="3">{{ $vehicleStat->remarks }}</textarea>
                                                </div>

                                                <div class="alert alert-info mt-3" role="alert">
                                                    <div class="row">
                                                        <div class="col-1 alert-icon-col">
                                                            <span class="fas fa-info-circle"></span>
                                                        </div>
                                                        <div class="col">
                                                            <strong>Tips!</strong> Check if the stat is ok or uncheck if not
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="card-footer text-center">
                                <button id="btn-submit-stats" type="button" class="btn btn-primary" onclick="return confirmUpdateStats()">Update Vehicle Stats</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>


        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

function confirmUpdateStats(e) {
    swal.fire({
        title: "Update Vehicle Statistics?",
        text: "Are you sure you want to save changes?",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: 'Save Changes',
        cancelButtonText: 'Cancel',
        reverseButtons: true
        // dangerMode: true,
    }).then((e) => {
        if (e.value) {
            //disable buttons upon submit
            $("#btn-submit-stats").attr("disabled", true);
            $("#btn-cancel-stats").attr("disabled", true);
            $("#form-vehicle-stats").submit();
        }
    })
}

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
