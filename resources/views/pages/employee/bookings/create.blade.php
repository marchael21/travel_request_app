@extends('layouts.app')

@push('styles')

@endpush

@section('content')
<div class="container">
    
    <div class="row justify-content-center">

        <!-- Page Title -->
        <div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
            <h4 class="pt-2">My Bookings<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Request</small></h4>
        </div>

        <!-- Page Content -->
        <div class="col-md-10">
            <div class="card border-primary">
                <form id="form-booking" method="POST" action="{{ route('submitBooking') }}">
                    @csrf
                    <h5 class="card-header bg-primary text-white text-center">Booking Request</h5>
                            
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h5 class="border-bottom mb-3 mt-3">User/Requestor Information</h5>    
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="requestor-name">Name</label>
                                            <input type="text" class="form-control @error('requestor_name') is-invalid @enderror" id="requestor-name" name="requestor_name" value="{{ Auth::user()->name }}" placeholder="">
                                            @error('requestor_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="requestor-monthly-salary">Monthly Salary</label>
                                            <input type="text" class="form-control amount @error('requestor_monthly-salary') is-invalid @enderror" id="requestor-monthly-salary" name="requestor_monthly_salary" value="{{ isset(Auth::user()->monthly_salary) ? number_format(Auth::user()->monthly_salary, 2) : '' }}" placeholder="">
                                            @error('requestor_monthly_salary')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="requestor-position">Position</label>
                                            <input type="text" class="form-control @error('requestor_position') is-invalid @enderror" id="requestor-position" name="requestor_position" value="{{ Auth::user()->position }}" placeholder="">
                                            @error('requestor_position')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="requestor-official-station">Official Station</label>
                                            <input type="text" class="form-control @error('requestor_official_station') is-invalid @enderror" id="requestor-official-station" name="requestor_official_station" value="{{ Auth::user()->official_station }}" placeholder="">
                                            @error('requestor_official_station')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <h5 class="border-bottom mb-3 mt-3">Booking Information</h5>   

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="requestor-name">Departure Date</label>
                                            <div class="input-group date" id="departure-date" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input @error('departure_date') is-invalid @enderror" data-target="#departure-date" name="departure_date" value="{{ old('departure_date') }}"/>
                                                <div class="input-group-append" data-target="#departure-date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @error('departure_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            @error('departure_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="requestor-name">Return Date</label>
                                            <div class="input-group date" id="return-date" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input @error('return_date') is-invalid @enderror" data-target="#return-date" name="return_date" value="{{ old('return_date') }}"/>
                                                <div class="input-group-append" data-target="#return-date" data-toggle="datetimepicker" name="return_date">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @error('return_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="destination">Destination</label>
                                            <input type="text" class="form-control @error('destination') is-invalid @enderror" id="destination" name="destination" value="{{ old('destination') }}" placeholder="" maxlength="300">
                                            @error('destination')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="purpose">Specific Purpose Of Trip</label>
                                            <textarea id class="form-control resize-none  @error('purpose') is-invalid @enderror" id="purpose" name="purpose" rows="2" maxlength="300">{{ old('purpose') }}</textarea>
                                            @error('purpose')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="objectives">Objectives</label>
                                            <textarea id class="form-control resize-none  @error('objectives') is-invalid @enderror" id="objectives" name="objectives" rows="2" maxlength="300">{{ old('objectives') }}</textarea>
                                            @error('objectives')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> -->
                                    </div>
                                   <!--  <div class="col-md-3">        
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
 -->                                </div>    
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 pl-1">
                                <button id="btn-submit" class="btn btn-block btn-success" type="button" onclick="return confirmSubmit()"><i class="fas fa-save"></i>&nbsp;{{ __('Submit Request') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

    function confirmSubmit(e) {
        swal.fire({
            title: "Submit Booking Request?",
            text: "Are you sure you want to proceed?",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            reverseButtons: true
            // dangerMode: true,
        }).then((e) => {
            if (e.value) {
                //disable buttons upon submit
                $("#btn-submit").attr("disabled", true);
                $("#form-booking").submit();
            }
        })
    }

    $(function() {

        $('#departure-date, #return-date').datetimepicker({
            useCurrent: false,
            allowInputToggle: true,
            format: 'L'
        });

        $("#departure-date").on("change.datetimepicker",function(e){
            var incrementDay = moment(new Date(e.date));
            //incrementDay.add(1, 'days');
            $('#return-date').data('datetimepicker').minDate(incrementDay);
            //$(this).data("DateTimePicker").hide();
        });

        $("#return-date").on("change.datetimepicker",function(e){
            var decrementDay = moment(new Date(e.date));
            //decrementDay.subtract(1, 'days');
            $('#departure-date').data('datetimepicker').maxDate(decrementDay);
            //$(this).data("DateTimePicker").hide();
        });

        // toastr.success('message', 'title')
        // alert( "ready!" );
    });   

</script>

<script type="text/javascript">
  
  var placeSearch, autocomplete;

  var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
  };

  function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('destination')),
        {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    // autocomplete.addListener('place_changed', fillInAddress);
  }

  // function fillInAddress() {
  //   // Get the place details from the autocomplete object.
  //   var place = autocomplete.getPlace();

  //   for (var component in componentForm) {
  //     document.getElementById(component).value = '';
  //     document.getElementById(component).disabled = false;
  //   }

  //   // Get each component of the address from the place details
  //   // and fill the corresponding field on the form.
  //   for (var i = 0; i < place.address_components.length; i++) {
  //     var addressType = place.address_components[i].types[0];
  //     if (componentForm[addressType]) {
  //       var val = place.address_components[i][componentForm[addressType]];
  //       document.getElementById(addressType).value = val;
  //     }
  //   }
  // }

  // Bias the autocomplete object to the user's geographical location,
  // as supplied by the browser's 'navigator.geolocation' object.
  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var circle = new google.maps.Circle({
          center: geolocation,
          radius: position.coords.accuracy
        });
        autocomplete.setBounds(circle.getBounds());
      });
    }
  }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfakMEOqQEENEaFwR7wETttH9vq15pVTo&libraries=places&callback=initAutocomplete" async defer></script>
@endpush
