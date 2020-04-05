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
            <div class="card border-primary">
                <form id="form-process-booking" method="POST" action="{{ route('admin.processBooking', $booking->id) }}">
                    @method('PATCH')
                    @csrf
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

                                        </dl>

                                    </div>

                                    <div class="col-md-3">        
                                        <div class="form-group">
                                            <label for="daily-expenses-allowed">Per Diem Expenses Allowed</label>
                                            <input type="text" class="form-control amount @error('daily_expenses_allowed') is-invalid @enderror" id="daily-expenses-allowed" name="daily_expenses_allowed" value="{{ old('daily_expenses_allowed') }}" placeholder="" maxlength="12">
                                            @error('daily_expenses_allowed')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="assistant-laborers-allowed">Assitant or Laborers Allowed</label>
                                            <input type="text" class="form-control amount @error('assistant_laborers_allowed') is-invalid @enderror" id="assistant-laborers-allowed" name="assistant_laborers_allowed" value="{{ old('assistant_laborers_allowed') }}" placeholder="" maxlength="12">
                                            @error('assistant_laborers_allowed')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appropriation-travel-charged">Appropriation to which travel should be charged</label>
                                            <input type="text" class="form-control amount @error('appropriation_travel_charged') is-invalid @enderror" id="appropriation-travel-charged" name="appropriation_travel_charged" value="{{ old('appropriation_travel_charged') }}" placeholder="" maxlength="12">
                                            @error('appropriation_travel_charged')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">    
                                        <div class="form-group">
                                            <label for="remarks">Remarks/Special Instruction</label>
                                            <textarea id class="form-control resize-none @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="2" maxlength="300">{{ old('remarks') }}</textarea>
                                            @error('remarks')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> 

                                <h5 class="border-bottom mb-3 mt-3">Assigned Vehicle & Driver</h5>     

                                <div class="row">
                                    <div class="col-md-12">        
                                        <div class="form-group">
                                            <label for="daily-expenses-allowed">Vehicle</label>
                                            <select class="form-control form-control-select @error('vehicle') is-invalid @enderror" id="vehicle" name="vehicle">
                                                <option value=""></option>
                                                @foreach($vehicleOpt as $vehicle)
                                                <option value="{{ $vehicle->id }}" @if($vehicle->id == old('vehicle')) selected @endif>{{ 'Plate No.: ' . $vehicle->plate_number . ' /Brand: ' . $vehicle->brand . ' /Model: ' . $vehicle->model . '/Year: ' . $vehicle->year  }}</option>
                                                @endforeach
                                            </select>
                                            @error('vehicle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">        
                                        <div class="form-group">
                                            <label for="daily-expenses-allowed">Driver</label>
                                            <select class="form-control form-control-select @error('driver') is-invalid @enderror" id="driver" name="driver">
                                                <option value=""></option>
                                                @foreach($driverOpt as $driver)
                                                <option value="{{ $driver->id }}" @if($driver->id == old('driver')) selected @endif>{{ $driver->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('driver')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-md-2 pr-1">  
                                <a href="javascript::void(0)" class="float-left text-dark mt-2" onclick="return window.history.back()" title="Go Back"><i class="fas fas fa-arrow-left fa-lg"></i></a>
                            </div>  
                            <div class="col-md-4 pr-1">
                                <button id="btn-submit" class="btn btn-block btn-success" type="button" onclick="return confirmProcessBooking()"><i class="fas fa-check"></i>&nbsp;{{ __('Process Booking') }}</button>
                            </div>
                            <div class="col-md-4 pl-1">
                                <button id="btn-cancel" class="btn btn-block btn-danger" type="button"  onclick="return showCancelBookingModal('{{ json_encode($booking, true) }}')"><i class="fas fa-window-close"></i>&nbsp;{{ __('Cancel Booking') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
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

function confirmCancelBooking() {

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

function confirmProcessBooking() {

    swal.fire({
        title: "Process Booking?",
        text: "Are you sure you want to proceed?",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        dangerMode: true,
    }).then((e) => {
        if (e.value) {
            $("#btn-cancel").attr("disabled", true);
            $("#btn-submit").attr("disabled", true);
            $("#form-process-booking").submit();
        }
    })
}

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
