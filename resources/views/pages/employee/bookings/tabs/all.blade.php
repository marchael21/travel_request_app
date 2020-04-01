@extends('pages.employee.bookings.list')

@section('tab')
<div class="mt-4">
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
                    <th>Booking No.</th>
                    <th>Destination</th>
                    <th>Trip Purpose</th>
                    <th class="text-center">Schedule</th>
                    <th class="w-10 text-center">Status</th>
                    <th class="w-10 text-center">Action</th>
                </tr>                    
            </thead>
        	</form>
            <tbody>
            	@if(count($bookings) > 0)
                @foreach($bookings as $i => $booking)
                <tr>
                    <td>{{ $booking->booking_number }}</td>
                    <td>{{ $booking->destination }}</td>
                    <td>{{ $booking->purpose }}</td>
                    <th class="text-center font-weight-light">
                    	@if($booking->departure_date === $booking->return_date) 
                    	{{ date('m-d-Y',strtotime($booking->departure_date)) }}
                    	@else
                    	{{ date('m-d-Y',strtotime($booking->departure_date)) . ' - ' . date('m-d-Y',strtotime($booking->return_date))}}
                    	@endif
                    	
                    </th>
                    <td class="text-center">
                    	@if($booking->status == 1) <span class="badge badge-warning p-1 w-100">Pending</span> @endif
                    	@if($booking->status == 2) <span class="badge badge-warning p-1 w-100">Processing</span> @endif
                    	@if($booking->status == 3) <span class="badge badge-primary p-1 w-100">Approved</span> @endif
                    	@if($booking->status == 4) <span class="badge badge-success p-1 w-100">Completed</span> @endif
                    	@if($booking->status == 5) <span class="badge badge-danger p-1 w-100">Cancelled</span> @endif
                    </td>
                    <td class="text-center">
                    	<form id="delete{!! $booking->id !!}" action="{{ route('vehicle.delete', $booking->id)}}" method="post" type="hidden">
		                  	@csrf
		                  	@method('DELETE')
		                </form>
                    	<a href="{{ url('/vehicle/edit/' . $booking->id) }}" class="text-dark" title="edit vehicle"><i class="fas fa-edit"></i></a>
                    	<a href="javascript:void(0)" class="text-dark" title="delete vehicle" onclick="return confirmDelete('{{ $booking->id }}', 'test')"><i class="fas fa-trash"></i></a>
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
    {{ $bookings->links() }}
	
</div>
@endsection