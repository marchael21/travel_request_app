@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">Vehicle<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;List</small></h4>
			<a href="{{ route('admin.vehicle.create') }}" class="btn btn-sm btn-success mb-3 float-right"><i class="fas fa-plus"></i> Add Vehicle</a>
		</div>

		<!-- Page Content -->
        <div class="col-md-12">
        	<form id="search-form" method="GET" action="{{ url('vehicle/list') }}">
        	<div class="float-left mb-3">
        		<select class="form-control form-control-sm rounded-0" id="page-limit" name="page_limit">
					<option value="10" @if('10' == $searchFilter['page_limit'])) selected @endif>10</option>
					<option value="25" @if('25' == $searchFilter['page_limit'])) selected @endif>25</option>
					<option value="50" @if('50' == $searchFilter['page_limit'])) selected @endif>50</option>
					<option value="100" @if('100' == $searchFilter['page_limit'])) selected @endif>100</option>
			    </select>
        	</div>
        	<div class="float-right mb-3">
				<a href="{{ url('vehicle/list') }}" class="btn btn-warning btn-sm" id="clear-search-btn" type="button"><i class="fas fa-sync-alt"></i>&nbsp;Clear Search</a>
        		<button class="btn btn-primary btn-sm" id="search-btn" type="button" onclick="return searchFilter()"><i class="fas fa-search"></i>&nbsp;Search</button>
        	</div>
        	<div class="table-responsive">
	            <table class="table table-striped table-condensed">
	                <thead>
	                    <tr>
	                        <th class="w-10">ID</th>
	                        <th>Plate No.</th>
	                        <th>COR No. (LTO)</th>
	                        <th>Brand</th>
	                        <th>Model</th>
	                        <th class="w-10">Year</th>
	                        <th class="w-10 text-center">Status</th>
	                        <th class="w-10 text-center">Action</th>
	                    </tr>
	                    <tr>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="id" name="id" placeholder="" value="{{ $searchFilter['id'] }}"></th>
	                    	</th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="plate-number" name="plate_number" placeholder="" value="{{ $searchFilter['plate_number'] }}"></th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="cor-number" name="cor_number" placeholder="" value="{{ $searchFilter['cor_number'] }}">
	                    	</th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="brand" name="brand" placeholder="" value="{{ $searchFilter['brand'] }}">
	                    	</th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="model" name="model" placeholder="" value="{{ $searchFilter['model'] }}">
	                    	</th>
	                    	<th>
	                    		<select class="form-control form-control-sm rounded-0" id="year" name="year">
	                    			<option value=""></option>
                            		@foreach($yearOpt as $year)
									<option value="{{ $year }}" @if($year == $searchFilter['year'])) selected @endif>{{ $year }}</option>
									@endforeach
							    </select>
	                    	</th>
	                    	<th>
	                    		<select class="form-control form-control-sm rounded-0" id="status" name="status">
	                    			<option value=""></option>
                            		@foreach($statusOpt as $status)
									<option value="{{ $status->id }}" @if($status->id == $searchFilter['status'])) selected @endif>{{ $status->name }}</option>
									@endforeach
							    </select>
	                    	</th>
	                    	<th></th>
	                    </tr>	                    
	                </thead>
	            	</form>
	                <tbody>
	                	@if(count($vehicles) > 0)
	                    @foreach($vehicles as $i => $vehicle)
	                    <tr>
	                        <td>{{ $vehicle->id }}</td>
	                        <td>{{ $vehicle->plate_number }}</td>
	                        <td>{{ $vehicle->cor_number }}</td>
	                        <td>{{ $vehicle->brand }}</td>
	                        <td>{{ $vehicle->model }}</td>
	                        <td>{{ $vehicle->year }}</td>
	                        <td class="text-center">
	                        	@if($vehicle->status == 1) <span class="badge badge-success p-1 w-100">Available</span> @endif
	                        	@if($vehicle->status == 2) <span class="badge badge-danger p-1 w-100">Not Available</span> @endif
	                        	@if($vehicle->status == 3) <span class="badge badge-primary p-1 w-100">On Trip</span> @endif
	                        	@if($vehicle->status == 4) <span class="badge badge-warning p-1 w-100">Under Maintenance</span> @endif
	                        </td>
	                        <td class="text-center">
	                        	<form id="delete{!! $vehicle->id !!}" action="{{ route('admin.vehicle.delete', $vehicle->id)}}" method="post" type="hidden">
				                  	@csrf
				                  	@method('DELETE')
				                </form>
	                        	<a href="{{ url('/vehicle/edit/' . $vehicle->id) }}" class="text-dark" title="edit vehicle"><i class="fas fa-edit"></i></a>
	                        	<a href="javascript:void(0)" class="text-dark" title="delete vehicle" onclick="return confirmDelete('{{ $vehicle->id }}', 'Plate No.:{{ $vehicle->plate_number }} / Brand: {{ $vehicle->brand}} / Model: {{ $vehicle->model }}')"><i class="fas fa-trash"></i></a>
	                        </td>
	                    </tr>
	                    @endforeach
	                    @else 
	                    <tr>
	                    	<td class="text-center" colspan="8">No record found</td>
	                    </tr>
	                    @endif
	                </tbody>
	            </table>
	        </div>
            {{ $vehicles->links() }}
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
