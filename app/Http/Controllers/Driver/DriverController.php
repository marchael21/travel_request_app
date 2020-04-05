<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\BookingStatus;
use App\Models\Vehicle;
use App\Models\VehicleStatistic;
use App\User;
use App\Models\Role;
use Auth;
use Session;

class DriverController extends Controller
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

        return view('pages.driver.dashboard', compact('pageData', 'bookingCount')); 
    }

    public function driverScheduleList(Request $request)
    {
        $authId = Auth::id();

        if(request()->ajax()) 
        {
 
            $startDate = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $endDate = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
 
            $bookings = Booking::where('driver_id', $authId)->whereNotIn('status', [1, 2])->whereDate('departure_date', '>=', $startDate)->whereDate('return_date',   '<=', $endDate)->get();

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
                    'url'       => url('assigned-booking/view/'.$booking->booking_number),
                    'className' => $className,
                );

            }

            return response()->json($data);

        } else {
            abort(404, '404 Not Found'); 
        }     
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateVehicleStats(Request $request, $id)
    {
        $authId = Auth::id();

        $vehicleStat = VehicleStatistic::find($id);
        $vehicleStat->battery = $request->stat_battery;
        $vehicleStat->lights = $request->stat_lights;
        $vehicleStat->oil = $request->stat_oil;
        $vehicleStat->water = $request->stat_water;
        $vehicleStat->brake = $request->stat_brake;
        $vehicleStat->tire = $request->stat_tire;
        $vehicleStat->gas = $request->stat_gas;
        $vehicleStat->spare_tire = $request->stat_spare_tire;
        $vehicleStat->tool_set = $request->stat_tool_set;
        $vehicleStat->ewd = $request->stat_ewd;
        $vehicleStat->easytrip = $request->stat_easytrip;
        $vehicleStat->fleet_card = $request->stat_fleet_card;
        $vehicleStat->remarks = $request->stat_remarks;
        $vehicleStat->updated_by = $authId;

        try {

            // save vehicle
            if($vehicleStat->save()) {                
                // alert message content for sweetalert or toastr on client side
                $alertMsg = array(
                    'title' => 'Vehicle Stats Updated!.',
                    'text'  => 'Vehicle statistics has been updated successfully.',
                    'icon'  => 'success',
                    'type'  => 'swal' // type should be swal or toastr
                );

                // return redirect(session('links')[2])->with('alertMsg', $alertMsg);
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

            return redirect()->back()->with('alertMsg', $alertMsg);

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
