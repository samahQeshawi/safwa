<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Exports\TripsExport;
use App\Exports\BookingsExport;
use App\Exports\CarRentalsExport;
use App\Exports\CarsExport;
use App\Exports\WalletsExport;
use App\Exports\TransactionsExport;
use App\Exports\BranchesExport;
use App\Exports\CouponsExport;
use App\Models\City;
use App\Models\Car;
use App\Models\CarMake;
use App\Models\Category;
use App\Models\Branch;
use App\Models\User;
use App\Models\UserType;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\CarType;
use App\Models\CarRental;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;


class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the users.
     *
     * @return Illuminate\View\View
     */
    public function exportUsers(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = User::with('userType')->get();
            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('city') && $request->get('city')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return $row['city_id'] == $request->get('city');
                        });
                    }
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['phone'].$row['name'].$row['email']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                    if ($request->has('user_type') && $request->get('user_type')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return $row['user_type_id'] == $request->get('user_type');
                        });
                    }
                })
                ->addIndexColumn()
                ->make(true);
            return $datatable;
        }
        $users = User::with('userType')->paginate(25);
        $cities = City::pluck('name','id')->all();
        return view('reports.users.index', compact('users','cities'));
    }

    /**Excel Export */
    public function excelExportUsers(Request $request)
    {
        return (new UsersExport($request))->download('users'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportUsers(Request $request)
    {
        return (new UsersExport($request))->download('users'.time().'.pdf');
    }
    public function exportTrips(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = Trip::with('customer')->latest()->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {                    
                        if ($request->has('trip_status') && $request->get('trip_status')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                                return $row['trip_status'] == $request->get('trip_status');
                            });
                        }              
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['trip_number']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                                                                      
                    })            
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }
        return view('reports.trips.index');
    }    
     /**Excel Export */
    public function excelExportTrips(Request $request)
    {
        return (new TripsExport($request))->download('trips'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportTrips(Request $request)
    {
        return (new TripsExport($request))->download('trips'.time().'.pdf');
    }

    public function exportBookings(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = Booking::with('customer')->latest()->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('car_type') && $request->get('car_type')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['car_type_id'] == $request->get('car_type');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['booking_no'].$row['customer']['name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                        
                        if ($request->has('start_date') && $request->get('start_date')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['start_date'] == $request->get('start_date');
                            });
                        }                                                         
                    })             
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }

        $car_type =  CarType::pluck('name','id')->all();
        return view('reports.bookings.index',compact('car_type'));
    }           
    /**Excel Export */    
    public function excelExportBooking(Request $request)
    {
        return (new BookingsExport($request))->download('booking'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportBooking(Request $request)
    {
        return (new BookingsExport($request))->download('booking'.time().'.pdf');
    } 
    public function exportCars(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
    if ($request->ajax()) {
            $data = Car::with('carmake','category')->get();


            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('branch') && $request->get('branch')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['branch_id'] == $request->get('branch');
                            });
                        }
                        if ($request->has('category') && $request->get('category')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['category_id'] == $request->get('category');
                            });
                        }  
                        if ($request->has('car_make') && $request->get('car_make')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['car_make_id'] == $request->get('car_make');
                            });
                        }            
                        if ($request->has('car_model') && $request->get('car_model')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['model_year'] == $request->get('car_model');
                            });
                        }         
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['car_name'].$row['carmake']['car_make']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                                                                         
                    })            
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }

        $car = Car::with('carmake','category')->paginate(25);
        $branchs = Branch::pluck('name','id')->all();
        $categories = Category::pluck('category','id')->all();
        $carmake = CarMake::pluck('car_make','id')->all();
        $carmodel = Car::groupBy('model_year')->pluck('model_year')->all();;
        return view('reports.cars.index',compact('car','branchs','categories','carmake','carmodel'));
    }       
    /**Excel Export */    
    public function excelExportCar(Request $request)
    {
        return (new CarsExport($request))->download('car'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportCar(Request $request)
    {
        return (new CarsExport($request))->download('car'.time().'.pdf');
    }  

    public function exportWallets(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = Wallet::with('user.userType')->get();          
            //$data3 = array_merge($data1,$data2);             
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('user_type') && $request->get('user_type')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['user_type'] == $request->get('user_type');
                            });
                        }
                         if ($request->has('keyword') && $request->get('keyword')) {
                             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['user']['name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                        
                    })            
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }

        $wallet = Wallet::paginate(25);
        $user_type = UserType::pluck('user_type','id')->all();
        return view('reports.wallets.index',compact('user_type'));
    }       
    /**Excel Export */    
    public function excelExportWallet(Request $request)
    {
        return (new WalletsExport($request))->download('wallet'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportWallet(Request $request)
    {
        return (new WalletsExport($request))->download('wallet'.time().'.pdf');
    } 
    public function exportTransactions(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = Transaction::with('sender','receiver','booking')->get();          
            //$data3 = array_merge($data1,$data2);             
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('sender') && $request->get('sender')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['sender_id'] == $request->get('sender');
                            });
                        }
                         if ($request->has('keyword') && $request->get('keyword')) {
                             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if(is_null($row['sender'])){
                                    $row['sender'] = array('name'=>'');
                                }
                                if(is_null($row['receiver'])){
                                    $row['receiver'] = array('name'=>'');
                                }
                                if(is_null($row['booking'])){
                                    $row['booking'] = array('booking_no'=>'');
                                }
                                return Str::contains(Str::lower($row['sender']['name']).Str::lower($row['receiver']['name']).Str::lower($row['booking']['booking_no']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                        
                    })            
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }

        $wallet = Transaction::paginate(25);
        $users = User::pluck('name','id')->all();
        return view('reports.transactions.index',compact('users'));
    }     
    /**Excel Export */    
    public function excelExportTransaction(Request $request)
    {
        return (new TransactionsExport($request))->download('transaction'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportTransaction(Request $request)
    {
        return (new TransactionsExport($request))->download('transaction'.time().'.pdf');
    }  

    public function exportBranches(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = Branch::latest()->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('branch_code') && $request->get('branch_code')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['branch_code'] == $request->get('branch_code');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['name'].$row['phone'].$row['email']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                        
                        if ($request->has('city') && $request->get('city')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['city_id'] == $request->get('city');
                            });
                        }                                                         
                    })             
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }

        $branch = Branch::paginate(25);
        $cities = City::pluck('name','id')->all();
        $branch_code = Branch::pluck('branch_code','id')->all();
        return view('reports.branches.index',compact('branch','branch_code','cities'));
    }         
    /**Excel Export */    
    public function excelExportBranch(Request $request)
    {
        return (new BranchesExport($request))->download('branch'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportBranch(Request $request)
    {
        return (new BranchesExport($request))->download('branch'.time().'.pdf');
    }  
    public function exportCoupons(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = Coupon::get();


            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('coupon_code') && $request->get('coupon_code')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['coupon_code'] == $request->get('coupon_code');
                            });
                        }
                        if ($request->has('city') && $request->get('city')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['place_id'] == $request->get('city');
                            });
                        } 
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['coupon_code'].$row['coupon_name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                                                                                  
                    })             
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }

        $coupon = Coupon::paginate(25);
        $cities = City::pluck('name','id')->all();
        $coupon_code = Coupon::pluck('coupon_code','id')->all();
        return view('reports.coupons.index',compact('coupon','coupon_code','cities'));
    }

    /**Excel Export */    
    public function excelExportCoupon(Request $request)
    {
        return (new CouponsExport($request))->download('coupon'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportCoupon(Request $request)
    {
        return (new CouponsExport($request))->download('coupon'.time().'.pdf');
    }        
    public function exportCarRentals(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the users.
         */
        if ($request->ajax()) {
            $data = CarRental::with('user')->latest()->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['booking_no'].$row['user']['name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                                                                            
                    })             
                    ->addIndexColumn()
                    ->make(true);
            return $datatable;
        }

        return view('reports.car_rentals.index');
    }           
    /**Excel Export */    
    public function excelExportCarRental(Request $request)
    {
        return (new CarRentalsExport($request))->download('car_rental'.time().'.xlsx');
    }

    /**PDF Export */
    public function pdfExportCarRental(Request $request)
    {
        return (new CarRentalsExport($request))->download('car_rental'.time().'.pdf');
    }     
}
