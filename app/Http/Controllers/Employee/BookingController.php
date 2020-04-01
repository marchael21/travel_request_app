<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\User;
use App\Models\Role;
use App\Http\Requests\StoreBooking;
use Auth;
 
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
    public function index()
    {
        $authId = Auth::id();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = DB::table('bookings');

        $bookings = $query->paginate($pageLimit);

        // Search Filters
        $searchFilter = array();
        $searchFilter['page_limit'] = $pageLimit;

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/my-bookings'),
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

        return view('pages.employee.bookings.tabs.all', ['bookings' => $bookings], compact('pageData', 'searchFilter'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pendingPage()
    {
        $authId = Auth::id();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = DB::table('bookings');

        $bookings = $query->paginate($pageLimit);

        // Search Filters
        $searchFilter = array();
        $searchFilter['page_limit'] = $pageLimit;

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/my-bookings'),
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

        return view('pages.employee.bookings.tabs.all', ['bookings' => $bookings], compact('pageData', 'searchFilter'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function processingPage()
    {
        $authId = Auth::id();

        // Page Limit
        $pageLimit = isset($request->page_limit) ? (int)$request->page_limit : 10;

        // Query
        $query = DB::table('bookings');

        $bookings = $query->paginate($pageLimit);

        // Search Filters
        $searchFilter = array();
        $searchFilter['page_limit'] = $pageLimit;

        // Page Data
        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/my-bookings'),
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

        return view('pages.employee.bookings.tabs.all', ['bookings' => $bookings], compact('pageData', 'searchFilter'));
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
                'link'  => url('/my-bookings'),
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

                return redirect('request-booking')->with('alertMsg', $alertMsg);

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

            return redirect('request-booking')->withInput()->with('alertMsg', $alertMsg);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
