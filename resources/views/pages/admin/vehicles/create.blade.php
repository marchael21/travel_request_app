@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row justify-content-center">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">Vehicle<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Create</small></h4>
		</div>

		<!-- Page Content -->
        <div class="col-md-8">
            <div class="card">
                <form  id="form-vehicle" method="POST" action="{{ route('vehicle.store') }}">
                	@csrf
	                <h5 class="card-header text-center">Fill up vehicle information</h5>
	                        
	                <div class="card-body">

                        <div class="form-group row">
                            <label for="brand" class="col-md-4 col-form-label text-md-right">{{ __('Brand') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="brand" type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ old('brand') }}">
                                @error('brand')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="model" class="col-md-4 col-form-label text-md-right">{{ __('Model') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="model" type="text" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model') }}">
                                @error('model')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="year" class="col-md-4 col-form-label text-md-right">{{ __('Year') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-control form-control-select @error('year') is-invalid @enderror" id="year" name="year" data-placeholder="- Select Year -">
                                    <option value=""></option>
                                    @foreach($yearOpt as $year)
                                    <option value="{{ $year }}" @if($year == old('year')) selected @endif>{{ $year }}</option>
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
                            <label for="plate-number" class="col-md-4 col-form-label text-md-right">{{ __('Plate No.') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="plate-number" type="text" class="form-control uppercase @error('plate_number') is-invalid @enderror" name="plate_number" value="{{ old('plate_number') }}">
                                @error('plate_number')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cor-number" class="col-md-4 col-form-label text-md-right">{{ __('COR No.') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="cor-number" type="text" class="form-control uppercase @error('cor_number') is-invalid @enderror" name="cor_number" value="{{ old('cor_number') }}">

                                @error('cor_number')
                                    <span class="invalid-feedback" year="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-control form-control-select @error('status') is-invalid @enderror" id="status" name="status" data-placeholder="- Select Status -">
                                    <option value=""></option>
                                    @foreach($statusOpt as $status)
                                    <option value="{{ $status->id }}" @if($status->id == old('status')) selected @endif>{{ $status->name }}</option>
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
						    	<button id="btn-submit" class="btn btn-block btn-success" type="submit"><i class="fas fa-save"></i>&nbsp;{{ __('Save') }}</button>
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

$(function() {

    $("#form-vehicle").submit(function (e) {

        //disable buttons upon submit
        $("#btn-submit").attr("disabled", true);
        $("#btn-cancel").attr("disabled", true);

        return true;
    });

    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
