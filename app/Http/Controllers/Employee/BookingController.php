<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\BookingStatus;
use App\Models\BookingDriverDetail;
use App\User;
use App\Models\Role;
use App\Http\Requests\StoreBooking;
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
        $this->middleware('employee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authId = Auth::id();
        $bookingCount = countBookings();

        $statusOpt = BookingStatus::get();

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
                    )->where('employee_id', $authId);

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
                'link'  => url('/my-booking'),
                'name'  => 'My Booking',
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

        return view('pages.employee.bookings.tabs.all', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'statusOpt', 'bookingCount'));
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
                    )->where('status', 1)
                    ->where('employee_id', $authId);

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
                'link'  => url('/my-booking'),
                'name'  => 'My Booking',
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

        return view('pages.employee.bookings.tabs.pending', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
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
                    )->where('status', 2)
                    ->where('employee_id', $authId);

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
                'link'  => url('/my-booking'),
                'name'  => 'My Booking',
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

        return view('pages.employee.bookings.tabs.processing', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
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
                    ->where('employee_id', $authId);

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
                'link'  => url('/my-booking'),
                'name'  => 'My Booking',
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

        return view('pages.employee.bookings.tabs.approved', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
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
                    ->where('employee_id', $authId);

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
                'link'  => url('/my-booking'),
                'name'  => 'My Booking',
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

        return view('pages.employee.bookings.tabs.completed', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
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
                    ->where('employee_id', $authId);

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
                'link'  => url('/my-booking'),
                'name'  => 'My Booking',
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

        return view('pages.employee.bookings.tabs.cancelled', ['bookings' => $bookings], compact('pageData', 'searchFilter', 'bookingCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::id();

        $roleOpt = Role::get();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/my-booking'),
                'name'  => 'My Bookings',
                'icon'  => 'fas fa-passport',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'Request Booking',
                'icon'  => '',
                'class' => 'active'
            ), 
        );

        return view('pages.employee.bookings.create', compact('pageData', 'roleOpt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBooking $request)
    {
        $authId = Auth::id();

        // Retrieve the validated input data...
        $validated = $request->validated();

        $booking = new Booking;
        $booking->booking_number = generateBookingNumber();
        $booking->requestor_name = $request->requestor_name;
        $booking->requestor_position = @$request->requestor_position;
        $booking->requestor_monthly_salary = isset($request->requestor_monthly_salary) ? str_replace(',', '', $request->requestor_monthly_salary) : NULL;
        $booking->requestor_official_station = @$request->requestor_official_station;
        $booking->departure_date = date('Y-m-d 00:00:00', strtotime($request->departure_date));
        $booking->return_date = date('Y-m-d 00:00:00', strtotime($request->return_date));
        $booking->destination = $request->destination;
        $booking->purpose = $request->purpose;
        $booking->status = 1; // pending status
        $booking->status_date = date('Y-m-d H:i:s');
        $booking->employee_id = $authId;
        $booking->created_by = $authId;
        $booking->updated_by = $authId;

        try {

            // save booking
            if($booking->save()) {

                $bookingDriverDetail = new BookingDriverDetail;
                $bookingDriverDetail->booking_id = $booking->id;
                $bookingDriverDetail->save();

                $bookingHistory = new BookingHistory;
                $bookingHistory->booking_id = $booking->id;
                $bookingHistory->booking_status_id = 1; // pending status
                $bookingHistory->remarks = '';
                $bookingHistory->created_by = $authId;
                $bookingHistory->updated_by = $authId;

                $bookingHistory->save();

                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Booking Submitted!',
                    'text'  => 'You have successfully submitted booking request.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                return redirect('my-booking/pending')->with('alertMsg', $alertMsg);

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

            return redirect('request-booking')->withInput()->with('alertMsg', $alertMsg);

        }
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

        $booking = Booking::where('employee_id', $authId)->where('booking_number', $bookingNumber)->first();

        if(!isset($booking->id))
            abort('404');

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/my-booking'),
                'name'  => 'My Booking',
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

        return view('pages.employee.bookings.view', ['booking' => $booking], compact('pageData'));

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
                        'status'
                    )->where('employee_id', $authId)
                    ->where('id', $request->booking_id)
                    ->where('status', 1)->first();


        if (!isset($booking->id)) {
            $alertMsg = array(
                'title' => 'Oops!',
                'text'  => 'Booking doesn\'t exist. Please contact the administrator!' ,
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

                return redirect()->back()->with('alertMsg', $alertMsg);

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
