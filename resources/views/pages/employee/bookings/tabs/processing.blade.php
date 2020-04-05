@extends('pages.employee.bookings.list')

@section('tab')
<div class="mt-4">
	<form id="search-form" method="GET" action="{{ url('my-booking/processing') }}">
	<div class="float-left mb-3">
		<select class="form-control form-control-sm rounded-0" id="page-limit" name="page_limit">
			<option value="10" @if('10' == $searchFilter['page_limit'])) selected @endif>10</option>
			<option value="25" @if('25' == $searchFilter['page_limit'])) selected @endif>25</option>
			<option value="50" @if('50' == $searchFilter['page_limit'])) selected @endif>50</option>
			<option value="100" @if('100' == $searchFilter['page_limit'])) selected @endif>100</option>
	    </select>
	</div>
	<div class="float-right mb-3">
		<a href="{{ url('my-booking/processing') }}" class="btn btn-warning btn-sm" id="clear-search-btn" type="button"><i class="fas fa-sync-alt"></i>&nbsp;Clear Search</a>
		<button class="btn btn-primary btn-sm" id="search-btn" type="button" onclick="return searchFilter()"><i class="fas fa-search"></i>&nbsp;Search</button>
	</div>
	<div class="table-responsive">
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th class="w-15">Booking No.</th>
                    <th>Destination</th>
                    <th>Trip Purpose</th>
                    <th class="text-center">Schedule</th>
                    <th class="w-10 text-center">Action</th>
                </tr>         
            </thead>
        	</form>
            <tbody>
            	@if(count($bookings) > 0)
                @foreach($bookings as $i => $booking)
                <tr>
                    <td><a href="{{ url('/my-booking/view/' . $booking->booking_number) }}">{{ $booking->booking_number }}</a></td>
                    <td>{{ $booking->destination }}</td>
                    <td>{{ $booking->purpose }}</td>
                    <th class="text-center font-weight-light">
                    	{{ $booking->schedule }}
                    </th>
                    <td class="text-center">
                    	<a href="{{ url('/my-booking/view/' . $booking->booking_number) }}" class="text-primary" title="view booking-information"><i class="fas fa-search fa-lg"></i></a>
                    	@if($booking->status == 1)
                        <a href="javascript:void(0)" class="text-danger" title="cancel booking" onclick="return showCancelBookingModal('{{ json_encode($booking, true) }}')"><i class="fas fa-times-circle fa-lg"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else 
                <tr>
                	<td class="text-center" colspan="5">No record found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{ $bookings->links() }}
	
</div>
@endsection