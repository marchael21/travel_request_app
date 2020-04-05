<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\BookingStatus;
use App\Models\BookingDriverDetail;
use App\Models\Vehicle;
use App\Models\VehicleStatistic;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Auth;
use Session;

class BookingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('driver');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authId = Auth::id();

        $statusOpt = BookingStatus::get();

        $bookingCount = countBookings();

        // echo generateBookingNumber();
        // die;

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = Booking::select(
                        'id',
                        'booking_number',
                        'destination',
                        'purpose',
                        'objectives',
                        'departure_date', 
                        'return_date',
                        'status'
                    )->where('driver_id', $authId);

        if (isset($request->booking_number) && $request->booking_number !=='') {
            $query->where('booking_number', $request->booking_number);
        }

        if (isset($request->status) && $request->status !=='') {
            $query->where('status', $request->status);
        }


        $bookings = $query->orderBy('id', 'desc')->paginate($pageLimit);

        foreach ($bookings as $i => $booking) {
            $booking->schedule = $booking->schedule;
        }


        // Search Filters
        $searchFilter = array();
        $searchFilter['page_limit'] = $pageLimit;
        $searchFilter['booking_number'] = isset($request->booking_number) && $request->booking_number !== '' ? $request->booking_number : '';
        $searchFilter['status'] = isset($request->status) && $request->status !== '' ? $request->status : '';

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/booking'),
                'name'  => 'Booking',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.driver.bookings.tabs.all', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'statusOpt', 'bookingCount'));
    }

    public function approvedPage(Request $request)
    {
        $authId = Auth::id();
        $bookingCount = countBookings();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = Booking::select(
                        'id',
                        'booking_number',
                        'destination',
                        'purpose',
                        'objectives',
                        'departure_date', 
                        'return_date',
                        'status'
                    )->where('status', 3)
                    ->where('driver_id', $authId);

        if (isset($request->booking_number) && $request->booking_number !=='') {
            $query->where('booking_number', $request->booking_number);
        }

        $bookings = $query->orderBy('id', 'desc')->paginate($pageLimit);

        foreach ($bookings as $i => $booking) {
            $booking->schedule = $booking->schedule;
        }


        // Search Filters
        $searchFilter = array();
        $searchFilter['page_limit'] = $pageLimit;
        $searchFilter['booking_number'] = isset($request->booking_number) && $request->booking_number !== '' ? $request->booking_number : '';

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/booking'),
                'name'  => 'Booking',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.driver.bookings.tabs.approved', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    public function completedPage(Request $request)
    {
        $authId = Auth::id();
        $bookingCount = countBookings();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = Booking::select(
                        'id',
                        'booking_number',
                        'destination',
                        'purpose',
                        'objectives',
                        'departure_date', 
                        'return_date',
                        'status'
                    )->where('status', 4)
                    ->where('driver_id', $authId);

        if (isset($request->booking_number) && $request->booking_number !=='') {
            $query->where('booking_number', $request->booking_number);
        }

        $bookings = $query->orderBy('id', 'desc')->paginate($pageLimit);

        foreach ($bookings as $i => $booking) {
            $booking->schedule = $booking->schedule;
        }


        // Search Filters
        $searchFilter = array();
        $searchFilter['page_limit'] = $pageLimit;
        $searchFilter['booking_number'] = isset($request->booking_number) && $request->booking_number !== '' ? $request->booking_number : '';

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/booking'),
                'name'  => 'Booking',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.driver.bookings.tabs.completed', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    public function cancelledPage(Request $request)
    {
        $authId = Auth::id();
        $bookingCount = countBookings();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = Booking::select(
                        'id',
                        'booking_number',
                        'destination',
                        'purpose',
                        'objectives',
                        'departure_date', 
                        'return_date',
                        'status'
                    )->where('status', 5)
                    ->where('driver_id', $authId);

        if (isset($request->booking_number) && $request->booking_number !=='') {
            $query->where('booking_number', $request->booking_number);
        }

        $bookings = $query->orderBy('id', 'desc')->paginate($pageLimit);

        foreach ($bookings as $i => $booking) {
            $booking->schedule = $booking->schedule;
        }


        // Search Filters
        $searchFilter = array();
        $searchFilter['page_limit'] = $pageLimit;
        $searchFilter['booking_number'] = isset($request->booking_number) && $request->booking_number !== '' ? $request->booking_number : '';

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/booking'),
                'name'  => 'Booking',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.driver.bookings.tabs.cancelled', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bookingNumber)
    {
        $authId = Auth::id();

        $booking = Booking::where('booking_number', $bookingNumber)
                        ->with('bookingStatus')
                        ->with('bookingCurrentHistory')
                        ->with('driver')
                        ->with('vehicle')->first();
        $booking->schedule = '';                

        $vehicleStat = VehicleStatistic::where('vehicle_id', $booking->vehicle_id)->first();

        $bookingDriverDetail = BookingDriverDetail::where('booking_id', $booking->id)->first();
        
        if(!isset($booking->id))
            abort('404');

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/booking'),
                'name'  => 'Bookings',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'View Information',
                'icon'  => '',
                'class' => 'active'
            ), 
        );

        return view('pages.driver.bookings.view', ['booking' => $booking], compact('pageData', 'vehicleStat', 'bookingDriverDetail'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
