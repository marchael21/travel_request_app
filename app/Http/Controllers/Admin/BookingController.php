<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\BookingStatus;
use App\Models\Vehicle;
use App\User;
use App\Models\Role;
use App\Http\Requests\ProcessBooking;
use App\Http\Requests\CancelBooking;
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
        $this->middleware('admin');
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
                    );

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

        return view('pages.admin.bookings.tabs.all', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'statusOpt', 'bookingCount'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pendingPage(Request $request)
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
                    )->where('status', 1);

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

        return view('pages.admin.bookings.tabs.pending', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function processedPage(Request $request)
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
                    )->where('status', 2);

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

        return view('pages.admin.bookings.tabs.processing', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
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

        return view('pages.admin.bookings.tabs.approved', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
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

        return view('pages.admin.bookings.tabs.completed', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
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

        return view('pages.admin.bookings.tabs.cancelled', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function processBookingPage(Request $request)
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
                    )->where('status', 1);

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
                'link'  => url('/process-booking'),
                'name'  => 'Process Booking',
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

        return view('pages.admin.bookings.process_booking_list', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function processBookingShow($bookingNumber)
    {
        $authId = Auth::id();

        $booking = Booking::where('booking_number', $bookingNumber)->with('bookingStatus')->first();
        $booking->schedule = '';

        $driverOpt = User::where('role_id', 4)->get();
        $vehicleOpt = Vehicle::where('status', 1)->get();

        if(!isset($booking->id))
            abort('404');

        if ($booking->status !== 1) {
            $alertMsg = array(
                'title' => 'Oops!',
                'text'  => 'Booking ['. $booking->booking_number . '] was already processed!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);
        }


        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/process-booking'),
                'name'  => 'Process Booking',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Booking no. ' . $booking->booking_number,
                'icon'  => '',
                'class' => 'active'
            ), 
        );

        return view('pages.admin.bookings.process_booking_view', ['booking' => $booking], compact('pageData', 'driverOpt', 'vehicleOpt'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function processBooking(ProcessBooking $request, $id)
    {
        $authId = Auth::id();

        // Retrieve the validated input data...
        $validated = $request->validated();

        $booking = Booking::find($id);

        if ($booking->status !== 1) {
            $alertMsg = array(
                'title' => 'Oops!',
                'text'  => 'Booking ['. $booking->booking_number . '] was already processed!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);
        }

        $booking->daily_expenses_allowed = str_replace(',', '', $request->daily_expenses_allowed);
        $booking->assistant_laborers_allowed = str_replace(',', '', $request->assistant_laborers_allowed);
        $booking->appropriation_travel_charged = str_replace(',', '', $request->appropriation_travel_charged);
        $booking->driver_id = $request->driver;
        $booking->vehicle_id = $request->vehicle;
        $booking->status = 2; //processed booking
        $booking->status_date = date('Y-m-d H:i:s');
        $booking->processed_by = $authId;
        $booking->remarks = $request->remarks;
        $booking->updated_by = $authId;

        try {

            // save booking
            if($booking->save()) {

                $bookingHistory = new BookingHistory;
                $bookingHistory->booking_id = $booking->id;
                $bookingHistory->booking_status_id = 2; // processed status
                $bookingHistory->remarks = $booking->remarks;
                $bookingHistory->created_by = $authId;
                $bookingHistory->updated_by = $authId;

                $bookingHistory->save();

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Booking Processed Successfully!',
                    'text'  => 'You have successfully processed booking request.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('process-booking')->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            // echo $e->getMessage();
            // die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);

        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveBookingPage(Request $request)
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
                    )->where('status', 2);

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
                'link'  => url('/approve-booking'),
                'name'  => 'Approve Booking',
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

        return view('pages.admin.bookings.approve_booking_list', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveBookingShow($bookingNumber)
    {
        $authId = Auth::id();

        $booking = Booking::where('booking_number', $bookingNumber)->with('bookingStatus')->with('driver')->with('vehicle')->first();
        $booking->schedule = '';

        if(!isset($booking->id))
            abort('404');

        if ($booking->status !== 2) {
            $alertMsg = array(
                'title' => 'Oops!',
                'text'  => 'Booking ['. $booking->booking_number . '] was already approved or can\'t be be approved!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);
        }

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/approve-booking'),
                'name'  => 'Approve Booking',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Booking no. ' . $booking->booking_number,
                'icon'  => '',
                'class' => 'active'
            ), 
        );

        return view('pages.admin.bookings.approve_booking_view', ['booking' => $booking], compact('pageData'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveBooking(Request $request, $id)
    {
        $authId = Auth::id();

        $booking = Booking::find($id);

        if ($booking->status !== 2) {
            $alertMsg = array(
                'title' => 'Oops!',
                'text'  => 'Booking ['. $booking->booking_number . '] was already approved or can\'t be be approved!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);
        }

        $booking->status = 3; //approved booking
        $booking->status_date = date('Y-m-d H:i:s');
        $booking->approved_by = $authId;        
        $booking->updated_by = $authId;

        try {

            // save booking
            if($booking->save()) {

                $bookingHistory = new BookingHistory;
                $bookingHistory->booking_id = $booking->id;
                $bookingHistory->booking_status_id = 3; // approved status
                $bookingHistory->remarks = '';
                $bookingHistory->created_by = $authId;
                $bookingHistory->updated_by = $authId;

                $bookingHistory->save();

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Booking Approved Successfully!',
                    'text'  => 'You have successfully approved booking request.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('approve-booking')->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function completeBooking(Request $request, $id)
    {
        $authId = Auth::id();

        $booking = Booking::find($id);

        if ($booking->status !== 3) {
            $alertMsg = array(
                'title' => 'Oops!',
                'text'  => 'Booking ['. $booking->booking_number . '] was already completed or can\'t be be completed!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);
        }

        $booking->status = 4; //completed booking
        $booking->status_date = date('Y-m-d H:i:s');
        $booking->approved_by = $authId;        
        $booking->updated_by = $authId;

        try {

            // save booking
            if($booking->save()) {

                $bookingHistory = new BookingHistory;
                $bookingHistory->booking_id = $booking->id;
                $bookingHistory->booking_status_id = 4; // completed status
                $bookingHistory->remarks = '';
                $bookingHistory->created_by = $authId;
                $bookingHistory->updated_by = $authId;

                $bookingHistory->save();

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Booking Marked Complete',
                    'text'  => 'You have successfully marked this booking [' . $booking->booking_number . ']. as complete',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect()->back()->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);

        }

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
                        ->with('vehicle')->first()
                        ->where('driver_id', $authId);

        $booking->schedule = '';
        
        if(!isset($booking->id))
            abort('404');

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/assigned-booking'),
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

        return view('pages.driver.bookings.view', ['booking' => $booking], compact('pageData'));

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
    public function cancel(Request $request)
    {
        $authId = Auth::id();
        $cancelModalData = false;


        if (!isset($request->booking_id)) {
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect('request-booking')->withInput()->with('alertMsg', $alertMsg);
        }

        //get booking 
        $booking = Booking::select(
                        'id',
                        'booking_number',
                        'destination',
                        'purpose',
                        'objectives',
                        'departure_date', 
                        'return_date',
                        'status',
                    )->where('id', $request->booking_id)
                    ->where('status', 1)->first();


        if (!isset($booking->id)) {
            $alertMsg = array(
                'title' => 'Oops!',
                'text'  => 'Booking doesn\'t exist. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);
        }

        $booking->schedule = '';

        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string|max:300',
        ]);

        // Retrieve the validated input data...
        // $validated = $request->validated();

        if ($validator->fails()) {
            return redirect()->back()->withInput()
                    ->withErrors($validator)
                    ->with('cancelModalData', $booking->toArray());
        }

        $bookingData = Booking::find($booking->id);
        $bookingData->status = 5; // cancelled status
        $bookingData->status_date = date('Y-m-d H:i:s');
        $bookingData->updated_by = $authId;

        try {

            // save booking
            if($bookingData->save()) {

                $bookingHistory = new BookingHistory;
                $bookingHistory->booking_id = $booking->id;
                $bookingHistory->booking_status_id = 5; // cancelled status
                $bookingHistory->remarks = $request->cancellation_reason;
                $bookingHistory->created_by = $authId;
                $bookingHistory->updated_by = $authId;

                $bookingHistory->save();

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Booking Cancelled!',
                    'text'  => 'You have successfully cancelled booking [booking no. ' . $bookingData->booking_number . '].',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                // return redirect()->back()->with('alertMsg', $alertMsg);
                return redirect('booking/cancelled')->with('alertMsg', $alertMsg);

           }

        } catch (\Exception $e) {
            // echo $e->getMessage();
            // die;
            $alertMsg = array(
                'title' => 'Error!',
                'text'  => 'Error occured. Please contact the developer!' ,
                'icon'  => 'error',
                'type'  => 'swal' // type should be swal or toastr
            );

            return redirect()->back()->withInput()->with('alertMsg', $alertMsg);

        }

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
