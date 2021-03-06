@extends('pages.admin.bookings.list')

@section('tab')
<div class="mt-4">
	<form id="search-form" method="GET" action="{{ url('booking/all') }}">
	<div class="float-left mb-3">
		<select class="form-control form-control-sm rounded-0" id="page-limit" name="page_limit">
			<option value="10" @if('10' == $searchFilter['page_limit'])) selected @endif>10</option>
			<option value="25" @if('25' == $searchFilter['page_limit'])) selected @endif>25</option>
			<option value="50" @if('50' == $searchFilter['page_limit'])) selected @endif>50</option>
			<option value="100" @if('100' == $searchFilter['page_limit'])) selected @endif>100</option>
	    </select>
	</div>
	<div class="float-right mb-3">
		<a href="{{ url('booking/all') }}" class="btn btn-warning btn-sm" id="clear-search-btn" type="button"><i class="fas fa-sync-alt"></i>&nbsp;Clear Search</a>
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
                    <th class="w-10 text-center">Status</th>
                    <th class="w-10 text-center">Action</th>
                </tr>         
            </thead>
        	</form>
            <tbody>
            	@if(count($bookings) > 0)
                @foreach($bookings as $i => $booking)
                <tr>
                    <td><a href="{{ url('/booking/view/' . $booking->booking_number) }}">{{ $booking->booking_number }}</a></td>
                    <td>{{ $booking->destination }}</td>
                    <td>{{ $booking->purpose }}</td>
                    <th class="text-center font-weight-light">
                    	{{ $booking->schedule }}
                    </th>
                    <td class="text-center">
                    	@if($booking->status == 1) <span class="badge badge-warning p-1 w-100">Pending</span> @endif
                    	@if($booking->status == 2) <span class="badge badge-warning p-1 w-100">Processed</span> @endif
                    	@if($booking->status == 3) <span class="badge badge-primary p-1 w-100">Approved</span> @endif
                    	@if($booking->status == 4) <span class="badge badge-success p-1 w-100">Completed</span> @endif
                    	@if($booking->status == 5) <span class="badge badge-danger p-1 w-100">Cancelled</span> @endif
                    </td>
                    <td class="text-center">
                        <form id="complete-booking{!! $booking->id !!}" action="{{ route('admin.completeBooking', $booking->id)}}" method="post" type="hidden">
                            @csrf
                            @method('PATCH')
                        </form>   
                    	<a href="{{ url('/booking/view/' . $booking->booking_number) }}" class="text-primary" title="view booking-information"><i class="fas fa-search fa-lg"></i></a>

                        @if($booking->status == 1 && Auth::user()->role_id == 1)
                        <a href="{{ url('process-booking/'.$booking->booking_number) }}" class="text-success" title="process booking"><i class="fas fa-clipboard-check fa-lg"></i></a>
                        @endif

                        @if($booking->status == 3 && Auth::user()->role_id == 1)
                        <a href="javascript::void(0)" class="text-success" title="mark as complete" onclick="return confirmComplete('{{ $booking->id }}', '{{ $booking->booking_number }}')"><i class="fas fa-check fa-lg"></i></a>
                        @endif

                        @if($booking->status == 2 && Auth::user()->role_id == 2)
                        <a href="{{ url('approve-booking/'.$booking->booking_number) }}" class="text-success" title="approve booking"><i class="fas fa-clipboard-check fa-lg"></i></a>
                        @endif

                    	@if($booking->status !== 4 && $booking->status !== 5)
                        <a href="javascript:void(0)" class="text-danger" title="cancel booking" onclick="return showCancelBookingModal('{{ json_encode($booking, true) }}')"><i class="fas fa-times-circle fa-lg"></i></a>
                        @endif

                    </td>
                </tr>
                @endforeach
                @else 
                <tr>
                	<td class="text-center" colspan="6">No record found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{ $bookings->links() }}
	
</div>
@endsection