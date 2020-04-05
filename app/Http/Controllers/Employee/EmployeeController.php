<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\BookingStatus;
use App\User;
use App\Models\Role;
use Auth;
use Session;

class EmployeeController extends Controller
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

        $bookingCount = countBookings();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => '',
                'name'  => 'Dashboard',
                'icon'  => 'fas fa-tachometer',
                'class' => 'active'
            ),
        );

        return view('pages.employee.dashboard', compact('pageData', 'bookingCount')); 
    }

    public function mySchedulePage()
    {
        $authId = Auth::id();

        $pageData = [];
        $pageData['breadcrumb'] = array(
            array(
                'link'  => url('/my-schedules'),
                'name'  => 'My Booking',
                'icon'  => 'fas fa-calendar',
                'class' => ''
            ),
            array(
                'link'  => '',
                'name'  => 'List',
                'icon'  => '',
                'class' => 'active'
            ),
        );

        return view('pages.employee.my_schedules.list', compact('pageData'));        
    }

    public function myScheduleList(Request $request)
    {
        $authId = Auth::id();

        if(request()->ajax()) 
        {
 
            $startDate = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $endDate = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
 
            $bookings = Booking::where('employee_id', $authId)->whereDate('departure_date', '>=', $startDate)->whereDate('return_date',   '<=', $endDate)->get();

            $data = array();
            foreach ($bookings as $i => $booking) {
                $className = '';
                if ($booking->status == 1) {
                    $className = 'bg-warning border-warning text-dark';
                } elseif ($booking->status == 2) {
                    $className = 'bg-warning border-warning text-dark';
                } elseif ($booking->status == 3) {
                    $className = 'bg-primary border-primary';
                } elseif ($booking->status == 4) {
                    $className = 'bg-success border-success';
                } elseif ($booking->status == 5) {
                    $className = 'bg-danger border-danger';
                } else {}

                $data[] = array(
                    'id'        => $booking->id,
                    'title'     => $booking->destination,
                    'start'     => date('Y-m-d', strtotime($booking->departure_date)),
                    'end'       => date('Y-m-d', strtotime($booking->return_date . " + 1 day")),
                    'url'       => url('my-booking/view/'.$booking->booking_number),
                    'className' => $className,
                );

            }

            return response()->json($data);

        } else {
            abort(404, '404 Not Found'); 
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
