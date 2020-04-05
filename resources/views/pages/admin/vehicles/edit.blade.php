@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
    
    <div class="row">

        <!-- Page Title -->
        <div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
            <h4 class="pt-2">Vehicle<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Edit</small></h4>
        </div>

        <!-- Page Content -->
        <div class="col-md-7">
            <div class="card">
                <form  id="form-vehicle" method="POST" action="{{ route('admin.vehicle.update', $vehicle->id) }}">
                    @method('PATCH')
                    @csrf
                    <h5 class="card-header text-center">Vehicle Information</h5>
                            
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="brand" class="col-md-3 col-form-label text-md-right">{{ __('Brand') }}<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="brand" type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ $vehicle->brand }}">
                                @error('brand')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="model" class="col-md-3 col-form-label text-md-right">{{ __('Model') }}<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="model" type="text" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ $vehicle->model }}">
                                @error('model')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="year" class="col-md-3 col-form-label text-md-right">{{ __('Year') }}<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="form-control form-control-select @error('year') is-invalid @enderror" id="year" name="year" data-placeholder="- Select Year -">
                                    <option value=""></option>
                                    @foreach($yearOpt as $year)
                                    <option value="{{ $year }}" @if($year == $vehicle->year)) selected @endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                                @error('year')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="plate-number" class="col-md-3 col-form-label text-md-right">{{ __('Plate No.') }}<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="plate-number" type="text" class="form-control uppercase @error('plate_number') is-invalid @enderror" name="plate_number" value="{{ $vehicle->plate_number }}">
                                @error('plate_number')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cor-number" class="col-md-3 col-form-label text-md-right">{{ __('COR No.') }}<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="cor-number" type="text" class="form-control uppercase @error('cor_number') is-invalid @enderror" name="cor_number" value="{{ $vehicle->cor_number }}">

                                @error('cor_number')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="form-control form-control-select @error('status') is-invalid @enderror" id="status" name="status" data-placeholder="- Select Status -">
                                    <option value=""></option>
                                    @foreach($statusOpt as $status)
                                    <option value="{{ $status->id }}" @if($status->id == $vehicle->status) selected @endif>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" status="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="offset-3 col-md-3 pr-1">
                                <button id="btn-cancel" class="btn btn-block btn-danger" type="button" onclick="return window.history.back()"><i class="fas fa-window-close"></i>&nbsp;{{ __('Cancel') }}</button>
                            </div>
                            <div class="col-md-3 pl-1">
                                <button id="btn-submit" class="btn btn-success btn-block" type="button" onclick="return confirmUpdate()"><i class="fas fa-save"></i>&nbsp;{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

       <div class="col-md-5">
            <div class="card">
                <h5 class="card-header text-center">Vehicle Statistics</h5>
                        
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td>Battery</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->battery)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->battery)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lights</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->lights)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->lights)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Oil</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->oil)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->oil)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Water</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->water)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->water)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Brake</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->brake)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->brake)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tire/Air</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->tire)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->tire)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 border-left">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td>Gas/Fuel</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->gas)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->gas)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Spare Tire</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->spare_tire)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->spare_tire)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tool Set</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->tool_set)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->tool_set)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>EWD</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->ewd)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->ewd)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Easytrip</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->easytrip)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->easytrip)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fleet Card</td>
                                    <td>
                                        @if($vehicle->vehicleStatistic->fleet_card)<i class="fas fa-check text-success"></i>@endif
                                        @if(!$vehicle->vehicleStatistic->fleet_card)<i class="fas fa-times text-danger"></i>@endif
                                    </td>
                                </tr> 
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 border-top">
                        <h5 class="pt-3">Remarks/Note:</h5>
                        <p>@if($vehicle->vehicleStatistic->remarks) {{ $vehicle->vehicleStatistic->remarks }} @else n/a @endif</p>
                        <hr>
                        <h6>Last Updated By: {{ $vehicle->vehicleStatistic->updatedBy->name }}</h6>
                        <h6>Date Updated: {{ date('F j, Y h:i:s A', strtotime($vehicle->vehicleStatistic->updated_at)) }}</h6>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#vehicle-stat-modal"><i class="fas fa-edit"></i>&nbsp;{{ __('Update Statistics') }}</button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="vehicle-stat-modal" tabindex="-1" role="dialog" aria-labelledby="vehicle-stat-modal-label" aria-hidden="true">
    <form  id="form-vehicle-stats" method="POST" action="{{ route('admin.vehicle.updateStats', $vehicleStat->id) }}">
        @method('PATCH')
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicle-stat-modal-label">Vehicle Statistics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <h5 class="text-center mb-3">Vehicle Statistics</h5>
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
                <div class="modal-footer d-block">
                    <div class="row">
                        <div class="col-md-4 offset-md-2">
                            <button btn="btn-cancel-stats" type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                        </div>
                        <div class="col-md-4">
                            <button id="btn-submit-stats" type="button" class="btn btn-primary btn-block" onclick="return confirmUpdateStats()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

function confirmUpdate(e) {
    swal.fire({
        title: "Update Vehicle Information?",
        text: "Are you sure you want to save changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Save Changes',
        cancelButtonText: 'Cancel',
        reverseButtons: true
        // dangerMode: true,
    }).then((e) => {
        if (e.value) {
            //disable buttons upon submit
            $("#btn-submit").attr("disabled", true);
            $("#btn-cancel").attr("disabled", true);
            $("#form-vehicle").submit();
        }
    })
}

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
