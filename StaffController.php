<?php

namespace App\Http\Controllers;

use App\AgencyOrGuide;
use App\Assign_expenses_cashbook;
use App\Assigned_cash_book;
use App\Booking;
use App\Booking_archive;
use App\Booking_room;
use App\Booking_room_count;
use App\Cash_book_log_activity;
use App\Cashbook;
use App\Cashbook_monthly_record;
use App\Check_list;
use App\Check_list_detail;
use App\Check_list_image;
use App\Check_list_layout;
use App\Combo_item;
use App\Customer;
use App\Expense;
use App\Expense_category;
use App\Expense_detail;
use App\Expense_sub_category;
use App\Food_attachment;
use App\Goods_received_note;
use App\Goods_received_note_detail;
use App\Hotel;
use App\Hotel_estimate;
use App\Hotel_invoice;
use App\Hotel_invoice_payment;
use App\Hotel_invoice_payment_detail;
use App\Hotel_reservation_setting;
use App\Housekeeping;
use App\Inventory;
use App\Inventory_category;
use App\Inventory_item;
use App\Inventory_item_bill;
use App\Inventory_item_bill_detail;
use App\Inventory_sub_category;
use App\Inventory_wastage;
use App\Item;
use App\Item_detail;
use App\Janitorial_item;
use App\Janitorial_item_detail;
use App\Job_application_detail;
use App\Job_position;
use App\Job_position_category;
use App\LogActivity;
use App\LogActivityInventory;
use App\Mail\Aditionalwifi;
use App\Mail\Booking_approved_mail;
use App\Mail\BookingMail;
use App\Mail\Estimateinvoice;
use App\Mail\Jobapplication;
use App\Mail\Otherincomeinvoice;
use App\Mail\Pending_booking_mail;
use App\Menu;
use App\Menu_category_detail;
use App\Order_list;
use App\Order_list_detail;
use App\Other_check_list;
use App\Other_income;
use App\Other_income_category_list;
use App\Other_income_item_detail;
use App\Other_income_payment;
use App\Other_income_payment_cash_book;
use App\Other_income_payments_history;
use App\Other_location;
use App\Payment;
use App\Promotion;
use App\Recipe;
use App\Recipe_category;
use App\Recipe_item;
use App\Recipe_note_detail;
use App\Refilling_item;
use App\Reservation;
use App\Reservation_room;
use App\Restaurant;
use App\Restaurant_menu;
use App\Room;
use App\Room_category;
use App\Room_estimate_detail;
use App\Room_rapair;
use App\Supplier;
use App\Supplier_payment;
use App\Table;
use App\User;
use App\Utility;
use App\Utility_category;
use App\Wastage;
use App\Maintenance;
//use App\Otherlocation;
use App\Repair_category;
use App\Repair_status;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\In;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade;
use function Symfony\Component\String\u;
use App\Mail\Invoice;
use Illuminate\Support\Facades\Mail;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('isHotel');
    }

    public function index()
    {
        return view('hotel.sample');
       //return redirect()->route('hotel/dashboard');
    }

    public function dashboard_view()
    {
        return view('hotel.dashboard');
    }

    public function widget_view()
    {
        return view('hotel.widget');
    }

    public function dashboard_sale_chart_render(Request $request)
    {

        $selected_date_sale = $request->input('selected_date_sale');
        $d_m_obj_start = new Carbon($selected_date_sale);
        $d_m_obj_end = new Carbon($selected_date_sale);

        $start_month = $d_m_obj_start->startOfMonth();
        $end_month = $d_m_obj_end->endOfMonth();

        $year = \Illuminate\Support\Carbon::now()->year;
        $month = Carbon::now()->month;
        $daysCount = $start_month->daysInMonth;

        $Sale_Total = Order_list::whereMonth('finalize_date', '=', date('m', strtotime($start_month)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($start_month)))
            ->where('hotel_id', auth()->user()->hotel_id)
            ->selectRaw('DAYOFMONTH(finalize_date) monthDay, SUM( total) total_sale')
            ->groupBy('monthDay')
            ->get();

        $Cash_Total = Order_list::whereMonth('finalize_date', '=', date('m', strtotime($start_month)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($start_month)))
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('payment_method', 'Cash')
            ->selectRaw('DAYOFMONTH(finalize_date) monthDay, SUM( total) total_cash')
            ->groupBy('monthDay')
            ->get();
        $Card_Total = Order_list::whereMonth('finalize_date', '=', date('m', strtotime($start_month)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($start_month)))
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('payment_method', 'Card')
            ->selectRaw('DAYOFMONTH(finalize_date) monthDay, SUM( total) total_card')
            ->groupBy('monthDay')
            ->get();
        $Prepaid_Total = Order_list::whereMonth('finalize_date', '=', date('m', strtotime($start_month)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($start_month)))
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('payment_method', 'Pre-paid')
            ->selectRaw('DAYOFMONTH(finalize_date) monthDay, SUM( total) total_prepaid')
            ->groupBy('monthDay')
            ->get();
        $Free_Total = Order_list::whereMonth('finalize_date', '=', date('m', strtotime($start_month)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($start_month)))
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('payment_method', 'Free')
            ->selectRaw('DAYOFMONTH(finalize_date) monthDay, SUM( total) total_free')
            ->groupBy('monthDay')
            ->get();
        $Service_charge_Total = Order_list::whereMonth('finalize_date', '=', date('m', strtotime($start_month)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($start_month)))
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('payment_method', '!=', 'Free')
            ->selectRaw('DAY(finalize_date) as monthDay, SUM(service_charge) as total_service')
            ->groupBy('monthDay')
            ->get();

        $readable = array();
        $total_sale_count = 0;
        $total_cash_count = 0;
        $total_card_count = 0;
        $total_prepaid_count = 0;
        $total_free_count = 0;
        $total_service_count = 0;
        for ($i = 1; $i <= $daysCount; $i++) {
            $flag = 'Not found';
            $t_sale = 0;
            $t_cash_value = 0;
            $t_card_value = 0;
            $t_prepaid_value = 0;
            $t_free_value = 0;
            $t_service_value = 0;
            foreach ($Sale_Total as $total_cost_data) {
                if ($total_cost_data->monthDay == $i) {
                    $t_sale = $total_cost_data->total_sale;
                    $flag = 'Found';
                    $total_sale_count = $total_sale_count + $total_cost_data->total_sale;
                }

            }
            foreach ($Service_charge_Total as $total_service_data) {
                if ($total_service_data->monthDay == $i) {
                    $t_service_value = $total_service_data->total_service;
                    $flag = 'Found';
                    $total_service_count = $total_service_count + $total_service_data->total_service;
                }

            }
            foreach ($Cash_Total as $total_cash_data) {
                if ($total_cash_data->monthDay == $i) {
                    $t_cash_value = $total_cash_data->total_cash;
                    $flag = 'Found';
                    $total_cash_count = $total_cash_count + $total_cash_data->total_cash;
                }

            }
            foreach ($Card_Total as $total_card_data) {
                if ($total_card_data->monthDay == $i) {
                    $t_card_value = $total_card_data->total_card;
                    $flag = 'Found';
                    $total_card_count = $total_card_count + $total_card_data->total_card;
                }

            }
            foreach ($Prepaid_Total as $total_prepaid_data) {
                if ($total_prepaid_data->monthDay == $i) {
                    $t_prepaid_value = $total_prepaid_data->total_prepaid;
                    $flag = 'Found';
                    $total_prepaid_count = $total_prepaid_count + $total_prepaid_data->total_prepaid;
                }

            }
            foreach ($Free_Total as $total_free_data) {
                if ($total_free_data->monthDay == $i) {
                    $t_free_value = $total_free_data->total_sale;
                    $flag = 'Found';
                    $total_free_count = $total_free_count + $total_free_data->total_sale;
                }

            }
//9.6
//12.00/9.00

            if ($flag == 'Found') {
                array_push($readable, ['date' => \Illuminate\Support\Carbon::createFromDate($year, $month, $i), 'value1' => $t_sale, 'value2' => $t_cash_value, 'value3' => $t_card_value, 'value4' => $t_prepaid_value, 'value5' => $t_free_value,'value6' => $t_service_value]);

            } elseif ($flag == 'Not found') {
                array_push($readable, ['date' => \Illuminate\Support\Carbon::createFromDate($year, $month, $i), 'value1' => 0, 'value2' => 0, 'value3' => 0, 'value4' => 0, 'value5' => 0]);
            }

        }
        return response()->json(['readable' => $readable, 'total_sale_count' => $total_sale_count, 'total_free_count' => $total_free_count, 'total_prepaid_count' => $total_prepaid_count, 'total_card_count' => $total_card_count, 'total_cash_count' => $total_cash_count,'total_service_count' => $total_service_count]);
    }

    public function dashboard_reservation_chart_render(Request $request){
        $selected_date_sale = $request->input('selected_date_reservation');
        $d_m_obj_start = new Carbon($selected_date_sale);
        $d_m_obj_end = new Carbon($selected_date_sale);

        $start_month = $d_m_obj_start->startOfMonth()->format('Y-m-d');
        $end_month = $d_m_obj_end->endOfMonth()->format('Y-m-d');

        $year = \Illuminate\Support\Carbon::now()->year;
        $month = Carbon::now()->month;
        $daysCount = $d_m_obj_start->startOfMonth()->daysInMonth;

        $Reservation_Total = Cash_book_log_activity::whereBetween('date', [$start_month, $end_month])
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('reservation_id','!=', null)
            ->selectRaw('DAYOFMONTH(date) monthDay, SUM( debit) total_reservation')
            ->groupBy('monthDay')
            ->get();

        $Cash_Total = Cash_book_log_activity::whereBetween('date', [$start_month, $end_month])
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('type', 'cash')
            ->selectRaw('DAYOFMONTH(date) monthDay, SUM( debit) total_cash')
            ->groupBy('monthDay')
            ->get();
        $Card_Total = Cash_book_log_activity::whereBetween('date', [$start_month, $end_month])
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('type', 'card')
            ->selectRaw('DAYOFMONTH(date) monthDay, SUM( debit) total_card')
            ->groupBy('monthDay')
            ->get();
        $Advance_Total = Cash_book_log_activity::whereBetween('date', [$start_month, $end_month])
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('type', 'advance')
            ->selectRaw('DAYOFMONTH(date) monthDay, SUM( debit) total_advance')
            ->groupBy('monthDay')
            ->get();

        $readable = array();
        $total_reservation_count = 0;
        $total_cash_count = 0;
        $total_card_count = 0;
        $total_advance_count = 0;
        for ($i = 1; $i <= $daysCount; $i++) {
            $flag = 'Not found';
            $t_reservation = 0;
            $t_cash_value = 0;
            $t_card_value = 0;
            $t_advance_value = 0;
            foreach ($Reservation_Total as $total_reservation_data) {
                if ($total_reservation_data->monthDay == $i) {
                    $t_reservation = $total_reservation_data->total_reservation;
                    $flag = 'Found';
                    $total_reservation_count = $total_reservation_count + $total_reservation_data->total_reservation;
                }
            }
            foreach ($Cash_Total as $total_cash_data) {
                if ($total_cash_data->monthDay == $i) {
                    $t_cash_value = $total_cash_data->total_cash;
                    $flag = 'Found';
                    $total_cash_count = $total_cash_count + $total_cash_data->total_cash;
                }

            }
            foreach ($Card_Total as $total_card_data) {
                if ($total_card_data->monthDay == $i) {
                    $t_card_value = $total_card_data->total_card;
                    $flag = 'Found';
                    $total_card_count = $total_card_count + $total_card_data->total_card;
                }

            }
            foreach ($Advance_Total as $total_advance_data) {
                if ($total_advance_data->monthDay == $i) {
                    $t_advance_value = $total_advance_data->total_advance;
                    $flag = 'Found';
                    $total_advance_count = $total_advance_count + $total_advance_data->total_advance;
                }

            }

            if ($flag == 'Found') {
                array_push($readable, ['date' => \Illuminate\Support\Carbon::createFromDate($year, $month, $i), 'value1' => $t_reservation, 'value2' => $t_cash_value, 'value3' => $t_card_value, 'value4' => $t_advance_value]);

            } elseif ($flag == 'Not found') {
                array_push($readable, ['date' => \Illuminate\Support\Carbon::createFromDate($year, $month, $i), 'value1' => 0, 'value2' => 0, 'value3' => 0, 'value4' => 0]);
            }

        }
        return response()->json(['readable' => $readable, 'total_reservation_count' => $total_reservation_count,'total_advance_count' => $total_advance_count, 'total_card_count' => $total_card_count, 'total_cash_count' => $total_cash_count]);
    }
    public function dashboard_cost_chart_render(Request $request)
    {

        $selected_date_sale = $request->input('selected_date_cost');
        $d_m_obj_start = new Carbon($selected_date_sale);
        $d_m_obj_end = new Carbon($selected_date_sale);

        $start_month = $d_m_obj_start->startOfMonth();
        $end_month = $d_m_obj_end->endOfMonth();

        $year = \Illuminate\Support\Carbon::now()->year;
        $month = Carbon::now()->month;
        $daysCount = $start_month->daysInMonth;
        $Cost_Total = Goods_received_note::whereBetween('date', [$start_month, $end_month])
            ->where('hotel_id', auth()->user()->hotel_id)
            ->selectRaw('DAYOFMONTH(date) monthDay, SUM( total) total_cost')
            ->groupBy('monthDay')
            ->get();
        //return $Cost_Total;
        $readable = array();
        $total_sale_count = 0;
        for ($i = 1; $i <= $daysCount; $i++) {
            $flag = 'Not found';
            foreach ($Cost_Total as $total_cost_data) {
                if ($total_cost_data->monthDay == $i) {
                    array_push($readable, ['country' => $total_cost_data->monthDay, 'visits' => $total_cost_data->total_cost]);
                    $flag = 'Found';
                    $total_sale_count = $total_sale_count + $total_cost_data->total_cost;
                }
            }
            if ($flag == 'Not found') {
                array_push($readable, ['country' => $i, 'visits' => 0]);
            }
        }
        //return $total_sale_count;
        return response()->json(['readable' => $readable, 'total_sale_count' => $total_sale_count]);
    }
//    public function dashboard_chart_render(){
//        $CostData=Goods_received_note::selectRaw('MONTHNAME(date) as monthname, SUM(total) total_cost')->
//        where('hotel_id' ,auth()->user()->hotel_id)
//            ->whereYear('date', date('Y'))
//            ->groupBy('monthname')
//            ->get();
//        $Sale_Total=Order_list::selectRaw('MONTHNAME(created_at) as monthname, SUM(total) total_sale,SUM(service_charge) total_service_charge')->
//        where('hotel_id' ,auth()->user()->hotel_id)
//            ->whereYear('created_at', date('Y'))
//            ->groupBy('monthname')
//            ->get();
//
//        $readable = array();
//        $months =array('January','February','March','April','May','June','July','August','September','October','November','December');
//        foreach($months as $month){
//            $sale_total = 0;
//            $cost_total= 0;
//            $profit= 0;
//            $service_charge= 0;
//            foreach ($CostData as $total_cost_data){
//                if ($total_cost_data->monthname == $month) {
//                    $cost_total = $total_cost_data->total_cost;
//                }
//            } foreach ($Sale_Total as $total_sale_data){
//                if ($total_sale_data->monthname == $month) {
//                    $sale_total = $total_sale_data->total_sale;
//                    $service_charge = $total_sale_data->total_service_charge;
//                }
//            }
//            $profit = $sale_total-$cost_total;
//            array_push($readable,['year' => $month , 'europe' =>$sale_total ,'namerica' =>$cost_total ,'asia' =>$profit,'lamerica' =>$service_charge]);
//        }
//        //return $CostData;
//        return response()->json(['readable'=>$readable]);
//    }
    public function grn_add()
    {
        $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();
        if (auth()->user()->role == 'Admin') {
            $cash_books = Cashbook::where('hotel_id', auth()->user()->hotel_id)->get();

        } elseif (auth()->user()->role == 'Staff') {

            $assing_cashbook_ids = Assigned_cash_book::select('cashbook_id')->where('user_id', auth()->user()->id)->get()->pluck('cashbook_id');
            $cash_books = Cashbook::whereIn('id', $assing_cashbook_ids)->get();
        }
        return view('hotel.grn_add', ['items' => $items, 'cash_books' => $cash_books]);
    }

    public function grn_view()
    {
        $grn_list = Goods_received_note::with('goods_received_note_detail', 'user' , 'supplier_details')->where('hotel_id', auth()->user()->hotel_id)->get();
        $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();
        if (auth()->user()->role == 'Admin') {
            $cash_books = Cashbook::where('hotel_id', auth()->user()->hotel_id)->get();

        } elseif (auth()->user()->role == 'Staff') {

            $assing_cashbook_ids = Assigned_cash_book::select('cashbook_id')->where('user_id', auth()->user()->id)->get()->pluck('cashbook_id');
            $cash_books = Cashbook::whereIn('id', $assing_cashbook_ids)->get();
        }
        return view('hotel.grn_view', ['grn_list' => $grn_list, 'items' => $items, 'cash_books' => $cash_books]);
    }

    public function get_grn_details(Request $request)
    {
        $grn_id = $request->input('grn_id');
        $items = Item::all();
        $grn_list = Goods_received_note::with('goods_received_note_detail.item', 'user', 'supplier_details')->where('id', $grn_id)->first();

        $cash_book_log = Cash_book_log_activity::where('grn_id', $grn_id)->where('status', 'Active')->first();

        return response()->json(['grn_list' => $grn_list, 'items' => $items, 'cash_book_log' => $cash_book_log]);
    }

    public function grn_save(Request $request)
    {
        $date = $request->input('date');
        $grn = new Goods_received_note();
        $grn->date = $date;
        $grn->supplier = $request->input('supplier');
        $grn->payment_method = $request->input('payment_method');

        $remark = $request->input('remark');
        $grn->remark = $remark;

        $grn->user_id = Auth::id();
        $grn->hotel_id = auth()->user()->hotel_id;
        //        $grn->user_id =1;
        if ($image = $request->file('receipt_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/receipt_image/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $grn->image = $path;
        }
        $grn->save();
        $total = 0;
        $count = $request->input('count');
        for ($i = 1; $i <= $count; $i++) {
            $grn_quantity = $request->input('Quantity-' . $i);
            $grn_price = $request->input('Price-' . $i);
            $grn_item_id = $request->input('item-' . $i);
            if ($grn_quantity != "" && $grn_price != "" && $grn_item_id != "") {
                $grn_dt = new Goods_received_note_detail();
                $grn_dt->quantity = $grn_quantity;
                $grn_dt->price = $grn_price;
                $total = $total + $grn_price;
                $grn_dt->item_id = $grn_item_id;
                $grn_dt->goods_received_note_id = $grn->id;
                $grn_dt->save();
                $item = Item::find($grn_dt->item_id);
                $item->quantity = $item->quantity + $grn_dt->quantity;
                $item->unit_price = $grn_dt->price / $grn_dt->quantity;
                $item->unit_price = number_format((float)$item->unit_price, 2, '.', '');
                $item->save();
                \LogActivity::addToLog('Add GRN', $date, 'GRN', $grn->id, null, null, $grn_dt->quantity, null, $item->quantity, Auth::id(), 'add using GRN Add Item', $item->id);
            }

        }
        $grn->total = $total;

        if ($remark == 'Unpaid') {
            $grn->paid_cost = 0;
            $grn->balance = $total;
            $grn->status = 'Pending Amount';
        }
        else if($remark == 'Paid'){
            $grn->paid_cost = $total;
            $grn->balance = 0;
            $grn->status = 'Paid';
        }

        $grn->save();

        $cashbookid=$request->input('cash_book_id');
        if ($remark == 'Half Payment') {
            return redirect()->route('hotel/grn/save_supplier_payment', ['id'=>$grn->id,'cashbook_id'=>$cashbookid]);
        }
        else{
            $payment = new Supplier_payment();
            $payment->date = date('Y-m-d');
            $payment->grn_id = $grn->id;
            $payment->total_amount = $total;
            $payment->supplier_id = $grn->supplier;
            $payment->hotel_id = auth()->user()->hotel_id;

            $supplier = Supplier::find($grn->supplier);
            $supplier_total_amount = $supplier->total_amount;
            $supplier_paid_amount = $supplier->paid_amount;

            if ($remark == 'Unpaid') {
                $payment->paid_amount = 0;
                $payment->balance = $total;

                $supplier->total_amount = $supplier_total_amount+$total;
                $supplier->paid_amount = $supplier_paid_amount+0;
                if ($supplier_total_amount+$total == $supplier_paid_amount+0) {
                    $supplier->paid_status = 'Paid';
                } else {
                    $supplier->paid_status = 'Pending Amount';
                }

            }
            else if($remark == 'Paid'){

                $cash_book_id = $request->input('cash_book_id');
                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Credited By Grn' . ' ' . '(' . $grn->id . ')';

                $cash_book_log = new Cash_book_log_activity();
                $cash_book_log->cashbook_id = $cash_book_id;
                $cash_book_log->hotel_id = auth()->user()->hotel_id;
                $cash_book_log->credit = $grn->total;
                $cash_book_log->date = $date;
                $cash_book_log->user_id = auth()->user()->id;
                $cash_book_log->grn_id = $grn->id;
                $cash_book_log->remark = $remark;
                $cash_book_log->status = 'Active';
                $cash_book_log->save();
                \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Credit');

                $payment->paid_amount = $total;
                $payment->balance = 0;
                $payment->cashbook_id = $cash_book_log->id;

                $supplier->total_amount = $supplier_total_amount+$total;
                $supplier->paid_amount = $supplier_paid_amount+$total;
                if ($supplier_total_amount+$total == $supplier_paid_amount+$total) {
                    $supplier->paid_status = 'Paid';
                } else {
                    $supplier->paid_status = 'Pending Amount';
                }
            }
            $payment->save();

            $supplier->save();


            return redirect()->route('hotel/grn/view');
            return redirect()->back()->with('success');

        }

//        return view('hotel.supplier_payment', ['grn' => $grn]);
//
//        return redirect()->route('hotel/grn/save_supplier_payment');
//        return redirect()->route('hotel/grn/save_supplier_payment', ['id'=>$grn->id]);
//        return redirect()->back()->with('success');
    }

    public function save_supplier_payment(Request $request)
    {
        $grn_id = $request->input('id');
        $cashbook_id = $request->input('cashbook_id');
        $grn = Goods_received_note::find($grn_id);


        return view('hotel.supplier_payment', ['grn' => $grn,'cashbook_id' => $cashbook_id]);
    }

    public function grn_update(Request $request)
    {

        $grn_id = $request->input('grn-id');
        $date = $request->input('date');
        $remark = $request->input('remark');

        $grn = Goods_received_note::find($grn_id);
        $grn_Remark = $grn->remark;
        $grn_supplier = $grn->supplier;

         $other_income_id = $request->input('other_income');
         $other_income = Other_income_payment::find($other_income_id);
          $other_income_total = $other_income->paid_amount;

        $supplier = Supplier::find($grn_supplier);
        $supplier_total_old = $supplier->total_amount;
        $supplier_paid_old = $supplier->paid_amount;

        $supplier_total_new = $supplier_total_old-$grn->total;
        $supplier_paid_new = $supplier_paid_old-$grn->paid_cost;

        if ($supplier_total_new == $supplier_paid_new) {
            $supplier->paid_status = 'Paid';
        } else {
            $supplier->paid_status = 'Pending Amount';
        }
        $supplier->total_amount=$supplier_total_new;
        $supplier->paid_amount=$supplier_paid_new;
        $supplier->save();

        $supplierpayment = Supplier_payment::where('grn_id',$grn_id)->where('supplier_id',$grn_supplier)->orderBy('id', 'ASC')->first();


        $grn->date = $date;
        $grn->supplier = $request->input('supplier');
        $grn->payment_method = $request->input('payment_method');
        $grn->remark = $remark;
        $grn->user_id = Auth::id();
        if ($image = $request->file('receipt_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/receipt_image/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $grn->image = $path;
        }
        $grn->save();
        $total = 0;
        $count = $request->input('count');
        $grn_dt_ids = array();

        for ($i = 1; $i <= $count; $i++) {
            $grn_quantity = $request->input('Quantity-' . $i);
            $grn_price = $request->input('Price-' . $i);
            $grn_item_id = $request->input('item-' . $i);
            if ($grn_quantity != "" && $grn_price != "" && $grn_item_id != "") {
                $grn_dt_id = $request->input('grn-details-id-' . $i);
                $item = Item::find($grn_item_id);
                if ($grn_dt_id == 'new') {
                    $grn_dt = new Goods_received_note_detail();
                    \LogActivity::addToLog('Add GRN', $date, 'GRN', $grn->id, null, null, $grn_quantity, null, $item->quantity + $grn_quantity, Auth::id(), 'add using GRN edit item', $item->id);

                } else {
                    $grn_dt = Goods_received_note_detail::find($grn_dt_id);
                    $item->quantity = $item->quantity - $grn_dt->quantity;
                    $item->save();
                    if ($grn_dt->quantity > $grn_quantity) {
                        \LogActivity::addToLog('Edit GRN', $date, 'GRN', $grn->id, null, null, null, $grn_dt->quantity - $grn_quantity, $item->quantity + $grn_quantity, Auth::id(), 'change ' . $grn_dt->quantity . $item->unit . ' to ' . $grn_quantity . $item->unit . ' using GRN edit item', $grn_dt->item_id);
                    } elseif ($grn_dt->quantity < $grn_quantity) {
                        \LogActivity::addToLog('Edit GRN', $date, 'GRN', $grn->id, null, null, $grn_quantity - $grn_dt->quantity, null, $item->quantity + $grn_quantity, Auth::id(), 'change ' . $grn_dt->quantity . $item->unit . ' to ' . $grn_quantity . $item->unit . ' using GRN edit item', $grn_dt->item_id);
                    }
                }
                $grn_dt->quantity = $grn_quantity;
                $grn_dt->price = $grn_price;
                $total = $total + $grn_price;
                $grn_dt->item_id = $grn_item_id;
                $grn_dt->goods_received_note_id = $grn->id;
                $grn_dt->save();
                $item->quantity = $item->quantity + $grn_dt->quantity;
                $item->unit_price = $grn_dt->price / $grn_dt->quantity;
                $item->unit_price = number_format((float)$item->unit_price, 2, '.', '');
                $item->save();

                array_push($grn_dt_ids, $grn_dt->id);

            }

        }
        $grn_dt_delete_rows = Goods_received_note_detail::where('goods_received_note_id', $grn_id)->whereNotIn('id', $grn_dt_ids)->get();
        foreach ($grn_dt_delete_rows as $grn_dt_delete_row) {
            $item = Item::find($grn_dt_delete_row->item_id);
            $item->quantity = $item->quantity - $grn_dt_delete_row->quantity;
            $item->save();
            \LogActivity::addToLog('Delete GRN', $date, 'GRN', $grn->id, null, null, null, $grn_dt_delete_row->quantity, $item->quantity, Auth::id(), 'Remove ' . $grn_dt_delete_row->quantity . $item->unit . ' using GRN edit item', $grn_dt_delete_row->item_id);
        }
        $grn_dt_delete_rows2 = Goods_received_note_detail::where('goods_received_note_id', $grn_id)->whereNotIn('id', $grn_dt_ids)->delete();

        $grn->total = $total;
        $grn->save();


        $grn_list = Goods_received_note::with('goods_received_note_detail.item', 'user' , 'supplier_details')->where('id', $grn->id)->first();


        $cash_book_id = $request->input('e_cash_book_id');
        $old_cashbook_id = Cash_book_log_activity::where('grn_id', $grn_id)->where('status', 'Active')->first();

        $supplierpayment->total_amount=$total;

        if ($remark == 'Paid') {
            $grn->paid_cost = $total;
            $grn->balance = 0;
            $grn->status = 'Paid';

            $supplierpayment->paid_amount=$total;
            $supplierpayment->balance=0;

            $supplier->total_amount=$supplier_total_new+$total;
            $supplier->paid_amount=$supplier_paid_new+$total;
            if ($supplier_total_new+$total == $supplier_paid_new+$total) {
                $supplier->paid_status = 'Paid';
            } else {
                $supplier->paid_status = 'Pending Amount';
            }

            if ($old_cashbook_id != null) {
                $date_record = new Carbon($old_cashbook_id->date);
                $this_month = Carbon::now()->startOfMonth();
                $date_record2 = new Carbon($old_cashbook_id->date);
                $date_record3 = $date_record2->startOfMonth();
                $cash_book_date = $date_record->startOfMonth()->addMonth();
                $cash_book_monthly = Cashbook_monthly_record::where('date', $cash_book_date)->where('cashbook_id', $old_cashbook_id->cashbook_id)->first();
                if ($old_cashbook_id->cashbook_id == $cash_book_id) {
                    if ($old_cashbook_id->date == $date) {
                        if ($date_record3 != $this_month) {
                            $cash_book_monthly->total_credit = $cash_book_monthly->total_credit - $old_cashbook_id->credit;
                            $cash_book_monthly->balance = $cash_book_monthly->balance + $old_cashbook_id->credit;
                            $cash_book_monthly->save();
                        }
                        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Credit Amount GRN' . ' ' . '(' . $grn->id . ')';
                        $old_cashbook_id->credit = $grn->total;
                        $old_cashbook_id->remark = $remark;
                        $old_cashbook_id->save();
                        \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                    } else {
                        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Date/Amount Credit GRN' . ' ' . '(' . $grn->id . ')';
                        \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
                        $old_cashbook_id->credit = $grn->total;
                        $old_cashbook_id->remark = $remark;
                        $old_cashbook_id->date = $date;
                        $old_cashbook_id->save();
                        \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                    }
                } else {
                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change CashBook in GRN' . ' ' . '(' . $grn->id . ')';
                    $old_cashbook_id->credit = $grn->total;
                    $old_cashbook_id->remark = $remark;
                    $old_cashbook_id->date = $date;
                    $old_cashbook_id->cashbook_id = $cash_book_id;
                    $old_cashbook_id->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                }
            } else {
                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change CashBook in GRN' . ' ' . '(' . $grn->id . ')';
                $new_cash_book_log = new Cash_book_log_activity();
                $new_cash_book_log->cashbook_id = $cash_book_id;
                $new_cash_book_log->hotel_id = auth()->user()->hotel_id;
                $new_cash_book_log->credit = $grn->total;
                $new_cash_book_log->status = 'Active';
                $new_cash_book_log->date = $date;
                $new_cash_book_log->user_id = auth()->user()->id;
                $new_cash_book_log->grn_id = $grn->id;
                $new_cash_book_log->remark = $remark;
                $new_cash_book_log->save();
                \Cashbook_monthly_record_sync::sync_cash_log($new_cash_book_log, 'Credit');

                $supplierpayment->cashbook_id=$new_cash_book_log->id;
            }


        }
        else if($remark == 'Unpaid'){
            $grn->paid_cost = 0;
            $grn->balance = $total;
            $grn->status = 'Pending Amount';

            $supplierpayment->paid_amount=0;
            $supplierpayment->balance=$total;

            $supplier->total_amount=$supplier_total_new+$total;
            $supplier->paid_amount=$supplier_paid_new;
            if ($supplier_total_new+$total == $supplier_paid_new) {
                $supplier->paid_status = 'Paid';
            } else {
                $supplier->paid_status = 'Pending Amount';
            }
        }
        else{

            $paid_amount = null;
            $balance = null;

            if($request->input('paid_amount') == null){
                $paid_amount = 0;
            }
            else{
                $paid_amount = $request->input('paid_amount');
            }

            if($request->input('balance') == null){
                $balance = $total;
            }
            else{
                $balance = $request->input('balance');
            }

            $supplierpayment->paid_amount=$paid_amount;
            $supplierpayment->balance=$balance;

            $grn->paid_cost = $paid_amount;
            $grn->balance = $balance;
            $grn->status = 'Half Payment';

            $supplier->total_amount=$supplier_total_new+$total;
            $supplier->paid_amount=$supplier_paid_new+$paid_amount;
            if ($supplier_total_new+$total == $supplier_paid_new+$paid_amount) {
                $supplier->paid_status = 'Paid';
            } else {
                $supplier->paid_status = 'Pending Amount';
            }

            if ($old_cashbook_id != null) {
                $date_record = new Carbon($old_cashbook_id->date);
                $this_month = Carbon::now()->startOfMonth();
                $date_record2 = new Carbon($old_cashbook_id->date);
                $date_record3 = $date_record2->startOfMonth();
                $cash_book_date = $date_record->startOfMonth()->addMonth();
                $cash_book_monthly = Cashbook_monthly_record::where('date', $cash_book_date)->where('cashbook_id', $old_cashbook_id->cashbook_id)->first();
                if ($old_cashbook_id->cashbook_id == $cash_book_id) {
                    if ($old_cashbook_id->date == $date) {
                        if ($date_record3 != $this_month) {
                            $cash_book_monthly->total_credit = $cash_book_monthly->total_credit - $old_cashbook_id->credit;
                            $cash_book_monthly->balance = $cash_book_monthly->balance + $old_cashbook_id->credit;
                            $cash_book_monthly->save();
                        }
                        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Credit Amount GRN' . ' ' . '(' . $grn->id . ')';
                        $old_cashbook_id->credit = $paid_amount;
                        $old_cashbook_id->remark = $remark;
                        $old_cashbook_id->save();
                        \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                    } else {
                        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Date/Amount Credit GRN' . ' ' . '(' . $grn->id . ')';
                        \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
                        $old_cashbook_id->credit = $paid_amount;
                        $old_cashbook_id->remark = $remark;
                        $old_cashbook_id->date = $date;
                        $old_cashbook_id->save();
                        \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                    }
                } else {
                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change CashBook in GRN' . ' ' . '(' . $grn->id . ')';
                    $old_cashbook_id->credit = $paid_amount;
                    $old_cashbook_id->remark = $remark;
                    $old_cashbook_id->date = $date;
                    $old_cashbook_id->cashbook_id = $cash_book_id;
                    $old_cashbook_id->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                }
            } else {
                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change CashBook in GRN' . ' ' . '(' . $grn->id . ')';
                $new_cash_book_log = new Cash_book_log_activity();
                $new_cash_book_log->cashbook_id = $cash_book_id;
                $new_cash_book_log->hotel_id = auth()->user()->hotel_id;
                $new_cash_book_log->credit = $paid_amount;
                $new_cash_book_log->status = 'Active';
                $new_cash_book_log->date = $date;
                $new_cash_book_log->user_id = auth()->user()->id;
                $new_cash_book_log->grn_id = $grn->id;
                $new_cash_book_log->remark = $remark;
                $new_cash_book_log->save();
                \Cashbook_monthly_record_sync::sync_cash_log($new_cash_book_log, 'Credit');

                $supplierpayment->cashbook_id=$new_cash_book_log->id;
            }
        }

        $supplierpayment->save();
        $grn->save();
        $supplier->save();



//        if ($old_cashbook_id != null) {
//            $date_record = new Carbon($old_cashbook_id->date);
//            $this_month = Carbon::now()->startOfMonth();
//            $date_record2 = new Carbon($old_cashbook_id->date);
//            $date_record3 = $date_record2->startOfMonth();
//            $cash_book_date = $date_record->startOfMonth()->addMonth();
//            $cash_book_monthly = Cashbook_monthly_record::where('date', $cash_book_date)->where('cashbook_id', $old_cashbook_id->cashbook_id)->first();
//            if ($old_cashbook_id->cashbook_id == $cash_book_id) {
//                if ($old_cashbook_id->date == $date) {
//                    if ($date_record3 != $this_month) {
//                        $cash_book_monthly->total_credit = $cash_book_monthly->total_credit - $old_cashbook_id->credit;
//                        $cash_book_monthly->balance = $cash_book_monthly->balance + $old_cashbook_id->credit;
//                        $cash_book_monthly->save();
//                    }
//                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Credit Amount GRN' . ' ' . '(' . $grn->id . ')';
//                    $old_cashbook_id->credit = $grn->total;
//                    $old_cashbook_id->remark = $remark;
//                    $old_cashbook_id->save();
//                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
//                } else {
//                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Date/Amount Credit GRN' . ' ' . '(' . $grn->id . ')';
//                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
//                    $old_cashbook_id->credit = $grn->total;
//                    $old_cashbook_id->remark = $remark;
//                    $old_cashbook_id->date = $date;
//                    $old_cashbook_id->save();
//                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
//                }
//            } else {
//                \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
//                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change CashBook in GRN' . ' ' . '(' . $grn->id . ')';
//                $old_cashbook_id->credit = $grn->total;
//                $old_cashbook_id->remark = $remark;
//                $old_cashbook_id->date = $date;
//                $old_cashbook_id->cashbook_id = $cash_book_id;
//                $old_cashbook_id->save();
//                \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
//            }
//        } else {
//            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change CashBook in GRN' . ' ' . '(' . $grn->id . ')';
//            $new_cash_book_log = new Cash_book_log_activity();
//            $new_cash_book_log->cashbook_id = $cash_book_id;
//            $new_cash_book_log->hotel_id = auth()->user()->hotel_id;
//            $new_cash_book_log->credit = $grn->total;
//            $new_cash_book_log->status = 'Active';
//            $new_cash_book_log->date = $date;
//            $new_cash_book_log->user_id = auth()->user()->id;
//            $new_cash_book_log->grn_id = $grn->id;
//            $new_cash_book_log->remark = $remark;
//            $new_cash_book_log->save();
//            \Cashbook_monthly_record_sync::sync_cash_log($new_cash_book_log, 'Credit');
//        }

        return response()->json(['success' => 'success', 'grn' => $grn_list]);
    }

    public function pos_view()
    {
        $restaurant = Restaurant::with('hotel.hotel_chain')->where('hotel_id', auth()->user()->hotel_id)->where('status', 'Active')->first();
        $menu_ids = Restaurant_menu::select('menu_id')->where('restaurant_id', $restaurant->id)->get()->pluck('menu_id');
        $items = Menu::where('hotel_id', auth()->user()->hotel_id)->where('type', 'Visible')->whereIn('id', $menu_ids)->get();
        $cash_books = Cashbook::all();


        $recipeCategoriesWithMenus = DB::table('recipe_categories')
            ->where('hotel_id',auth()->user()->hotel_id)
            ->join('menu_category_details', 'recipe_categories.id', '=', 'menu_category_details.recipe_category_id')
            ->select('recipe_categories.id as category_id', 'menu_category_details.menu_id')
            ->get()
            ->groupBy('category_id')
            ->map(function ($items) {
                return $items->pluck('menu_id');
            })
            ->toArray();

        $currentDate = date('Y-m-d');

        $reservations = Reservation::with(['reservation_rooms.room'])->where('check_in_date', '<=', $currentDate)->where('check_out_date', '>=', $currentDate)->get();

        $reservationsWithRoomNumbers = $reservations->map(function ($reservation) {
            $roomNumbers = $reservation->reservation_rooms->pluck('room.room_number')->toArray();
            return [
                'id' => $reservation->id,
                'first_name' => $reservation->first_name,
                'last_name' => $reservation->last_name,
                'check_in_date' => $reservation->check_in_date,
                'check_out_date' => $reservation->check_out_date,
                'room_numbers' => $roomNumbers,
            ];
        });
        $tables = Table::where('hotel_id', auth()->user()->hotel_id)->where('status', null)->get();

//return  $reservationsWithRoomNumbers;

        return view('pos.pos', ['items' => $items, 'restaurant' => $restaurant, 'cash_books' => $cash_books, 'customers' => $reservationsWithRoomNumbers,'recipeCategoriesWithMenus'=>$recipeCategoriesWithMenus,'tables'=>$tables]);
    }

    public function try_add_to_cart(Request $request)
    {
        $menu_id = $request->input('menu_id');
        $menu = Menu::with('combo.combo_item.menu.recipe')->find($menu_id);

        // Get current date and time using Carbon
        $currentTime = Carbon::now('Asia/Colombo');

        // Set time to start of day (00:00:00)
        $currentDay = $currentTime->copy()->startOfDay(); // This sets the time to 00:00:00

        // Get the original current time with actual time
        $currentTimeString = $currentTime->toTimeString(); // Current time in H:i:s format

        // Find a promotion for the menu item for today and current time
        $promotion = Promotion::where('menu_id', $menu_id)
            ->whereDate('date', $currentDay)
            ->whereTime('start_time', '<=', $currentTimeString)
            ->whereTime('end_time', '>=', $currentTimeString)
            ->first();

        if ($promotion) {
            // Apply the promotion
            $discountedPrice = $menu->price * (1 - ($promotion->percentage / 100));
            $menu->price = $discountedPrice;
        }

        // Render the view
        $output = view('pos.render_for_ajax.try_add_to_cart', ['menu' => $menu])->render();

        return response()->json(['output' => $output, 'menu' => $menu]);
    }



    public function place_order(Request $request)
    {
        $items_encoded = $request->input('order');
//        Log::info($items_encoded);
        $items = json_decode($items_encoded, 1);
//        return $items;
        $order_list_detail_ids = array();
        if ($items['order_id'] == 'new') {
            $order_list = new Order_list();
        } else {
            $order_list = Order_list::find($items['order_id']);
        }
//        $order_list->type = 'Take away';
        $order_list->type = $request->input('order_type');
        $order_list->status = 'Processing';
//        $order_list->customer_name = 'Walk-in Customer';
        if ($request->input('customer') != 'Walk-in Customer') {
            $order_list->reservation_id = $request->input('customer');
        }
        if ($request->input('room') != 'Walk-in Customer') {
            $order_list->room_id = $request->input('room');
        }
        $order_list->service_charge = $request->input('serchg');
        $order_list->item_count = $items['item_count'];
        $order_list->sub_total = $items['total'];
        $order_list->total = $items['total'] + $request->input('serchg');
        $order_list->restaurant_id = $request->input('restaurant_id');
        $order_list->hotel_id = auth()->user()->hotel_id;
        $order_list->user_id = auth()->user()->id;
        $order_list->table_id = $items['order_table'];
        $order_list->steward_id = $request->input('steward');
        $order_list->save();


        foreach ($items['cart-items'] as $cart_item_name) {
            if ($items[$cart_item_name]['row_id'] == 'new') {
                $order_list_detail = new Order_list_detail();
            } else {
                $order_list_detail = Order_list_detail::find($items[$cart_item_name]['row_id']);
            }
            $order_list_detail->recipe_name = $items[$cart_item_name]['name'];
            $order_list_detail->price = $items[$cart_item_name]['price'];
            $order_list_detail->quantity = $items[$cart_item_name]['qty'];
            $order_list_detail->discount = $items[$cart_item_name]['discount'];
            $order_list_detail->total = $items[$cart_item_name]['total'];
            $order_list_detail->order_list_id = $order_list->id;
            $order_list_detail->recipe_note_id = $items[$cart_item_name]['resipe_id'];
            $order_list_detail->como_items_list = json_encode($items[$cart_item_name]['order_menus']);
            $order_list_detail->save();
            array_push($order_list_detail_ids, $order_list_detail->id);

        }
        $order_list_detail_delete_rows = Order_list_detail::where('order_list_id', $order_list->id)->whereNotIn('id', $order_list_detail_ids)->delete();
        $orders = Order_list::with('room', 'reservation')->find($order_list->id);
        if($orders->table_id != null){
            $tables = Table::where('hotel_id', auth()->user()->hotel_id)->where('status', null)->where('id', $orders->table_id)->first();
        }
        else{
            $tables = 'null';
        }
        $restaurant = Restaurant::with('hotel.hotel_chain')->where('hotel_id', auth()->user()->hotel_id)->where('status', 'Active')->first();
        $orders_render = Order_list::with('room','reservation','user')->where('status','Processing')->where('hotel_id',auth()->user()->hotel_id)->where('restaurant_id',$restaurant->id)->get();
        $output = view('pos.render_for_ajax.table_view', ['table' => $tables , 'orders' => $orders_render])->render();
        $order_count = Order_list::where('table_id',$orders->table_id)->where('status','Processing')->count();
        return response()->json(['items' => $items['cart-items'], 'order_list' => $orders ,'output' => $output, 'order_count' => $order_count]);
//        return response()->json(['items' => $items['cart-items'], 'order_list' => $orders , 'order_count' => $order_count]);
    }

    public function finalize_order(Request $request)
    {
        $order_list = Order_list::find($request->input('order_id'));
        $order_list->status = 'Complete';
        $order_list->paid_amount = $request->input('payment_method') == "Pay later" ? 0.00 : $request->input('paid-amount');
        $order_list->given_amount = $request->input('give-amount');
        $order_list->change_amount = $request->input('change-amount');
        $order_list->due_amount = 0.00;
//        $order_list->finalize_date = Carbon::now();
        $order_list->finalize_date = $request->input('order_date');
        $order_list->hotel_id = auth()->user()->hotel_id;
        $order_list->payment_method = $request->input('payment_method');
        $order_list->save();

        if ($order_list->payment_method == 'Cash' or $order_list->payment_method == 'Card') {
            $resturant_payment_cashbook = Restaurant::find($order_list->restaurant_id);
            if ($order_list->payment_method == 'Cash' and $resturant_payment_cashbook->cash_payment != null) {
                $cashbook_id = $resturant_payment_cashbook->cash_payment;
                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit (Sale)' . ' ' . $order_list->paid_amount . ' ' . 'Order ID ' . $order_list->id;
                $cash_debit = new Cash_book_log_activity();
                $cash_debit->cashbook_id = $cashbook_id;
                $cash_debit->hotel_id = auth()->user()->hotel_id;
                $cash_debit->debit = $order_list->paid_amount;
                $cash_debit->status = 'Active';
                $cash_debit->date = $order_list->finalize_date;
                $cash_debit->user_id = auth()->user()->id;
                $cash_debit->remark = $remark;
                $cash_debit->order_id = $order_list->id;
                $cash_debit->save();
                \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
            } elseif ($order_list->payment_method == 'Card' and $resturant_payment_cashbook->card_payment != null) {
                $cashbook_id = $resturant_payment_cashbook->card_payment;
                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit (Sale)' . ' ' . $order_list->paid_amount . ' ' . 'Order ID ' . $order_list->id;
                $cash_debit = new Cash_book_log_activity();
                $cash_debit->cashbook_id = $cashbook_id;
                $cash_debit->hotel_id = auth()->user()->hotel_id;
                $cash_debit->debit = $order_list->paid_amount;
                $cash_debit->status = 'Active';
                $cash_debit->date = $order_list->finalize_date;
                $cash_debit->user_id = auth()->user()->id;
                $cash_debit->remark = $remark;
                $cash_debit->order_id = $order_list->id;
                $cash_debit->save();
                \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
            }

        }

//        $recipes_arr = array();
        $Order_list_details = Order_list_detail::where('order_list_id', $order_list->id)->get();
        Log::info(PHP_EOL);
        foreach ($Order_list_details as $order_item) {
            $recipes_arr = array();
            $como_items_lists = json_decode($order_item->como_items_list);
//            Log::info( $order_item->como_items_list);
            foreach ($como_items_lists as $como_items_list) {
                $menu = Menu::with('combo.combo_item.menu')->find($como_items_list->menu_id);
                if ($menu->recipe_id != null) {
                    array_push($recipes_arr, ['recipe_id' => $menu->recipe_id, 'qty' => ($como_items_list->qty * $order_item->quantity)]);

                } else {
//                Log::notice(json_encode($como_items_list));
                    foreach ($menu->combo as $combo) {
                        foreach ($combo->combo_item as $combo_item) {
                            if ($combo_item->menu->recipe_id != null) {
                                array_push($recipes_arr, ['recipe_id' => $combo_item->menu->recipe_id, 'qty' => ($como_items_list->qty * $order_item->quantity * $combo_item->quantity)]);
                            } else {
                                $menu_2 = \App\Menu::with('combo.combo_item.menu')->find($combo_item->menu->id);
//                            Log::info(json_encode('$menu_2'));
//                            Log::info(json_encode($menu_2));
                                foreach ($menu_2->combo as $combo_2) {
                                    array_push($recipes_arr, ['recipe_id' => $combo_2->combo_item[0]->menu->recipe_id, 'qty' => ($como_items_list->qty * $order_item->quantity * $combo_item->quantity)]);
                                }
                            }
                        }
                    }

                }


            }
            /*
             * find recipe items and deduct stock
             */
//            Log::info('Quantity check');
            Log::info(json_encode($recipes_arr));

            foreach ($recipes_arr as $recipes_q) {
                $recipe_items = Recipe_item::where('recipe_id', $recipes_q['recipe_id'])->get();
//                  Log::info(json_encode($recipe_items));
                foreach ($recipe_items as $recipi_item) {
                    $item = Item::find($recipi_item->item_id);
//                    Log::info($item->quantity - ($recipi_item->quantity * $recipes_q['qty']));
                    $item->quantity = $item->quantity - ($recipi_item->quantity * $recipes_q['qty']); //error
                    \LogActivity::addToLog('POS Sale', $order_list->finalize_date, 'SALE', null, $order_list->id, null, null, ($recipi_item->quantity * $recipes_q['qty']), $item->quantity, Auth::id(), 'for ' . $recipes_q['qty'] . ' ' . $order_item->recipe_name, $item->id);
                    $item->save();
//                    Log::info('Quantity check');
//                    Log::info(json_encode($item));
//                    Log::info(json_encode($recipi_item->quantity * $recipes_q['qty']));
//                    Log::info(json_encode($item->quantity));
                }
            }

        }
        Log::notice($recipes_arr);
//        return abort(500, 'custom error');
        $order_list->order_all_recipes = json_encode($recipes_arr);
        $order_list->save();
        return response()->json(['order_list' => $order_list]);

    }

    public function cancel_order(Request $request)
    {
        $order_list = Order_list::find($request->input('order_id'));
        $order_list->status = 'Canceled';
        $order_list->reason = $request->input('reason');
        $order_list->save();
        return response()->json(['order_list' => $order_list]);


    }

    public function open_order(Request $request)
    {
        $order_id = $request->input('order_id');
        $order = Order_list::with('order_list_detail')->find($order_id);
        return response()->json(['order_list' => $order]);

    }

    public function pos_customer_get_room(Request $request)
    {
        $reservation_id = $request->input('reservation_id');
        $room = Reservation_room::with('room')->where('reservation_id',$reservation_id)->get();
        return response()->json(['room' => $room]);

    }

    public function view_waste()
    {
        $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.waste_add', ['items' => $items]);
    }

    public function save_waste(Request $request)
    {
        $date = $request->input('date');
        $Quantity = $request->input('Quantity');
        $item = $request->input('item');

        $waste = new Wastage();
        $waste->item_id = $item;
        $waste->user_id = Auth::id();
        $waste->quantity = $Quantity;
        $waste->hotel_id = auth()->user()->hotel_id;
        $waste->date = $date;

        if ($image = $request->file('receipt_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/waste_images/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $waste->image = $path;
        }
        $waste->save();
        $change_quantity = Item::where('id', $item)->first();
        $item_quantity = $change_quantity->quantity - $Quantity;
        $change_quantity->quantity = $item_quantity;
        $change_quantity->save();
        \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $waste->id, null, $Quantity, $change_quantity->quantity, Auth::id(), 'Add wastage', $change_quantity->id);
        return redirect()->back()->with('success');
    }

    public function view_waste_list()
    {
        $wastage = Wastage::with('item', 'user')->where('hotel_id', auth()->user()->hotel_id)->get();
        $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.view_waste', ['wastage' => $wastage, 'items' => $items]);
    }

    public function waste_delete(Request $request)
    {
        $date = date('Y-m-d');
        $waste_id = $request->input('waste_id');
        $waste = Wastage::find($waste_id);
        $item_count = Item::find($waste->item_id);
        $item_count->quantity = $waste->quantity + $item_count->quantity;
        $item_count->save();
        \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $waste->id, $waste->quantity, null, $item_count->quantity, Auth::id(), 'Delete wastage', $item_count->id);
        Storage::delete($waste->image);
        $waste->delete();
        return response()->json(['success' => 'success']);
    }

    public function waste_detail_get(Request $request)
    {
        $waste_id = $request->input('waste_id');
        $waste_details = Wastage::find($waste_id);
        return response()->json(['waste_details' => $waste_details]);
    }

    public function update_waste(Request $request)
    {
        $date = $request->input('date');
        $Quantity = $request->input('Quantity');
        $item = $request->input('item');
        $waste_id = $request->input('waste_id');

        $waste = Wastage::find($waste_id);
        $old_wast_qty = $waste->quantity;

        $item_count = Item::find($waste->item_id);
        $item_count->quantity = $waste->quantity + $item_count->quantity;
        $item_count->save();

        $waste->item_id = $item;
        $waste->user_id = Auth::id();
        $waste->quantity = $Quantity;
        $waste->date = $date;

        if ($image = $request->file('waste_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/waste_images/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $waste->image = $path;
        }
        $waste->save();

        if ($item != $item_count->id) {
            \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $waste->id, $old_wast_qty, null, $item_count->quantity, Auth::id(), 'Delete wastage/change item', $item_count->id);

            $item_count = Item::find($item);

            \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $waste->id, null, $waste->quantity, ($item_count->quantity - $waste->quantity), Auth::id(), 'Add wastage/change item', $item_count->id);
        } elseif ($old_wast_qty != $Quantity) {
            if ($old_wast_qty > $Quantity) {
                \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $waste->id, $old_wast_qty - $Quantity, null, ($item_count->quantity - $waste->quantity), Auth::id(), 'change ' . $old_wast_qty . $item_count->unit . ' to ' . $Quantity . $item_count->unit . ' using wastage edit item', $item_count->id);
            } elseif ($old_wast_qty < $Quantity) {
                \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $waste->id, null, $Quantity - $old_wast_qty, ($item_count->quantity - $waste->quantity), Auth::id(), 'change ' . $old_wast_qty . $item_count->unit . ' to ' . $Quantity . $item_count->unit . ' using wastage edit item', $item_count->id);
            }
        }
        $item_count->quantity = $item_count->quantity - $waste->quantity;
        $item_count->save();


        $wastage = Wastage::with('item', 'user')->where('id', $waste_id)->first();
        return response()->json(['success' => 'success', 'wastage' => $wastage]);
    }

    //Start Repair

    public function view_repair()
    {
        // $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();
        $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();
        $room = Room::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_category = Repair_category::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_location = Other_location::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_status = Repair_status::where('hotel_id', auth()->user()->hotel_id)->get();
//        return $room;

        $maintenance = Maintenance::with('user')->where('hotel_id', auth()->user()->hotel_id)->first();
//        return $other_l;
        return view('hotel.repair_add', ['maintenance' => $maintenance , 'rooms' => $room , 'hotel' => $hotel , 'repair_location' => $repair_location , 'repair_category' => $repair_category , 'repair_status' => $repair_status]);
    }

    public function save_repair(Request $request)
    {




       // $room_id = $request->input('room_number');
        $date = $request->input('date');
        $r_category = $request->input('r_category');
        $r_location = $request->input('r_location');

        $r_status = $request->input('r_status');
        $description = $request->input('description');
        $priority = $request->input('priority');
        $repair_status = "Pending";
        $done_by = "Not yet";


        $repair = new Maintenance();
        $repair->r_category = $r_category;
        $repair->user_id = Auth::id();
        $repair->role = auth()->user()->role;
        $repair->r_location = $r_location;
        $repair->hotel_id = auth()->user()->hotel_id;
        $repair->date = $date;
        $repair->r_status = $r_status;
        $repair->done_by = $done_by;

        $repair->priority = $priority;
        $repair->description = $description;
        $repair->repair_status = $repair_status;

        if ($image = $request->file('repair_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/repair_images/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $repair->image = $path;
        }


        $repair->save();

//        \LogActivity::addToLog('Maintenance', $date, 'Maintenance', null, null, $repair->id, null, $reason,$location, Auth::id(), $person);
        return redirect()->back()->with('success', 'Successfully Add New Repair');
    }

    public function view_repair_list()
    {
        // $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();

        $maintenance = Maintenance::with('user')->where('hotel_id', auth()->user()->hotel_id)->get();
        $room = Room::where('status', null)->get();

        $repair_category = Repair_category::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_location = Other_location::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_status = Repair_status::where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.repair_view', ['maintenance' => $maintenance , 'rooms' => $room , 'repair_location' => $repair_location , 'repair_status' => $repair_status , 'repair_category' => $repair_category]);
    }

    public function repair_delete(Request $request)
    {
        $date = date('Y-m-d');
        $repair_id = $request->input('repair_id');

       $repair = Maintenance::find($repair_id);
       // \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $repair->id, $repair->reason, null, $repair->location, $repair->person, Auth::id(), 'Delete wastage');
        Storage::delete($repair->image);
        $repair->delete();
        return response()->json(['success' => 'success']);
    }

    public function update_repair(Request $request)
    {
        $date = $request->input('date');
        $r_category = $request->input('r_category');
        $r_location = $request->input('r_location');
        $repair_id = $request->input('repair_id');
        $r_status = $request->input('r_status');
        $description = $request->input('description');
        $priority = $request->input('priority');
        $repair_status = "Pending";
        $done_by = "Not yet";

        $repair = Maintenance::find($repair_id);


        $repair->user_id = Auth::id();



        $repair->date = $date;
        $repair->r_category = $r_category;
        $repair->r_location = $r_location;
        $repair->r_status = $r_status;
        $repair->done_by = $done_by;

        $repair->priority = $priority;
        $repair->description = $description;
        $repair->repair_status = $repair_status;

        if ($image = $request->file('repair_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/repair_images/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $repair->image = $path;
        }


        $repair->save();



        $maintenance = Maintenance::with('user')->where('id', $repair_id)->first();
        return response()->json(['success' => 'success', 'maintenance' => $maintenance]);
    }

    public function repair_detail_get(Request $request)
    {
        $repair_id = $request->input('repair_id');
        $repair_details = Maintenance::find($repair_id);
        return response()->json(['repair_details' => $repair_details]);
    }

    public function view_detail_repair($id)
    {
        $maintenance = Maintenance::with('user')->where('hotel_id', auth()->user()->hotel_id)->get()->find($id);
        $repair_category = Repair_category::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_location = Other_location::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_status = Repair_status::where('hotel_id', auth()->user()->hotel_id)->get();
        $room = Room::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair = Maintenance::get();
       // $waste_details = Wastage::find($waste_id);

        return view('hotel.repair_detail', ['repair' => $repair, 'maintenance' => $maintenance, 'repair_location' => $repair_location , 'repair_category' => $repair_category , 'repair_status' => $repair_status, 'rooms' => $room]);

    }

    public function save_repair_complete(Request $request)
    {

//        $r_category = $request->input('r_category');
//        $r_location = $request->input('r_location');

//        $r_status = $request->input('r_status');
//        $description = $request->input('description');
//        $priority = $request->input('priority');


        $complete_date = $request->input('complete_date');
        $repair_id = $request->input('repair_id');
        $repair_status = "Completed";
        $done_by = $request->input('done_by');

        $repair = Maintenance::find($repair_id);


//        $repair->r_category = $r_category;
//        $repair->r_location = $r_location;
//        $repair->r_status = $r_status;


//        $repair->priority = $priority;
//        $repair->description = $description;

        $repair->user_id = Auth::id();
        $repair->done_by = $done_by;
        $repair->complete_date = $complete_date;
        $repair->repair_status = $repair_status;
        $repair->role = auth()->user()->role;


        if ($complete_image = $request->file('complete_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $complete_image->getClientMimeType();
            $path = Storage::putFile('/complete_images/thumbnail', $complete_image, 'public');
            $file = Image::make($complete_image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $repair->complete_image = $path;
        }


        $repair->save();



        $maintenance = Maintenance::with('user')->where('id', $repair_id)->first();
//        return response()->json(['success' => 'success', 'maintenance' => $maintenance]);
        return view('hotel.repair_detail_complete', ['maintenance' => $maintenance]);
    }

    public function view_detail_repair_complete($id)
    {
        $maintenance = Maintenance::with('user')->where('hotel_id', auth()->user()->hotel_id)->get()->find($id);
        $repair_category = Repair_category::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_location = Other_location::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_status = Repair_status::where('hotel_id', auth()->user()->hotel_id)->get();
        $room = Room::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair = Maintenance::get();
        // $waste_details = Wastage::find($waste_id);

        return view('hotel.repair_detail_complete', ['repair' => $repair, 'maintenance' => $maintenance, 'repair_location' => $repair_location , 'repair_category' => $repair_category , 'repair_status' => $repair_status, 'rooms' => $room]);

    }

    public function view_repair_list_history()
    {
        // $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();

        $maintenance = Maintenance::with('user')->where('hotel_id', auth()->user()->hotel_id)->get();
        $room = Room::where('status', null)->where('hotel_id', auth()->user()->hotel_id)->get();

        $repair_category = Repair_category::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_location = Other_location::where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_status = Repair_status::where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.repair_view_all', ['maintenance' => $maintenance , 'rooms' => $room , 'repair_location' => $repair_location , 'repair_status' => $repair_status , 'repair_category' => $repair_category]);
    }
//end Repair

    public function view_utility()
    {
        $utility_category = Utility_category::where('hotel_id', auth()->user()->hotel_id)->get();

        return view('hotel.utility_add', ['utility_category' => $utility_category]);
    }

    public function save_utility(Request $request)
    {


        $date = $request->input('date');
        $u_category = $request->input('u_category');

        $startreading = $request->input('startreading');

        $utilityCategory = Utility_category::where('id', $u_category)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->first();


        $utility = Utility::where('u_category', $utilityCategory->utility_category_name)->where('u_category_id', $utilityCategory->id)->where('hotel_id', auth()->user()->hotel_id)->where('date', $date)->first();
        if (!$utility){
            $utility = new Utility();
        }


        $utility->u_category = $utilityCategory->utility_category_name;
        $utility->user_id = Auth::id();
        $utility->u_category_id = $utilityCategory->id;
        $utility->status ='Active';




        $utility->hotel_id = auth()->user()->hotel_id;
        $utility->date = $date;

        $utility->startreading = $startreading;

        if ($image = $request->file('utility_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/utility_images/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $utility->image = $path;
        }

        $utility->save();

//        \LogActivity::addToLog('Maintenance', $date, 'Maintenance', null, null, $repair->id, null, $reason,$location, Auth::id(), $person);
        return redirect()->back()->with('success', 'Successfully Add New Utility');
    }

    public function view_utility_list()
    {
        $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();
        $utility_category = Utility_category::where('status', 'Active')->where('hotel_id', auth()->user()->hotel_id)->get();
        $utility = Utility::with('user')->where('hotel_id', auth()->user()->hotel_id)->where('status', 'Active')->get();
        return view('hotel.utility_view', [ 'utility' => $utility , 'hotel' => $hotel , 'utility_category' => $utility_category]);
    }

    public function update_utility(Request $request)
    {
        $date = $request->input('date');
        $u_category = $request->input('u_category');

        $utility_id = $request->input('utility_id');

        $startreading = $request->input('startreading');

        $utility = Utility::find($utility_id);

        $utility->user_id = Auth::id();

        $utility->date = $date;
        $utility->u_category = $u_category;

        $utility->startreading = $startreading;

        if ($image = $request->file('utility_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/utility_images/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $utility->image = $path;
        }

        $utility->save();

        $utility = Utility::with('user')->where('id', $utility_id)->first();
        return response()->json(['success' => 'success', 'utility' => $utility]);
    }

    public function utility_detail_get(Request $request)
    {
        $utility_id = $request->input('utility_id');
        $utility_details = Utility::find($utility_id);
        return response()->json(['utility_details' => $utility_details]);
    }

    public function utility_delete(Request $request)
    {
        $date = date('Y-m-d');
        $utility_id = $request->input('utility_id');

        $utility = Utility::find($utility_id);
        // \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $repair->id, $repair->reason, null, $repair->location, $repair->person, Auth::id(), 'Delete wastage');
        Storage::delete($utility->image);

        $utility->status = 'Block';
        $utility->save();
        return response()->json(['success' => 'success']);
    }

    public function utility_summery()
    {
        $ut_categorries = Utility_category::where('status', 'Active')->where('hotel_id',auth()->user()->hotel_id)->get();
        return view('hotel.utility_summery',['ut_categorries'=>$ut_categorries]);
    }

    public function dashboard_utility_chart_render(Request $request)
    {
        $date = $request->input('date');

        $utilityCategories = Utility_category::where('hotel_id', auth()->user()->hotel_id)
            ->where('status', 'Active')
            ->get();

        $chartData = [];
        $g_countList = [];
        $total_count = array();
        $total_bill_count= array();

        $year = Carbon::parse($date)->year;
        $month = Carbon::parse($date)->month;
        $daysInMonth = Carbon::parse($date)->daysInMonth;
        $end_month = Carbon::createFromDate($year, $month, $daysInMonth);
        $prevMonthStartDay = Carbon::createFromDate($year, $month, 1)->subDay()->startOfMonth();
        $prevMonthLastDay = Carbon::createFromDate($year, $month, 1)->subDay()->endOfMonth();
        $currentDate = Carbon::now()->format('Y-m-d');

        $nextMonthStartDay = Carbon::createFromDate($year, $month, 1)->addMonth()->startOfMonth();
        $nextMonthLastDay = Carbon::createFromDate($year, $month, 1)->addMonth()->endOfMonth();


        for ($i = 1; $i <= $daysInMonth; $i++) {

            $dates_chart = Carbon::createFromDate($year, $month, $i);

            // Add the following code to filter the number of guests for the given date
            $guestsCount = Reservation::where('check_in_date', '<=', $dates_chart->format('Y-m-d'))
                ->where('check_out_date', '>', $dates_chart->format('Y-m-d'))
                ->sum('guests');
            if($currentDate<($dates_chart->format('Y-m-d'))){
                $g_countList[$i] = null;
            }
            else{
                $g_countList[$i] = $guestsCount;
            }
        }


        foreach ($utilityCategories as $utilityCategory) {

            $points = $utilityCategory->point;
            $unit_price = $utilityCategory->unit_price;
            $decimal_points = pow(10, $points);
            $range_date = $utilityCategory->range_date;
            $monthly_charj= $utilityCategory->monthly_charj;
            $utility_reading = null;
            $total_Bill = null;
            $total_BillReading = null;

            $range_date_current = \Carbon\Carbon::createFromDate($year, $month, $range_date);
            $range_date_prev = $range_date_current->copy()->subMonth();
            $date_current = \Carbon\Carbon::createFromDate($date);
            $nextMonth_range_date = Carbon::createFromDate($year, $month, $range_date)->addMonth();


//
//            if($currentDate>($range_date_current->format('Y-m-d'))){
//                $utility_unit_current_months = \App\Utility::where('status', 'Active')
//                    ->whereBetween('date', [$range_date_current->subDay(), $currentDate])
//                    ->where('u_category_id', $utilityCategory->id)
//                    ->where('hotel_id', auth()->user()->hotel_id)
//                    ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
//                    ->orderBy('date', 'ASC')
//                    ->get();
//                // \Illuminate\Support\Facades\Log::info('w1'.$utility_unit_current_months);
//                $range_date_current = \Carbon\Carbon::createFromDate($year, $month, $range_date);
//                // \Illuminate\Support\Facades\Log::info('w'.$range_date_current);
//                if (!$utility_unit_current_months->isEmpty()) {
//                    $previousRangeDate = $utility_unit_current_months->first();
//                    $lastRangeDate = $utility_unit_current_months->last();
//
//                    // \Illuminate\Support\Facades\Log::info('w' . $previousRangeDate);
//                    //  \Illuminate\Support\Facades\Log::info('w' . $lastRangeDate);
//
//                    $previousRangeDateReading = $previousRangeDate->startreading;
//                    $lastRangeDateReading = $lastRangeDate->startreading;
//
//                    if (\Carbon\Carbon::parse($previousRangeDate->date)->format('Y-m-d') !== $range_date_current->format('Y-m-d')) {
//                        $last_previous_range_readings =
//                            \App\Utility::where('status', 'Active')
//                                ->where('date', '<', $range_date_current)
//                                ->where('u_category_id', $utilityCategory->id)
//                                ->where('hotel_id', auth()->user()->hotel_id)
//                                ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
//                                ->orderBy('date', 'DESC')
//                                ->first();
//
//                        //\Illuminate\Support\Facades\Log::info('wr1' . $last_previous_range_readings);
//                        $last_previous_range_readings_Date = \Carbon\Carbon::parse($last_previous_range_readings->date);
//                        $previousRangeDatee = \Carbon\Carbon::parse($previousRangeDate->date);
//
//                        //\Illuminate\Support\Facades\Log::info('wr1' . $previousRangeDate);
//                        $differntofLP = $last_previous_range_readings_Date->diffInDays($previousRangeDatee);
//                        $differntofrl = $range_date_current->diffInDays($last_previous_range_readings_Date);
//
//                        // \Illuminate\Support\Facades\Log::info('wr1' . $differntofrl);
//                        $last_previous_range_value = $last_previous_range_readings->startreading;
//                        $previousRangevalue = $previousRangeDate->startreading;
//
//                        $previousRangeDateReading = $last_previous_range_value + ((($previousRangevalue - $last_previous_range_value) / $differntofLP) * $differntofrl);
//                        \Illuminate\Support\Facades\Log::info('wr1' . $previousRangeDateReading);
//                    } else {
//                        // Handle the case when dates match
//                        // You can add logic here if needed
//                    }
//                } else {
//                    $previousRangeDateReading = 0;
//                    $lastRangeDateReading = 0;
//                }
//
//                if ($unit_price !== null) {
//                    //   \Illuminate\Support\Facades\Log::info('B1' . $lastRangeDateReading);
//                    //  \Illuminate\Support\Facades\Log::info('Bp' . $previousRangeDateReading);
//
//                    $total_BillReading = number_format($unit_price * ($lastRangeDateReading - $previousRangeDateReading)+$monthly_charj, 2);
//
//                    //  \Illuminate\Support\Facades\Log::info('Bp3' . $total_BillReading);
//                }
//
//                array_push($total_bill_count, [
//                    'total_bill_count' => round($lastRangeDateReading - $previousRangeDateReading, 2),
//                    'category' => $utilityCategory->utility_category_name,
//                    'category_id' => $utilityCategory->id,
//                    'total_BillReading' => $total_BillReading ?? null,
//                ]);
//            }
//            else{
//
//                $utility_unit_current_months = \App\Utility::where('status', 'Active')
//                    ->whereBetween('date', [$range_date_prev->subDay(), $currentDate]) // Adjusted the range
//                    ->where('u_category_id', $utilityCategory->id)
//                    ->where('hotel_id', auth()->user()->hotel_id)
//                    ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
//                    ->orderBy('date', 'ASC')
//                    ->get();
//                if (!$utility_unit_current_months->isEmpty()) {
//                    $range_date_prev = $range_date_current->copy()->subMonth();
//                    //  \Illuminate\Support\Facades\Log::info('w2' . $utility_unit_current_months);
//                    $previousRangeDate = $utility_unit_current_months[0];
//                    $lastRangeDate = $utility_unit_current_months->last();
//                    //  \Illuminate\Support\Facades\Log::info('pE1' . $previousRangeDate);
//                    //  \Illuminate\Support\Facades\Log::info('pE2' . $lastRangeDate);
//                    $previousRangeDateReading = $previousRangeDate->startreading;
//                    $lastRangeDateReading = $lastRangeDate->startreading;
//
//                    if (\Carbon\Carbon::parse($previousRangeDate->date)->format('Y-m-d') !== $range_date_prev->format('Y-m-d')) {
//                        $last_previous_range_readings = \App\Utility::where('status', 'Active')
//                            ->where('date', '<', $range_date_prev)
//                            ->where('u_category_id', $utilityCategory->id)
//                            ->where('hotel_id', auth()->user()->hotel_id)
//                            ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
//                            ->orderBy('date', 'DESC')
//                            ->first();
//
//                        \Illuminate\Support\Facades\Log::info('rp1' . $range_date_prev );
//
//                        $last_previous_range_readings_Date = \Carbon\Carbon::parse($last_previous_range_readings->date);
//                        $previousRangeDatee = \Carbon\Carbon::parse($previousRangeDate->date);
//                        //  \Illuminate\Support\Facades\Log::info('mER2' . $previousRangeDate);
//                        $differntofLP = $last_previous_range_readings_Date->diffInDays($previousRangeDatee);
//                        $differntofrl = $range_date_prev->diffInDays($last_previous_range_readings_Date);
//                        // \Illuminate\Support\Facades\Log::info('mErlp' . $differntofrl);
//                        $last_previous_range_value = $last_previous_range_readings->startreading;
//                        $previousRangevalue = $previousRangeDate->startreading;
//                        $previousRangeDateReading = $last_previous_range_value + ((($previousRangevalue - $last_previous_range_value) / $differntofLP) * $differntofrl);
//                        // \Illuminate\Support\Facades\Log::info('mEr0' . $previousRangeDateReading);
//
//                    } else {
//                        // Handle the case when dates match
//                        // You can add logic here if needed
//                    }
//                } else {
//                    $previousRangeDateReading = 0;
//                    $lastRangeDateReading = 0;
//                }
//                if ($unit_price !== null) {
//                    \Illuminate\Support\Facades\Log::info('mErp' . $previousRangeDateReading);
//                    \Illuminate\Support\Facades\Log::info('mErl' . $lastRangeDateReading);
//                    $total_BillReading = number_format($unit_price * ($lastRangeDateReading - $previousRangeDateReading)+$monthly_charj, 2);
//
//                }
//
//                array_push($total_bill_count, [
//                    'total_bill_count' => round($lastRangeDateReading - $previousRangeDateReading, 2),
//                    'category' => $utilityCategory->utility_category_name,
//                    'category_id' => $utilityCategory->id,
//                    'total_BillReading' => $total_BillReading ?? null,
//                ]);
//
//            }


            if ($date_current->month > $range_date_current->month || ($date_current->month == $range_date_current->month && $date_current->day > $range_date_current->day)) {

                $utility_unit_current_months = \App\Utility::where('status', 'Active')
                    ->whereBetween('date', [$range_date_current->subDay(), $nextMonth_range_date])
                    ->where('u_category_id', $utilityCategory->id)
                    ->where('hotel_id', auth()->user()->hotel_id)
                    ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                    ->orderBy('date', 'ASC')
                    ->get();



                $range_date_current = \Carbon\Carbon::createFromDate($year, $month, $range_date);

                if (!$utility_unit_current_months->isEmpty()) {
                    $previousRangeDate = $utility_unit_current_months->first();
                    $lastRangeDate = $utility_unit_current_months->last();



                    $previousRangeDateReading = $previousRangeDate->startreading;
                    $lastRangeDateReading = $lastRangeDate->startreading;



                    if (\Carbon\Carbon::parse($previousRangeDate->date)->format('Y-m-d') !== $range_date_current->format('Y-m-d')) {
                        $last_previous_range_readings = \App\Utility::where('status', 'Active')
                            ->where('date', '<', $range_date_current)
                            ->where('u_category_id', $utilityCategory->id)
                            ->where('hotel_id', auth()->user()->hotel_id)
                            ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                            ->orderBy('date', 'DESC')
                            ->first();
                        \Illuminate\Support\Facades\Log::info('mrt0' . $last_previous_range_readings);

                        $last_previous_range_readings_Date = \Carbon\Carbon::parse($last_previous_range_readings->date);
                        $previousRangeDatee = \Carbon\Carbon::parse($previousRangeDate->date);


                        $differntofLP = $last_previous_range_readings_Date->diffInDays($previousRangeDatee);
                        $differntofrl = $range_date_current->diffInDays($last_previous_range_readings_Date);


                        $last_previous_range_value = $last_previous_range_readings->startreading;
                        $previousRangevalue = $previousRangeDate->startreading;

                        $previousRangeDateReading = $last_previous_range_value + ((($previousRangevalue - $last_previous_range_value) / $differntofLP) * $differntofrl);

                    }
                    elseif ((\Carbon\Carbon::parse($lastRangeDate ->date)->format('Y-m-d') !== $nextMonth_range_date->format('Y-m-d'))){
                        \Illuminate\Support\Facades\Log::info('mrt' . $currentDate);

                       if ($currentDate>($nextMonth_range_date->format('Y-m-d'))) {

                           $last_range_reading_miss = \App\Utility::where('status', 'Active')
                               ->where('date', '>', $nextMonth_range_date)
                               ->where('u_category_id', $utilityCategory->id)
                               ->where('hotel_id', auth()->user()->hotel_id)
                               ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                               ->orderBy('date', 'ASC')
                               ->first();
                           \Illuminate\Support\Facades\Log::info('mrt1' . $last_range_reading_miss);

                           $last_range_reading_misdate = \Carbon\Carbon::parse($last_range_reading_miss->date);
                           $lastRangeDatee = \Carbon\Carbon::parse($lastRangeDate->date);

                           $differntoflm = $last_range_reading_misdate->diffInDays($lastRangeDatee);
                           $differntofcm = $last_range_reading_misdate->diffInDays($nextMonth_range_date);
                           $last_range_reading_miss_value = $last_range_reading_miss->startreading;

                           $lastRangeDate_value = $lastRangeDate->startreading;
                           $lastRangeDateReading = $last_range_reading_miss_value - ((($last_range_reading_miss_value - $lastRangeDate_value) / $differntoflm) * $differntofcm);
                       }
                    }


                    else {

                    }
                } else {
                    $previousRangeDateReading = 0;
                    $lastRangeDateReading = 0;

                }
                if($monthly_charj ==null){
                    $monthly_charj=0;
                }

                if ($unit_price !== null) {
                    $total_BillReading = number_format($unit_price * ($lastRangeDateReading - $previousRangeDateReading)+$monthly_charj, 2);

                }

                array_push($total_bill_count, [
                    'total_bill_count' => round($lastRangeDateReading - $previousRangeDateReading, 2),
                    'category' => $utilityCategory->utility_category_name,
                    'category_id' => $utilityCategory->id,
                    'total_BillReading' => $total_BillReading ?? null,
                ]);
            }





            else{

                $utilities_unit_Curent_month = $utility_unit_current_months = \App\Utility::where('status', 'Active')
                    ->whereBetween('date', [$range_date_prev->subDay(), $range_date_current]) // Adjusted the range
                    ->where('u_category_id', $utilityCategory->id)
                    ->where('hotel_id', auth()->user()->hotel_id)
                    ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                    ->orderBy('date', 'ASC')
                    ->get();

                if (!$utility_unit_current_months->isEmpty()) {
                    $range_date_prev = $range_date_current->copy()->subMonth();

                    $previousRangeDate = $utility_unit_current_months[0];
                    $lastRangeDate = $utility_unit_current_months->last();



                    $previousRangeDateReading = $previousRangeDate->startreading;
                    $lastRangeDateReading = $lastRangeDate->startreading;

                    if (\Carbon\Carbon::parse($previousRangeDate->date)->format('Y-m-d') !== $range_date_prev->format('Y-m-d')) {
                        $last_previous_range_readings = \App\Utility::where('status', 'Active')
                            ->where('date', '<', $range_date_prev)
                            ->where('u_category_id', $utilityCategory->id)
                            ->where('hotel_id', auth()->user()->hotel_id)
                            ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                            ->orderBy('date', 'DESC')
                            ->first();

                        \Illuminate\Support\Facades\Log::info('mrt2' . $last_previous_range_readings);

                        $last_previous_range_readings_Date = \Carbon\Carbon::parse($last_previous_range_readings->date);
                        $previousRangeDatee = \Carbon\Carbon::parse($previousRangeDate->date);

                        $differntofLP = $last_previous_range_readings_Date->diffInDays($previousRangeDatee);
                        $differntofrl = $range_date_prev->diffInDays($last_previous_range_readings_Date);

                        $last_previous_range_value = $last_previous_range_readings->startreading;
                        $previousRangevalue = $previousRangeDate->startreading;
                        $previousRangeDateReading = $last_previous_range_value + ((($previousRangevalue - $last_previous_range_value) / $differntofLP) * $differntofrl);



                    }
                    elseif ((\Carbon\Carbon::parse($lastRangeDate ->date)->format('Y-m-d') !== $range_date_current->format('Y-m-d'))&&(\Carbon\Carbon::parse($lastRangeDate->date)->format('m') !== $range_date_current->format('m'))){
                        $last_range_reading_miss = \App\Utility::where('status', 'Active')
                            ->where('date', '>', $range_date_current)
                            ->where('u_category_id', $utilityCategory->id)
                            ->where('hotel_id', auth()->user()->hotel_id)
                            ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                            ->orderBy('date', 'ASC')
                            ->first();
                  //     \Illuminate\Support\Facades\Log::info('mrt3' . $last_range_reading_miss);

                        $last_range_reading_misdate = \Carbon\Carbon::parse($last_range_reading_miss->date);
                        $lastRangeDatee =  \Carbon\Carbon::parse($lastRangeDate->date);

                        $differntoflm= $last_range_reading_misdate->diffInDays($lastRangeDatee);
                        $differntofcm = $last_range_reading_misdate->diffInDays($range_date_current);
                        $last_range_reading_miss_value= $last_range_reading_miss->startreading;


                        $lastRangeDate_value = $lastRangeDate->startreading;
                        $lastRangeDateReading= $last_range_reading_miss_value-((($last_range_reading_miss_value- $lastRangeDate_value)/$differntoflm)*$differntofcm);


                    }
                } else {
                    $previousRangeDateReading = 0;
                    $lastRangeDateReading = 0;

                }
                if($monthly_charj ==null){
                    $monthly_charj=0;
                }

                if ($unit_price !== null) {

                    $total_BillReading = number_format($unit_price * ($lastRangeDateReading - $previousRangeDateReading)+$monthly_charj, 2);

                }

                array_push($total_bill_count, [
                    'total_bill_count' => round($lastRangeDateReading - $previousRangeDateReading, 2),
                    'category' => $utilityCategory->utility_category_name,
                    'category_id' => $utilityCategory->id,
                    'total_BillReading' => $total_BillReading ?? null,
                ]);




            }














            $utilities = Utility::where('status', 'Active')
                ->whereBetween('date', [$prevMonthLastDay, $end_month])
                ->where('u_category_id', $utilityCategory->id)
                ->where('hotel_id', auth()->user()->hotel_id)
                ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                ->orderBy('date', 'ASC')
                ->get();

            $firstRecord = $utilities->first(); // Get the first record
            $lastRecord = $utilities->last(); // Get the last record

            $firstStartReading = $firstRecord ? $firstRecord->startreading : null;
            $lastStartReading = $lastRecord ? $lastRecord->startreading : null;

            if ($unit_price != null) {
                $total_Bill=number_format($unit_price*($lastStartReading-$firstStartReading), 2);
            }


            if ($firstRecord == null || $lastRecord == null) {
                $firstRecord = 0;
                $lastRecord = 0;
                array_push($total_count, [
                    'total_count' => $lastRecord-$firstRecord,
                    'category' => $utilityCategory->utility_category_name,
                    'category_id' => $utilityCategory->id,
                    'total_bill' => $total_Bill
                ]);
            }
            else{
                array_push($total_count, [
                    'total_count' => $lastRecord->startreading-$firstRecord->startreading,
                    'category' => $utilityCategory->utility_category_name,
                    'category_id' => $utilityCategory->id,
                    'total_bill' => $total_Bill
                ]);
            }

//            Log::notice($total_count);
//            Log::info($firstRecord);
//            Log::info($lastRecord);

//            return $total_count;

            if ($utilityCategory->difference == 'No' || $utilityCategory->difference == null) {

                $readable = array();

                for ($i = 1; $i <= $daysInMonth; $i++) {

                    $flag = 'Not found';
                    $dates_chart = Carbon::createFromDate($year, $month, $i);

                    if($utilityCategory->guest == 'Yes'){
                        $guestArray = $g_countList[$i];
                    }
                    else{
                        $guestArray = null;
                    }

                    foreach ($utilities as $utility) {

                        if ($points != null || $points != 0) {
                            $utility_reading = number_format($utility->startreading / $decimal_points, $points, '.', '');
                        } else {
                            $utility_reading = $utility->startreading;
                        }

                        if($utilityCategory->guest == 'Yes'){
                            if ($utility->monthDay == $i) {
                                array_push($readable, [
                                    'date' => $dates_chart,
                                    $utilityCategory->utility_category_name => $utility_reading,
                                    'guests' => $guestArray // Add the guests count to the readable array
                                ]);
                                $flag = 'Found';
                            }
                        }
                        else{
                            if ($utility->monthDay == $i) {
                                array_push($readable, [
                                    'date' => $dates_chart,
                                    $utilityCategory->utility_category_name => $utility_reading,
                                ]);
                                $flag = 'Found';
                            }
                        }

                    }

                    if($utilityCategory->guest == 'Yes'){
                        if ($flag == 'Not found') {
                            array_push($readable, [
                                'date' => $dates_chart,
                                $utilityCategory->utility_category_name => null,
                                'guests' => $guestArray
                            ]);
                        }
                    }
                    else{
                        if ($flag == 'Not found') {
                            array_push($readable, [
                                'date' => $dates_chart,
                                $utilityCategory->utility_category_name => null,
                            ]);
                        }
                    }

                }
                array_push($chartData, ['categoryName' => $utilityCategory->id, 'readings' => $readable]);
            }



            if($utilityCategory->difference=='Yes'){

                $last_reading = Utility::where('status', 'Active')
                    ->whereBetween('date', [$prevMonthStartDay, $prevMonthLastDay])
                    ->where('u_category_id', $utilityCategory->id)
                    ->where('hotel_id', auth()->user()->hotel_id)
                    ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                    ->orderBy('date', 'DESC')
                    ->first();

                if(isset($last_reading->date)) {
                    $previousMonthlastReadingDate = Carbon::parse($last_reading->date);
                    $previousMonthMissingDays = $previousMonthlastReadingDate->diffInDays($prevMonthLastDay);;
                }
                else{
                    $previousMonthMissingDays = 0;
                }

                $nextMonthStart_reading = Utility::where('status', 'Active')
                    ->whereBetween('date', [$nextMonthStartDay, $nextMonthLastDay])
                    ->where('u_category_id', $utilityCategory->id)
                    ->where('hotel_id', auth()->user()->hotel_id)
                    ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date')
                    ->orderBy('date', 'ASC')
                    ->first();


//                Log::info("category".$utilityCategory->id);
//                Log::info("previousMonthMissingDays".$previousMonthMissingDays);

                if($utilityCategory->average=='Yes'){

                    $readable = [];
                    $missingDays = [];

                    $previousReading = $last_reading->startreading ?? null; // Initialize previous reading
                    $missingReadings = null; // Initialize previous reading

                    for ($i = 1; $i <= $daysInMonth; $i++) {

                        $dates_chart = Carbon::createFromDate($year, $month, $i);
                        $foundUtility = false;
                        $difference = null;

                        foreach ($utilities as $index => $utility) {

                            if ($utility->monthDay == $i) {

                                if ($previousReading !== null) {
                                    $difference = $utility->startreading - $previousReading;
                                }

                                $previousReading = $utility->startreading;
                                $foundUtility = true;

                                $numberOfDays = count($missingDays)+1 + $previousMonthMissingDays;
                                $missingReadings = $difference / $numberOfDays;
//Log::info($missingReadings);
                                $previousMonthMissingDays = 0;

                                if($points==null or $points==0){
                                    $utility_reading = $missingReadings;
                                }
                                else{
                                    $utility_reading = number_format($missingReadings/$decimal_points, $points, '.','');
                                }

                                array_push($missingDays, $i);


                                foreach ($missingDays as $missingDay) {

                                    if($utilityCategory->guest == 'Yes'){
                                        $guestArray = $g_countList[$missingDay];
                                        array_push($readable, [
                                            'date' => Carbon::createFromDate($year, $month, $missingDay),
                                            $utilityCategory->utility_category_name => $utility_reading,
                                            'color' => $missingDay==$i?null:'#FF0000',
                                            'guests' =>$guestArray, // Add the guests count to the readable array
                                        ]);
                                    }
                                    else{
                                        $guestArray = null;
                                        array_push($readable, [
                                            'date' => Carbon::createFromDate($year, $month, $missingDay),
                                            $utilityCategory->utility_category_name => $utility_reading,
                                            'color' => $missingDay==$i?null:'#FF0000'
                                        ]);
                                    }

                                }

                                $missingDays = [];
                                break; // Exit the loop once a matching utility is found for the day

                            }
                        }

                        if (!$foundUtility) {
                            array_push($missingDays, $i);
                        }

                    }

                    $monthend_reading_avg = null;
                    if($nextMonthStart_reading){
                        $next_month_reading_strat_date = Carbon::parse($nextMonthStart_reading->date);
                        $next_month_missing_days = $nextMonthStartDay->diffInDays($next_month_reading_strat_date);

                        $difference = $nextMonthStart_reading->startreading - $previousReading;
                        $numberOfDays = count($missingDays)+1 + $next_month_missing_days;
                        $monthend_reading_avg = $difference / $numberOfDays;

//                        Log::info($utility_reading);
                    }
                    if($utilityCategory->guest == 'Yes'){
                        foreach ($missingDays as $missingDay) {
                            $guestArray = $g_countList[$missingDay];
                            array_push($readable, [
                                'date' => Carbon::createFromDate($year, $month, $missingDay),
                                $utilityCategory->utility_category_name => $monthend_reading_avg,
                                'guests' =>$guestArray, // Add the guests count to the readable array
                                'color' => '#FF0000'
                            ]);
                        }
                    }
                    else{
                        foreach ($missingDays as $missingDay) {
                            array_push($readable, [
                                'date' => Carbon::createFromDate($year, $month, $missingDay),
                                $utilityCategory->utility_category_name => null
                            ]);
                        }
                    }

                    array_push($chartData, [
                        'categoryName' => $utilityCategory->id,
                        'readings' => $readable,
                    ]);
                }



                if ($utilityCategory->average=='No'){

                    $readable = array();
                    $previousReading = $last_reading->startreading ?? null; // Initialize previous reading

                    for ($i = 1; $i <= $daysInMonth; $i++) {

                        $flag = 'Not found';
                        $dates_chart = Carbon::createFromDate($year, $month, $i);

                        if($utilityCategory->guest == 'Yes'){
                            $guestArray = $g_countList[$i];
                        }
                        else{
                            $guestArray = null;
                        }

                        foreach ($utilities as $utility) {

                            if ($utility->monthDay == $i) {
                                // Calculate the difference between now reading and previous reading
                                $difference = $utility->startreading - $previousReading;

                                if($points!=null and $points!=0){
                                    $utility_reading = number_format($difference/(10**$points), $points, '.','');
                                }
                                else{
                                    $utility_reading = $difference;
                                }

                                if($utilityCategory->guest == 'Yes'){
                                    array_push($readable, [
                                        'date' => $dates_chart,
                                        $utilityCategory->utility_category_name => $utility_reading,
                                        'guests' => $guestArray
                                    ]);
                                }
                                else{
                                    array_push($readable, [
                                        'date' => $dates_chart,
                                        $utilityCategory->utility_category_name => $utility_reading
                                    ]);
                                }

                                $flag = 'Found';
                                $previousReading = $utility->startreading; // Update previous reading
                            }

                        }

                        if ($flag == 'Not found') {

                            if($utilityCategory->guest == 'Yes'){
                                array_push($readable, [
                                    'date' => $dates_chart,
                                    $utilityCategory->utility_category_name => null,
                                    'guests' => $guestArray
                                ]);
                            }
                            else{
                                array_push($readable, [
                                    'date' => $dates_chart,
                                    $utilityCategory->utility_category_name => null
                                ]);
                            }

                        }
                    }

                    array_push($chartData, [
                        'categoryName' => $utilityCategory->id,
                        'readings' => $readable
                    ]);

                }
            }
        }
//        return response()->json($chartData);
        return response()->json(['chartData'=>$chartData,'total_count'=>$total_count,'total_bill_count' => $total_bill_count,]);

    }

//    public function dashboard_utility_chart_render(Request $request)
//    {
//        $date = $request->input('date');
//        $utilityCategories = Utility_category::where('hotel_id', auth()->user()->hotel_id)
//            ->where('status', 'Active')
//            ->get();
//
//        $chartData = [];
//
//        $year = Carbon::parse($date)->year;
//        $month = Carbon::parse($date)->month;
//        $daysInMonth = Carbon::parse($date)->daysInMonth;
//        $end_month = Carbon::createFromDate($year, $month, $daysInMonth);
//        $prevMonthStartDay = Carbon::createFromDate($year, $month, 1)->subDay()->startOfMonth();
//        $prevMonthLastDay = Carbon::createFromDate($year, $month, 1)->subDay()->endOfMonth();
//
//        foreach ($utilityCategories as $utilityCategory) {
//            $utilities = Utility::where('status', 'Active')
//                ->whereBetween('date', [$prevMonthStartDay, $end_month])
//                ->where('u_category_id', $utilityCategory->id)
//                ->where('hotel_id', auth()->user()->hotel_id)
//                ->selectRaw('DAYOFMONTH(date) as monthDay, startreading, date, different, average')
//                ->orderBy('date', 'ASC')
//                ->get();
//
//            $readable = [];
//            $previousUtility = null;
//            $previousDate = null;
//
//            for ($i = 1; $i <= $daysInMonth; $i++) {
//                $dates_chart = Carbon::createFromDate($year, $month, $i);
//                $utilityData = null;
//
//                foreach ($utilities as $utility) {
//                    if ($utility->monthDay == $i) {
//                        $utilityData = $utility;
//                        break;
//                    }
//                }
//
//                if ($utilityData !== null) {
//                    $utilityValue = null;
//
//                    if ($utilityCategory->different === 'Yes' && $utilityData->different === 'Yes') {
//                        if ($previousUtility !== null && $previousDate !== null) {
//                            $daysDifference = $previousDate->diffInDays($utilityData->date);
//                            $averageValue = ($utilityData->startreading - $previousUtility->startreading) / $daysDifference;
//                            $utilityValue = $averageValue;
//                        } else {
//                            $utilityValue = null; // No average calculation for the first utility entry
//                        }
//                    } else {
//                        $utilityValue = $utilityData->different === 'Yes' ? $utilityData->startreading : null;
//                    }
//
//                    $previousUtility = $utilityData;
//                    $previousDate = $utilityData->date;
//
//                    $readable[] = ['date' => $dates_chart, $utilityCategory->utility_category_name => $utilityValue];
//                } else {
//                    $readable[] = ['date' => $dates_chart, $utilityCategory->utility_category_name => null];
//                }
//            }
//
//            $chartData[] = ['categoryName' => $utilityCategory->id, 'readings' => $readable];
//        }
//
//        return response()->json($chartData);
//    }

    public function invoice_all(Request $request)
    {
//        return $request;
        if ($request->has('print')) {
            $invoice = Order_list::with('order_list_detail')->find($request->input('id'));
            $hotel = Hotel::find($invoice->hotel_id);


            if ($request->customer_email) {
            $pdf = Facade\Pdf::loadView('hotel.Invoice_print',['invoice' => $invoice, 'hotel' => $hotel]);
            $pdf_file = base64_encode($pdf->output());

            $pdf_data = new \stdClass;
            $pdf_data->pdf = $pdf_file;
            $pdf_data->name = '🍴';
            $reservation_email = $request->customer_email;

            Mail::to($reservation_email)
                ->send(new Invoice($pdf_data));
            }

            return view('hotel.Invoice_print', ['invoice' => $invoice, 'hotel' => $hotel]);

        } elseif ($request->has('id')) {
            $invoice = Order_list::with('order_list_detail')->find($request->input('id'));
            $hotel = Hotel::find($invoice->hotel_id);
            return view('hotel.Invoice_view', ['invoice' => $invoice, 'hotel' => $hotel]);
        } else {
            $invoices = Order_list::with('room', 'reservation')->where('hotel_id', auth()->user()->hotel_id)->get();
            return view('hotel.Invoice_all', ['invoices' => $invoices]);
        }

    }

    public function invoice_void_sale(Request $request)
    {
        $invoice_id = $request->input('id');
        $order_list = Order_list::with('order_list_detail')->find($invoice_id);
        return response()->json(['order_list' => $order_list]);
    }

    public function invoice_void_sale_confirm(Request $request){
        $invoice_id = $request->input('id');
        $reason = $request->input('reason');
        $date = date('Y-m-d');
        $order_log_dt = LogActivity::select('id','date','in','out','balance','user_id','remarks','item_id')->where('sale_id',$invoice_id)->where('event','SALE')->get();


        $order_list = Order_list::
//        with('order_list_detail')->
        find($invoice_id);

        $order_list->reason = $reason;
        $order_list->status = 'Cancelled';
        $order_list->save();

        $cash_book_log = Cash_book_log_activity::where('order_id',$order_list->id)->first();
        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Void Sale' . ' ' . '(' . $cash_book_log->debit . ')' . 'Sale Id : ' . $order_list->id;
        $cash_book_log->remark = $remark;
        $cash_book_log->status = 'Delete';
        $cash_book_log->save();
        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Delete');

        foreach ($order_log_dt as $order_log){
            $item = Item::find($order_log->item_id);
            $item->quantity = $item->quantity+$order_log->out;
            \LogActivity::addToLog('POS Sale Void', $date, 'SALE_VOID', null, $invoice_id, null, $order_log->out, null, $item->quantity, Auth::id(), 'remove sale ' . $order_log->remarks,$item->id);
            $item->save();
        }
        return redirect()->back()->with('success', 'Successfully Sale Canceled!');
        }

        public function invoice_complete_payment(Request $request){
//        return $request;
            $order_list = Order_list::find($request->input('order_id'));
            $order_list->status = 'Complete';
            $order_list->paid_amount = $request->input('f-paid-amount');
            $order_list->given_amount = $request->input('f-give-amount');
            $order_list->change_amount = $request->input('f-change-amount');
            $order_list->due_amount = 0.00;
//        $order_list->finalize_date = Carbon::now();
            $order_list->finalize_date = $request->input('date');
             $order_list->payment_method = $request->input('payment_method');
            $order_list->save();

            if ($order_list->payment_method == 'Cash' or $order_list->payment_method == 'Card') {
                $resturant_payment_cashbook = Restaurant::find($order_list->restaurant_id);
                if ($order_list->payment_method == 'Cash' and $resturant_payment_cashbook->cash_payment != null) {
                    $cashbook_id = $resturant_payment_cashbook->cash_payment;
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit (Sale)' . ' ' . $order_list->paid_amount . ' ' . 'Order ID ' . $order_list->id;
                    $cash_debit = new Cash_book_log_activity();
                    $cash_debit->cashbook_id = $cashbook_id;
                    $cash_debit->hotel_id = auth()->user()->hotel_id;
                    $cash_debit->debit = $order_list->paid_amount;
                    $cash_debit->status = 'Active';
                    $cash_debit->date = $order_list->finalize_date;
                    $cash_debit->user_id = auth()->user()->id;
                    $cash_debit->remark = $remark;
                    $cash_debit->order_id = $order_list->id;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
                } elseif ($order_list->payment_method == 'Card' and $resturant_payment_cashbook->card_payment != null) {
                    $cashbook_id = $resturant_payment_cashbook->card_payment;
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit (Sale)' . ' ' . $order_list->paid_amount . ' ' . 'Order ID ' . $order_list->id;
                    $cash_debit = new Cash_book_log_activity();
                    $cash_debit->cashbook_id = $cashbook_id;
                    $cash_debit->hotel_id = auth()->user()->hotel_id;
                    $cash_debit->debit = $order_list->paid_amount;
                    $cash_debit->status = 'Active';
                    $cash_debit->date = $order_list->finalize_date;
                    $cash_debit->user_id = auth()->user()->id;
                    $cash_debit->remark = $remark;
                    $cash_debit->order_id = $order_list->id;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
                }

            }
            return redirect()->back()->with('success', 'Payment update success!');
        }

    public function invoice_show(Request $request)
    {
        $waste_id = $request->input('waste_id');
        $waste_details = Wastage::find($waste_id);
        return response()->json(['waste_details' => $waste_details]);
    }

    public function modechange(Request $request)
    {
        $mode = $request->input('mode');
        $user = User::find(auth()->id());
        $user->mode = $mode;
        $user->save();
    }

    public function switch_hotel_view(Request $request)
    {
        $hotel_id = $request->input('hotel_id');
        $hotel_chain_id = $request->input('hotel_chain_id');
        $switch_hotel = User::where('id', auth()->user()->id)->first();
        $switch_hotel->hotel_id = $hotel_id;
        $switch_hotel->hotel_chain_id = $hotel_chain_id;
        $switch_hotel->save();
        return redirect()->route('hotel/widget/view');
    }

    public function switch_hotel_view_change(Request $request)
    {
        $hotel_id = $request->input('hotel_id');
        $hotel_chain_id = $request->input('hotel_chain_id');
        $switch_hotel = User::where('id', auth()->user()->id)->first();
        $switch_hotel->hotel_id = $hotel_id;
        $switch_hotel->hotel_chain_id = $hotel_chain_id;
        $switch_hotel->save();
        return redirect()->back();
    }

    public function add_main_categories()
    {
        $inventory_categories = Inventory_category::with('inventory_sub_category')->where('hotel_id', auth()->user()->hotel_id)->get();
//     return $inventory_categories;
        return view('hotel.add_inventory_category', ['inventory_categories' => $inventory_categories]);
    }

    public function save_main_categories(Request $request)
    {
        $category_name = $request->input('category_name');
        $category = new Inventory_category();
        $category->name = $category_name;
        $category->hotel_id = auth()->user()->hotel_id;
        $category->save();
        return redirect()->back();
    }

    public function save_sub_categories(Request $request)
    {
        $sub_category_name = $request->input('sub_category_name');
        $category_id = $request->input('s_category_id');

        $sub_category = new Inventory_sub_category();
        $sub_category->name = $sub_category_name;
        $sub_category->inventory_category_id = $category_id;
        $sub_category->save();
        return response()->json(['success' => 'success', 'sub_category' => $sub_category]);
    }

    public function get_sub_categories_details(Request $request)
    {
        $category_id = $request->input('sub_category_id');
        $sub_category = Inventory_sub_category::find($category_id);
        return response()->json(['success' => 'success', 'sub_category' => $sub_category]);
    }

    public function edit_sub_category_save(Request $request)
    {
        $sub_category_id = $request->input('sub_category_id');
        $sub_category_name = $request->input('e_sub_category_name');
        $sub_category = Inventory_sub_category::find($sub_category_id);
        $sub_category->name = $sub_category_name;
        $sub_category->save();
        return response()->json(['success' => 'success', 'sub_category' => $sub_category]);
    }

    public function edit_category_get_details(Request $request)
    {
        $category_id = $request->input('category_id');
        $category = Inventory_category::find($category_id);
        return response()->json(['success' => 'success', 'category' => $category]);
    }

    public function edit_category_save(Request $request)
    {
        $category_id = $request->input('e_category_id');
        $category_name = $request->input('e_category_name');
        $category = Inventory_category::find($category_id);
        $category->name = $category_name;
        $category->save();
        return response()->json(['success' => 'success', 'category' => $category]);
    }

    public function add_category_item_view(Request $request)
    {
        $sub_category_id = $request->input('sub_category_id');
        $inventory = Inventory_sub_category::with('inventory_category', 'inventory')->where('id', $sub_category_id)->first();
        return response()->json(['success' => 'success', 'inventory' => $inventory]);
    }

    public function add_inventory_item_save(Request $request)
    {
        $sub_category_id = $request->input('av_sub_category_id');
        $category_id = $request->input('av_category_id');
        $name = $request->input('category_item_name');
        $status = $request->input('customCheck');


        $inventory_item = new Inventory();
        $inventory_item->inventory_category_id = $category_id;
        $inventory_item->inventory_sub_category_id = $sub_category_id;
        $inventory_item->hotel_id = auth()->user()->hotel_id;
        $inventory_item->name = $name;
        if ($status == 'on') {
            $inventory_item->status = 'countable';
        } else {
            $inventory_item->status = 'un_countable';
        }

        $inventory_item->save();
        return response()->json(['success' => 'success', 'inventory_item' => $inventory_item]);
    }

    public function inventory_item_get_details(Request $request)
    {
        $inventory_id = $request->input('inventory_id');
        $inventory_item = Inventory::find($inventory_id);
        return response()->json(['success' => 'success', 'inventory_item' => $inventory_item]);
    }

    public function edit_inventory_item_save(Request $request)
    {
        $inventory_id = $request->input('e_inventory_id');
        $inventory_item_name = $request->input('e_category_item_name');
        $inventory_item_status = $request->input('e_customCheck');
        $inventory_item = Inventory::find($inventory_id);
        $inventory_item->name = $inventory_item_name;
        if ($inventory_item_status == 'on') {
            $inventory_item->status = 'countable';
        } else {
            $inventory_item->status = 'un_countable';
        }
        $inventory_item->save();
        return response()->json(['success' => 'success', 'inventory_item' => $inventory_item]);
    }

    public function view_over_roll_inventory()
    {
        $inventory_items = Inventory::with('inventory_sub_category.inventory_category')->where('hotel_id', auth()->user()->hotel_id)->get();
        $main_categories = Inventory_category::where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.view_inventory', ['inventory_items' => $inventory_items, 'main_categories' => $main_categories]);
    }

    public function load_sub_category_inventory_filter(Request $request)
    {
        $category_id = $request->input('category_id');
        $sub_categories = Inventory_sub_category::where('inventory_category_id', $category_id)->get();
        return response()->json(['success' => 'success', 'sub_categories' => $sub_categories]);
    }

    public function add_inventory_item_bill_view()
    {
        $inventory_categories = Inventory_category::where('hotel_id', auth()->user()->hotel_id)->get();
        $suppliers = Supplier::select('id','supplier_name')->where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.add_inventory_item_bill_view', ['inventory_categories' => $inventory_categories, 'suppliers' => $suppliers]);
    }

    public function load_sub_category_items(Request $request)
    {
        $sub_inventory_id = $request->input('sub_category_id');
        $inventory_sub_category_items = Inventory::where('inventory_sub_category_id', $sub_inventory_id)->get();
        return response()->json(['success' => 'success', 'inventory_sub_category_items' => $inventory_sub_category_items]);
    }

    public function inventory_item_bill_save(Request $request)
    {
        $date = $request->input('date');
        $supplier = $request->input('supplier');
        $total_cost = $request->input('total_cost');
        $inventory_bill = new Inventory_item_bill();
        $inventory_bill->supplier = $supplier;
        $inventory_bill->image = $supplier;
        $inventory_bill->user_id = auth()->user()->id;
        $inventory_bill->date = $date;
        $inventory_bill->total_price = $total_cost;
        $inventory_bill->hotel_id = auth()->user()->hotel_id;
        if ($image = $request->file('bill_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/inventory/bill/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $inventory_bill->image = $path;
        }
        $inventory_bill->save();
        $hotel = Hotel::where('id', auth()->user()->hotel_id)->first();
        $hotel_name = substr($hotel->hotel_name, 0, 3);
        $count = $request->input('count');
        for ($i = 1; $i <= $count; $i++) {
            $inventory_item_quantity = $request->input('quantity-' . $i);
            $inventory_item_id = $request->input('sub_category_item-' . $i);
            $inventory_total_price = $request->input('total_price-' . $i);
            $inventory_category_id = $request->input('category-' . $i);
            $inventory_sub_category_id = $request->input('sub_category-' . $i);
            if ($inventory_item_quantity != "" && $inventory_total_price != "" && $inventory_item_id != "") {
                $inventory_bill_detail = new Inventory_item_bill_detail();
                $inventory_bill_detail->inventory_item_bill_id = $inventory_bill->id;
                $inventory_bill_detail->quantity = $inventory_item_quantity;
                $inventory_bill_detail->total_price = $inventory_total_price;
                $inventory_bill_detail->inventory_id = $inventory_item_id;
                if ($image = $request->file('image_of_item-' . $i)) {
                    $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
                    $contentType = $image->getClientMimeType();
                    $path = Storage::putFile('/inventory/bill_detail/thumbnail', $image, 'public');
                    $file = Image::make($image)
                        ->orientate()
                        ->resize(500, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    Storage::put($path, (string)$file->encode());
                    $inventory_bill_detail->image = $path;
                }
                $inventory_bill_detail->save();
                $inventory_item = Inventory::find($inventory_item_id);
                $inventory_item->quantity = $inventory_item->quantity + $inventory_bill_detail->quantity;
                $inventory_item->save();
            }
            for ($k = 1; $k <= $inventory_item_quantity; $k++) {
                $item_items = new Inventory_item();
                $item_items->inventory_id = $inventory_item_id;
                $item_items->inventory_item_bill_detail_id = $inventory_bill_detail->id;
                $item_items->item_price = $inventory_total_price / $inventory_item_quantity;
                $item_items->save();
                $item_items->reference_num = '#' . $hotel_name . '-' . $inventory_category_id . '-' . $inventory_sub_category_id . '-' . $inventory_item_id . '-' . $item_items->id;
                $item_items->status = 'Active';
                $item_items->save();
                if ($inventory_item->status == 'countable') {
                    \LogActivityInventory::addToLog('PURCHASE', $date, 'PURCHASE', $inventory_bill->id, null, 1, null, ($inventory_item->quantity - $inventory_bill_detail->quantity) + $k, Auth::id(), 'Purchase Items', $inventory_item->id, $item_items->id, $item_items->reference_num);
                }
            }
            if ($inventory_item->status == 'un_countable') {
                \LogActivityInventory::addToLog('PURCHASE', $date, 'PURCHASE', $inventory_bill->id, null, $inventory_bill_detail->quantity, null, $inventory_item->quantity, Auth::id(), 'Purchase Items', $inventory_item->id, null, 'un-countable');
            }
        }

        $inventory_bill_detail_ids = Inventory_item_bill_detail::select('id')->where('inventory_item_bill_id', $inventory_bill->id)->get()->pluck('id');
        $inventory_bill_items = Inventory_item::with('inventory')->whereIn('inventory_item_bill_detail_id', $inventory_bill_detail_ids)->get();
        return view('hotel.save_remarks_inventory_bill_item', ['inventory_bill_items' => $inventory_bill_items]);
    }

    public function inventory_item_bill_remark_save(Request $request)
    {
        $count = $request->input('count');
        for ($i = 1; $i <= $count; $i++) {
            if ($request->has('datarowid-' . $i)) {
                $item_model = $request->input('item_model-' . $i);
                $item_w_date = $request->input('w_date-' . $i);
                $item_w_remark = $request->input('remark-' . $i);
                $item_row_id = $request->input('datarowid-' . $i);
                $inventory_item = Inventory_item::find($item_row_id);
                $inventory_item->item_model = $item_model;
                $inventory_item->item_warrenty_date = $item_w_date;
                $inventory_item->remark = $item_w_remark;
                $inventory_item->save();
            }
        }
        return redirect()->route('hotel/inventory/view_inventory_item_bill_list');
    }

    public function view_inventory_item_bill_list()
    {
        $inventory_bills = Inventory_item_bill::with('user')->where('hotel_id', auth()->user()->hotel_id)->get();
        $inventory_all_items = Inventory::with('inventory_item', 'inventory_sub_category.inventory_category')->where('status', 'countable')->where('hotel_id', auth()->user()->hotel_id)->get();
        $main_categories = Inventory_category::where('hotel_id', auth()->user()->hotel_id)->get();
        //return $inventory_all_items;
        return view('hotel.view_inventory_bills', ['inventory_bills' => $inventory_bills, 'inventory_all_items' => $inventory_all_items, 'main_categories' => $main_categories]);
    }

    public function get_inventory_item_bill_details(Request $request)
    {
        $inventory_bill_id = $request->input('inventory_bill_id');
        $inventory_item_details = Inventory_item_bill::with('inventory_item_bill_detail.inventory_item')->where('id', $inventory_bill_id)->first();
        return response()->json(['success' => 'success', 'inventory_item_details' => $inventory_item_details]);
    }

    public function get_inventory_item_details(Request $request)
    {
        $inventory_item_id = $request->input('inventory_item_id');
        $inventory_item = Inventory_item::with('inventory')->where('id', $inventory_item_id)->first();
        return response()->json(['success' => 'success', 'inventory_item' => $inventory_item]);
    }

    public function get_inventory_edit_item_save(Request $request)
    {
        $inventory_item_id = $request->input('e_inventory_id');
        $date = $request->input('w_date');
        $model = $request->input('e_model');
        $remark = $request->input('e_remark');
        $inventory_item = Inventory_item::find($inventory_item_id);
        $inventory_item->item_warrenty_date = $date;
        $inventory_item->item_model = $model;
        $inventory_item->remark = $remark;
        $inventory_item->save();

        $edited_item = Inventory_item::with('inventory.inventory_sub_category.inventory_category')->where('id', $inventory_item->id)->first();
        return response()->json(['success' => 'success', 'edited_item' => $edited_item]);
    }

    public function get_edit_inventory_bill_details(Request $request)
    {
        $inventory_bill_id = $request->input('inventory_bill_id');
//        $inventory_bill = Inventory_item_bill::with('inventory_item_bill_detail')->where('id',$inventory_bill_id)->first();
        $inventory_bill = Inventory_item_bill::with('inventory_item_bill_detail.inventory.inventory_sub_category.inventory_category')->where('id', $inventory_bill_id)->first();
        $main_categories = Inventory_category::where('hotel_id', auth()->user()->hotel_id)->get();
        return response()->json(['success' => 'success', 'inventory_bill' => $inventory_bill, 'main_categories' => $main_categories]);
    }

    public function remove_inventory_bill_details(Request $request)
    {
        $inventory_bill_detail_id = $request->input('bill_detail_id');
        $inventory_bill_detail = Inventory_item_bill_detail::where('id', $inventory_bill_detail_id)->first();
        $inventory_items = Inventory_item::where('inventory_item_bill_detail_id', $inventory_bill_detail_id)->delete();
        $inventory_id = $inventory_bill_detail->inventory_id;
        $inventory = Inventory::find($inventory_id);
        $inventory->quantity = $inventory->quantity - $inventory_bill_detail->quantity;
        $inventory->save();
        $inventory_bill = Inventory_item_bill::where('id', $inventory_bill_detail->inventory_item_bill_id)->first();
        $inventory_bill->total_price = $inventory_bill->total_price - $inventory_bill_detail->total_price;
        $inventory_bill->save();
        \LogActivityInventory::addToLog('PURCHASE BILL ITEM REMOVE', $inventory->date, 'PURCHASE BILL ITEM REMOVE', $inventory_bill->id, null, null, $inventory_bill_detail->quantity, $inventory->quantity, Auth::id(), 'Purchase Items remove from Bill', $inventory->id, null, null);
        $inventory_bill_detail->delete();
        return response()->json(['success' => 'success']);
    }

    public function edit_inventory_item_bill_save(Request $request)
    {
        //return $request;
        $inventory_bill_id = $request->input('e_inventory_bill_id');
        $e_date = $request->input('e_date');
        $e_supplier = $request->input('e_supplier');
        $e_total_cost = $request->input('e_total_cost');
        $inventory_bills = Inventory_item_bill::find($inventory_bill_id);
        $inventory_bills->date = $e_date;
        $inventory_bills->supplier = $e_supplier;
        $inventory_bills->total_price = $e_total_cost;
        if ($image = $request->file('e_inventory_bill_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/inventory/bill/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $inventory_bills->image = $path;
        }
        $inventory_bills->save();
        $count = $request->input('count');
        $hotel = Hotel::where('id', auth()->user()->hotel_id)->first();
        $hotel_name = substr($hotel->hotel_name, 0, 3);
        for ($i = 1; $i <= $count; $i++) {
            $inventory_bill_detail_id = $request->input('inventory_bill_detail_id-' . $i);
            $inventory_sub_category_item_id = $request->input('sub_category_item-' . $i);
            $inventory_bill_detail_total_price = $request->input('total_price-' . $i);
            $inventory_bill_detail_item_quantity = $request->input('quantity-' . $i);
            $inventory_category_id = $request->input('category-' . $i);
            $inventory_sub_category_id = $request->input('sub_category-' . $i);
            if ($inventory_bill_detail_id != "" && $inventory_sub_category_item_id != "" && $inventory_bill_detail_total_price != "") {

                if ($inventory_bill_detail_id != 'new') {
                    $inventory_bill_detail = Inventory_item_bill_detail::find($inventory_bill_detail_id);
                    $inventory_bill_detail->inventory_id = $inventory_sub_category_item_id;
                    $inventory_bill_detail->total_price = $inventory_bill_detail_total_price;
                    if ($image = $request->file('e_inventory_bill_item_image-' . $i)) {
                        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
                        $contentType = $image->getClientMimeType();
                        $path = Storage::putFile('/inventory/bill_detail/thumbnail', $image, 'public');
                        $file = Image::make($image)
                            ->orientate()
                            ->resize(500, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                        Storage::put($path, (string)$file->encode());
                        $inventory_bill_detail->image = $path;
                    }
                    $inventory_bill_detail->save();
                    $update_unit_price = $inventory_bill_detail->total_price / $inventory_bill_detail->quantity;
                    $inventory_items = Inventory_item::where('inventory_item_bill_detail_id', $inventory_bill_detail->id)->update(["item_price" => $update_unit_price]);
                } else {
                    if ($inventory_bill_detail_item_quantity != "" && $inventory_bill_detail_total_price != "" && $inventory_sub_category_item_id != "") {
                        $inventory_bill_detail_new = new Inventory_item_bill_detail();
                        $inventory_bill_detail_new->inventory_item_bill_id = $inventory_bills->id;
                        $inventory_bill_detail_new->quantity = $inventory_bill_detail_item_quantity;
                        $inventory_bill_detail_new->total_price = $inventory_bill_detail_total_price;
                        $inventory_bill_detail_new->inventory_id = $inventory_sub_category_item_id;
                        if ($image = $request->file('image_of_item-' . $i)) {
                            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
                            $contentType = $image->getClientMimeType();
                            $path = Storage::putFile('/inventory/bill_detail/thumbnail', $image, 'public');
                            $file = Image::make($image)
                                ->orientate()
                                ->resize(500, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                            Storage::put($path, (string)$file->encode());
                            $inventory_bill_detail_new->image = $path;
                        }
                        $inventory_bill_detail_new->save();
                        $inventory_item = Inventory::find($inventory_sub_category_item_id);
                        $inventory_item->quantity = $inventory_item->quantity + $inventory_bill_detail_new->quantity;
                        $inventory_item->save();
                        $inventory_bill_update = Inventory_item_bill::find($inventory_bills->id);
                        $inventory_bill_update->total_price = $inventory_bill_update->total_price + $inventory_bill_detail_new->total_price;
                        $inventory_bill_update->save();
                    }
                    for ($k = 1; $k <= $inventory_bill_detail_item_quantity; $k++) {
                        $item_items = new Inventory_item();
                        $item_items->inventory_id = $inventory_sub_category_item_id;
                        $item_items->inventory_item_bill_detail_id = $inventory_bill_detail_new->id;
                        $item_items->item_price = $inventory_bill_detail_total_price / $inventory_bill_detail_item_quantity;
                        $item_items->save();
                        $item_items->reference_num = '#' . $hotel_name . '-' . $inventory_category_id . '-' . $inventory_sub_category_id . '-' . $inventory_sub_category_item_id . '-' . $item_items->id;
                        $item_items->status = 'Active';
                        $item_items->save();
                        if ($inventory_item->status == 'countable') {
                            \LogActivityInventory::addToLog('PURCHASE BILL EDIT', $e_date, 'PURCHASE BILL EDIT', $inventory_bills->id, null, 1, null, ($inventory_item->quantity - $inventory_bill_detail_new->quantity) + $k, Auth::id(), 'Purchase Items Edit', $inventory_item->id, $item_items->id, $item_items->reference_num);
                        }
                    }
                    if ($inventory_item->status == 'un_countable') {
                        \LogActivityInventory::addToLog('PURCHASE BILL EDIT', $e_date, 'PURCHASE BILL EDIT', $inventory_bills->id, null, $inventory_bill_detail_new->quantity, null, $inventory_item->quantity, Auth::id(), 'Purchase Items Edit', $inventory_item->id, null, 'un-countable');
                    }
                }
            }
        }
        $inventory_bill_detail_ids = Inventory_item_bill_detail::select('id')->where('inventory_item_bill_id', $inventory_bills->id)->get()->pluck('id');
        $inventory_bill_items = Inventory_item::with('inventory')->whereIn('inventory_item_bill_detail_id', $inventory_bill_detail_ids)->get();
        return view('hotel.save_remarks_inventory_bill_item', ['inventory_bill_items' => $inventory_bill_items]);
    }

    public function inventory_item_remove(Request $request)
    {
        $inventory_item_id = $request->input('inventory_item_id');
        $inventory_item = Inventory_item::find($inventory_item_id);
        $inventory_bill_detail = Inventory_item_bill_detail::where('id', $inventory_item->inventory_item_bill_detail_id)->first();
        $inventory_bill_detail->quantity = $inventory_bill_detail->quantity - 1;
        if ($inventory_bill_detail->quantity == 0) {
            return response()->json(['error' => 'cannot_delete']);
        }
        $inventory_bill_detail->total_price = $inventory_bill_detail->total_price / $inventory_bill_detail->quantity;
        $inventory_bill_detail->save();

        $inventory = Inventory::find($inventory_item->inventory_id);
        $inventory->quantity = $inventory->quantity - 1;
        $inventory->save();

        $inventory_bill = Inventory_item_bill::where('id', $inventory_bill_detail->inventory_item_bill_id)->first();
        \LogActivityInventory::addToLog('PURCHASE BILL ITEM REMOVE', $inventory_bill->date, 'PURCHASE BILL ITEM REMOVE', $inventory_bill->id, null, null, 1, $inventory->quantity, Auth::id(), 'Purchase Items remove', $inventory->id, $inventory_item->id, $inventory_item->reference_num);
        $inventory_item->delete();
        return response()->json(['success' => 'success']);
    }

    public function waste_manage_view()
    {
        $inventory_all_items = Inventory::with('inventory_item', 'inventory_sub_category.inventory_category')->where('status', 'countable')->where('hotel_id', auth()->user()->hotel_id)->get();
        $main_categories = Inventory_category::where('hotel_id', auth()->user()->hotel_id)->get();
        $inventory_damages = Inventory_wastage::with('user')->where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.inventory_waste_manage', ['inventory_all_items' => $inventory_all_items, 'main_categories' => $main_categories, 'inventory_damages' => $inventory_damages]);
    }

    public function add_waste_item_pop(Request $request)
    {
        $inventory_item_id = $request->input('inventory_item_id');
        $inventory_item = Inventory_item::with('inventory')->where('id', $inventory_item_id)->first();
        return response()->json(['success' => 'success', 'inventory_item' => $inventory_item]);
    }

    public function inventory_waste_save(Request $request)
    {
        $inventory_item_id = $request->input('w_inventory_item_id');
        $inventory_id = $request->input('w_inventory_id');
        $inventory_item_name = $request->input('w_item_name');
        $waste_date = $request->input('date');
        $waste_reason = $request->input('reason');
        $ref_number = $request->input('w_ref_num');

        $waste = new Inventory_wastage();
        $waste->user_id = auth()->user()->id;
        $waste->hotel_id = auth()->user()->hotel_id;
        $waste->inventory_id = $inventory_id;
        $waste->inventory_item_id = $inventory_item_id;
        $waste->inventory_item_name = $inventory_item_name;
        $waste->reference_num = $ref_number;
        $waste->reason = $waste_reason;
        $waste->date = $waste_date;
        if ($image = $request->file('w_waste_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/inventory/waste/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $waste->image = $path;
        }
        $waste->save();

        $inventory_items = Inventory_item::find($waste->inventory_item_id);
        $inventory_items->status = 'Block';
        $inventory_items->save();

        $inventory = Inventory::find($waste->inventory_id);
        $inventory->quantity = $inventory->quantity - 1;
        $inventory->save();
        \LogActivityInventory::addToLog('INVENTORY ITEM DAMAGE (COUNTABLE)', $waste_date, 'INVENTORY ITEM DAMAGE (COUNTABLE)', null, $waste->id, null, 1, $inventory->quantity, Auth::id(), 'Add Items Damage', $inventory->id, null, null);

        $inventory_damages = Inventory_wastage::with('user')->find($waste->id);
        return response()->json(['success' => 'success', 'inventory_damages' => $inventory_damages]);
    }

    public function inventory_filter_uncountable_item(Request $request)
    {
        $inventory_sub_category_id = $request->input('sub_category_id');
        $un_items = Inventory::where('inventory_sub_category_id', $inventory_sub_category_id)->where('status', 'un_countable')->get();
        return response()->json(['success' => 'success', 'un_items' => $un_items]);
    }

    public function inventory_uncountable_item_waste_save(Request $request)
    {
        //return $request;
        $inventory_id = $request->input('uncountable_item_id');
        $damage_quantity = $request->input('un_quantity');
        $damage_date = $request->input('un_date');
        $damage_reason = $request->input('un_reason');

        $inventory = Inventory::find($inventory_id);
        if ($inventory->quantity < $damage_quantity) {
            return response()->json(['error' => 'cannot_edit']);
        }
        $inventory->quantity = $inventory->quantity - $damage_quantity;
        $inventory->save();

        $waste = new Inventory_wastage();
        $waste->user_id = auth()->user()->id;
        $waste->hotel_id = auth()->user()->hotel_id;
        $waste->inventory_id = $inventory_id;
        $waste->inventory_item_name = $inventory->name;
        $waste->quantity = $damage_quantity;
        $waste->reason = $damage_reason;
        $waste->date = $damage_date;
        if ($image = $request->file('un_waste_image')) {
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/inventory/waste/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $waste->image = $path;
        }
        $waste->save();

        $inventory_items = Inventory_item::where('inventory_id', $inventory_id)->where('status', '!=', 'Block')->limit($damage_quantity)->get();
        foreach ($inventory_items as $inventory_item) {
            $inventory_items_save = Inventory_item::find($inventory_item->id);
            $inventory_items_save->status = 'Block';
            $inventory_items_save->save();
        }
        \LogActivityInventory::addToLog('INVENTORY ITEM DAMAGE (UN-COUNTABLE)', $damage_date, 'INVENTORY ITEM DAMAGE (UN-COUNTABLE)', null, $waste->id, null, $damage_quantity, $inventory->quantity, Auth::id(), 'Add Items Damage', $inventory->id, null, null);

        $inventory_damages = Inventory_wastage::with('user')->find($waste->id);
        return response()->json(['success' => 'success', 'inventory_damages' => $inventory_damages]);
    }

    public function remove_inventory_damage_record(Request $request)
    {
        $damage_id = $request->input('damage_id');
        $inventory_damages = Inventory_wastage::find($damage_id);
        if ($inventory_damages->quantity != NULL) {

            $inventory = Inventory::find($inventory_damages->inventory_id);
            $inventory->quantity = $inventory->quantity + $inventory_damages->quantity;
            $inventory->save();

            $inventory_items = Inventory_item::where('inventory_id', $inventory_damages->inventory_id)->where('status', 'Block')->limit($inventory_damages->quantity)->get();
            foreach ($inventory_items as $inventory_item) {
                $inventory_items_save = Inventory_item::find($inventory_item->id);
                $inventory_items_save->status = 'Active';
                $inventory_items_save->save();
            }
            \LogActivityInventory::addToLog('INVENTORY ITEM DAMAGE DELETE (UN-COUNTABLE)', $inventory_damages->date, 'INVENTORY ITEM DAMAGE DELETE (UN-COUNTABLE)', null, $inventory_damages->id, $inventory_damages->quantity, null, $inventory->quantity, Auth::id(), 'Add Items Damage record delete', $inventory->id, null, null);

        } else {
            $inventory = Inventory::find($inventory_damages->inventory_id);
            $inventory->quantity = $inventory->quantity + 1;
            $inventory->save();
            $inventory_items = Inventory_item::find($inventory_damages->inventory_item_id);
            $inventory_items->status = 'Active';
            $inventory_items->save();
            \LogActivityInventory::addToLog('INVENTORY ITEM DAMAGE DELETE (COUNTABLE)', $inventory_damages->date, 'INVENTORY ITEM DAMAGE DELETE (COUNTABLE)', null, $inventory_damages->id, 1, null, $inventory->quantity, Auth::id(), 'Add Items Damage record delete', $inventory->id, null, null);
        }
        Storage::delete($inventory_damages->image);
        $inventory_damages->delete();
        return response()->json(['success' => 'success']);
    }

    public function get_inventory_damage_record_detail(Request $request)
    {
        $inventory_damage_id = $request->input('damage_id');
        $inventory_damages = Inventory_wastage::with('inventory')->find($inventory_damage_id);
        $inventory_subcategories = Inventory_sub_category::where('inventory_category_id', $inventory_damages->inventory->inventory_category_id)->get();
        $inventory_item = Inventory::where('inventory_sub_category_id', $inventory_damages->inventory->inventory_sub_category_id)->get();
        return response()->json(['success' => 'success', 'inventory_damages' => $inventory_damages, 'inventory_subcategories' => $inventory_subcategories, 'inventory_item' => $inventory_item]);
    }

    public function edit_inventory_item_waste_save(Request $request)
    {

        $inventory_damage_id = $request->input('e_u_w_item_id');
        $inventory_damage_date = $request->input('e_u_date');
        $inventory_damage_reason = $request->input('e_u_reason');

        $inventory_damage = Inventory_wastage::find($inventory_damage_id);
        $inventory_damage->date = $inventory_damage_date;
        $inventory_damage->reason = $inventory_damage_reason;
        if ($image = $request->file('u_e_waste_image')) {
            Storage::delete($inventory_damage->image);
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/inventory/waste/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $inventory_damage->image = $path;
        }
        $inventory_damage->save();
        $inventory_damages = Inventory_wastage::with('user')->find($inventory_damage->id);
        return response()->json(['success' => 'success', 'inventory_damages' => $inventory_damages]);
    }

    public function edit_inventory_uncountable_item_waste_save(Request $request)
    {
        $inventory_damage_id = $request->input('e_un_w_damage_id');
        $inventory_item_id = $request->input('e_uncountable_item_id');
        $inventory_damage_quantity = $request->input('e_un_quantity');
        $inventory_damage_reason = $request->input('e_un_reason');
        $inventory_damage_date = $request->input('e_un_date');

        $inventory_damage = Inventory_wastage::find($inventory_damage_id);
        $inventory_damage->date = $inventory_damage_date;
        $inventory_damage->reason = $inventory_damage_reason;
        if ($image = $request->file('un_e_waste_image')) {
            Storage::delete($inventory_damage->image);
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile('/inventory/waste/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $inventory_damage->image = $path;
        }

        $inventory = Inventory::find($inventory_damage->inventory_id);
        $change_amount = $inventory_damage_quantity - $inventory_damage->quantity;

        if ($change_amount > 0) {
            if ($inventory->quantity < $change_amount) {
                return response()->json(['error' => 'cannot_edit']);
            }
            $inventory->quantity = $inventory->quantity - $change_amount;
            $inventory->save();
            $inventory_items = Inventory_item::where('inventory_id', $inventory_item_id)->where('status', '!=', 'Block')->limit($change_amount)->get();
            foreach ($inventory_items as $inventory_item) {
                $inventory_items_save = Inventory_item::find($inventory_item->id);
                $inventory_items_save->status = 'Block';
                $inventory_items_save->save();
            }
            \LogActivityInventory::addToLog('INVENTORY ITEM DAMAGE RECORD EDIT', $inventory_damage_date, 'INVENTORY ITEM DAMAGE RECORD EDIT', null, $inventory_damage->id, null, $change_amount, $inventory->quantity, Auth::id(), 'Add Items Damage record edit', $inventory->id, null, null);
        } elseif ($change_amount < 0) {
            $plus_change_amount = (-1) * $change_amount;
            $inventory->quantity = $inventory->quantity - $change_amount;
            $inventory->save();

            $inventory_items = Inventory_item::where('inventory_id', $inventory_item_id)->where('status', 'Block')->limit($plus_change_amount)->get();
            foreach ($inventory_items as $inventory_item) {
                $inventory_items_save = Inventory_item::find($inventory_item->id);
                $inventory_items_save->status = 'Active';
                $inventory_items_save->save();
            }
            \LogActivityInventory::addToLog('INVENTORY ITEM DAMAGE RECORD EDIT', $inventory_damage_date, 'INVENTORY ITEM DAMAGE RECORD EDIT', null, $inventory_damage->id, $plus_change_amount, null, $inventory->quantity, Auth::id(), 'Add Items Damage record edit', $inventory->id, null, null);

        }
        $inventory_damage->quantity = $inventory_damage_quantity;
        $inventory_damage->save();

        $inventory_damages = Inventory_wastage::with('user')->find($inventory_damage->id);
        return response()->json(['success' => 'success', 'inventory_damages' => $inventory_damages]);

    }

    public function kot_view()
    {
        $invoices = Order_list::with('order_list_detail')->where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.kot_view', ['invoices' => $invoices]);
    }

    public function kot_view_order(Request $request)
    {
        $order_list_id = $request->input('id');
        $invoice = Order_list::with('order_list_detail','user','table')->where('hotel_id', auth()->user()->hotel_id)->find($order_list_id);
        $output = view('hotel.render_for_ajax.kot_view_order', ['invoice' => $invoice])->render();
//$output = '';
        return response()->json(['output' => $output, 'invoice' => $invoice]);

//        return view('hotel.kot_view' ,['invoices' => $invoices]);
    }

    public function getkot(Request $request)
    {
        Log::info('w1'.$request);
        if ($request->ajax()) {
            $data = Order_list::select(['id', 'customer_name', 'status', 'total', 'updated_at', 'restaurant_id', 'table_id', 'steward_id'])->with('restaurant','table')->orderBy('id', 'ASC')->orderBy('status', 'ASC')->where('hotel_id', auth()->user()->hotel_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" onclick="view_order(\'' . $row->id . '\')" class="btn btn-dim btn-sm btn-primary">View</button>';
                    return $actionBtn;
                    Log::info('w1'.$actionBtn);
                })
                ->addColumn('date', function ($row) {
                    $actionBtn = $row->updated_at->diffForHumans();
                    return $actionBtn;
                })
                ->addColumn('restaurant', function ($row) {
                    $restaurant = $row->restaurant['name'];
                    return $restaurant;
                })
                ->addColumn('table', function ($row) {
                    $table = $row->table['table_name'];
                    return $table;
                })
//                ->addColumn('user', function ($row) {
//                    $user = $row->user['name'];
//                    return $user;
//                })
                ->addColumn('user', function ($row) {
                    if ($row->user) {
                        $user = $row->user->name . ' ' . $row->user->lname;
                    } else {
                        $user = '';
                    }
                    return $user;
                })
                ->addColumn('statusx', function ($row) {
                    $actionBtn = 'Fuck';
                    if ($row->status == 'Complete')
                        $actionBtn = '<span class="badge badge-dot bg-success">Complete</span>';
                    elseif ($row->status == 'Processing')
                        $actionBtn = '<span class="badge badge-dot bg-warning">Processing</span>';
                    else
                        $actionBtn = '<span class="badge badge-dot bg-danger">' . $row->status . '</span>';

                    return $actionBtn;
                })
                ->rawColumns(['action', 'statusx', 'date', 'restaurant','table'])
                ->make(true);
        }
    }

    public function inventory_item_history(Request $request)
    {
        $item_id = $request->input('item_id');
        $get_item = Inventory::find($item_id);
        $log_details = LogActivityInventory::with('user')->where('item_id', $item_id)->get();
        $output = view('hotel.render_for_ajax.inventory_history_list', ['log_details' => $log_details, 'item' => $get_item])->render();
        return response()->json(['txt' => $output, 'item' => $get_item]);
    }

    public function cashbook_setting_view()
    {
        $users = User::where('hotel_id', auth()->user()->hotel_id)->get();
        $cash_books = Cashbook::with('assigned_users.user')->where('hotel_id', auth()->user()->hotel_id)->get();
        //return $cash_books;
        return view('hotel.cash_book_setting', ['users' => $users, 'cash_books' => $cash_books]);
    }

    public function cashbook_save(Request $request)
    {
        $start = Carbon::now()->startOfMonth();
        $sub_yesr = Carbon::now()->startOfMonth()->subYear();

        $book_name = $request->input('book_name');

        $book_details = new Cashbook();
        $book_details->hotel_id = auth()->user()->hotel_id;
        $book_details->status = 'Active';
        $book_details->name = $book_name;

        $book_details->save();
        $user_ids = $request->input('users');
        $cashbook = Cashbook::find($book_details->id);
        $cashbook->users()->sync($user_ids);

        while ($start->gte($sub_yesr)) {
            $cashbook_sync = new Cashbook_monthly_record();
            $cashbook_sync->date = $sub_yesr;

            $cashbook_sync->balance = 0;
            $cashbook_sync->total_debit = 0;
            $cashbook_sync->total_credit = 0;
            $cashbook_sync->cashbook_id = $cashbook->id;
            $cashbook_sync->save();
            $sub_yesr = $sub_yesr->addMonth();
        }
        return response()->json(['success' => 'success', 'book_details' => $book_details]);
    }

    public function get_cashbook_details(Request $request)
    {
        $book_id = $request->input('book_id');
        $cash_books = Cashbook::with('assigned_users.user')->where('id', $book_id)->first();
        return response()->json(['success' => 'success', 'cash_books' => $cash_books]);
    }

    public function edit_cash_book_save(Request $request)
    {
        $book_id = $request->input('e_book_id');
        $book_name = $request->input('e_book_name');

        $book_details = Cashbook::find($book_id);
        $book_details->name = $book_name;
        $book_details->save();

        $user_ids = $request->input('eusers');
        $cashbook = Cashbook::find($book_id);
        $cashbook->users()->sync($user_ids);

        return response()->json(['success' => 'success', 'book_details' => $book_details]);

    }

    public function show_cash_book($id)
    {
        $start_month = Carbon::now()->startOfMonth();
        $end_month = Carbon::now()->endOfMonth();

        $cash_books = Cash_book_log_activity::where('cashbook_id', $id)->where('hotel_id', auth()->user()->hotel_id)
            ->whereBetween('date', [$start_month, $end_month])->orderBy('date', 'ASC')->get();

        $last_month_balance = Cashbook_monthly_record::where('cashbook_id', $id)->where('date', $start_month)->first();

        //return $last_month_balance;
        return view('hotel.cash_book', ['cash_books' => $cash_books, 'cash_book_id' => $id, 'last_month_balance' => $last_month_balance]);
    }

    public function cash_book_add_debit(Request $request)
    {
        $debit_amount = $request->input('debit_money');
        $csh_book_id = $request->input('cash_book_id');
        $description = $request->input('description');
        $date = $request->input('date');

        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit' . ' ' . '(' . $debit_amount . ') ' . 'Description: ' . $description;

        $cash_debit = new Cash_book_log_activity();
        $cash_debit->cashbook_id = $csh_book_id;
        $cash_debit->hotel_id = auth()->user()->hotel_id;
        $cash_debit->debit = $debit_amount;
        $cash_debit->status = 'Active';
        $cash_debit->date = $date;
        $cash_debit->user_id = auth()->user()->id;
        $cash_debit->remark = $remark;
        $cash_debit->debit_reason = $description;
        $cash_debit->save();
        \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');

        return response()->json(['success' => 'success', 'cash_debit' => $cash_debit]);
    }

    public function get_cashbook_log_details(Request $request)
    {
        $log_id = $request->input('log_id');
        $cash_book_log = Cash_book_log_activity::find($log_id);
        return response()->json(['success' => 'success', 'cash_book_log' => $cash_book_log]);
    }

    public function cash_book_edit_debit(Request $request)
    {

        $log_id = $request->input('cash_book_log_id');
        $date = $request->input('e_date');
        $debit_amount = $request->input('e_debit_money');
        $description = $request->input('e_description');

        $this_month = Carbon::now()->startOfMonth();
        $cash_book_log = Cash_book_log_activity::find($log_id);

        $date_record = new Carbon($cash_book_log->date);
        $date_record2 = new Carbon($cash_book_log->date);
        $date_record3 = $date_record2->startOfMonth();
        $cash_book_date = $date_record->startOfMonth()->addMonth();
        $cash_book_monthly = Cashbook_monthly_record::where('date', $cash_book_date)->where('cashbook_id', $cash_book_log->cashbook_id)->first();

        if ($cash_book_log->date == $date) {
            if ($date_record3 != $this_month) {
                $cash_book_monthly->total_debit = $cash_book_monthly->total_debit - $cash_book_log->debit;
                $cash_book_monthly->balance = $cash_book_monthly->balance - $cash_book_log->debit;
                $cash_book_monthly->save();
            }
            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Debit Amount' . ' ' . '(' . $cash_book_log->debit . '=>' . $debit_amount . ') ' . 'Description: ' . $description;
            $change_amount = $debit_amount - $cash_book_log->debit;
            $updated_debit_amount = $cash_book_log->debit + $change_amount;
            $cash_book_log->debit = $updated_debit_amount;
            $cash_book_log->remark = $remark;
            $cash_book_log->debit_reason = $description;
            $cash_book_log->save();
            \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Debit');

        } elseif ($cash_book_log->date != $date) {

            \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Delete');
            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change Debit Amount Date' . ' ' . '(' . $cash_book_log->debit . '=>' . $debit_amount . ') ' . 'Description: ' . $description;

            $change_amount = $debit_amount - $cash_book_log->debit;
            $updated_debit_amount = $cash_book_log->debit + $change_amount;
            $cash_book_log->date = $date;
            $cash_book_log->debit = $updated_debit_amount;
            $cash_book_log->remark = $remark;
            $cash_book_log->debit_reason = $description;
            $cash_book_log->save();
            \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Debit');
        }
        return response()->json(['success' => 'success', 'cash_book_log' => $cash_book_log]);
    }

    public function cash_book_record_delete(Request $request)
    {
        $log_id = $request->input('log_id');

        $cash_book_log = Cash_book_log_activity::find($log_id);
        $cash_book_log->status = 'Delete';
        $cash_book_log->save();

        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Deleted Record' . ' ' . '(' . $cash_book_log->debit . ')';
        $cash_book_log->remark = $remark;
        $cash_book_log->save();

        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Delete');


        return response()->json(['success' => 'success', 'cash_book_log' => $cash_book_log]);
    }

    public function reservation_view(Request $request)
    {
        $reservation = Reservation::with(['reservation_rooms'])->where('hotel_id',auth()->user()->hotel_id)->orderBy('id', 'DESC')->get();
//        $cash_books = Cashbook::where('hotel_id',auth()->user()->hotel_id)->get();
//        return $reservation;
        $rooms = Room::where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.reservation_view', ['reservations' => $reservation, 'rooms' => $rooms]);
    }

    public function getresvertion(Request $request)
    {
//        if ($request->ajax()) {
//            $draw = $request->input('draw');
//            $start = $request->input('start');
//            $length = $request->input('length', 20);
//            Log::info('w1'.$start);
//
//            // ... other parameters
//
//            // Query your database based on $start and $length
//            $data = Reservation::with(['reservation_rooms'])
//                ->where('hotel_id', auth()->user()->hotel_id)
//
//                ->skip($start)
//                ->take($length)
//                ->orderBy('id', 'DESC')
//                ->get();
//            foreach ($data as $reservation) {
//                $reservation->hotel_invoice = \App\Hotel_invoice::where('reservation_id', $reservation->id)->first();
//                Log::info('w1'.$reservation->hotel_invoice);
//            }
//
//
//            foreach ($data as $row) {
//                $actionBtn = '';
//
//                // Add your condition here, modify as needed
//                if ($row->room_type1 == 'Booked') {
//                    $actionBtn .= '<span >Cabana</span>';
//                }
//
//                elseif ($row->room_type2 == 'Booked') {
//                    // Append a comma if $actionBtn is not empty
//                    $actionBtn .= ($actionBtn ? ', ' : '') . '<span >Deluxe Double</span>';
//                }
//
//                elseif ($row->room_type3 == 'Booked') {
//                    // Append a comma if $actionBtn is not empty
//                    $actionBtn .= ($actionBtn ? ', ' : '') . '<span>Deluxe Triple</span>';
//                }
//
//                // Additional logic for room numbers
//                $roomNumbers = implode(', ', $row->reservation_rooms->pluck('room.room_number')->toArray());
//                $actionBtn .= '[' . $roomNumbers . ']';
//
//                // Add $actionBtn to $row
//                $row->actionBtn = $actionBtn;
//            }
//
//
//            $response = [
//                'draw' => $draw,
//                'data' => $data, // Data to be displayed
//
//
//            ];
//
//            return response()->json($response);
//
//
//
//        }



        if ($request->ajax()) {


            $data = Reservation::with(['reservation_rooms'])
                ->select(['id', 'first_name', 'last_name', 'booking_method', 'address', 'country', 'passport_number', 'email','phone','whatsapp_number','check_in_date','check_out_date',
                    'room_type1','guests','nights','room_type2','room_type3','room_chagers_lkr','room_chagers_usd','special_note','breakfast'])

                ->where('hotel_id', auth()->user()->hotel_id)
               // ->orderBy('check_in_date', 'DESC')
               ->orderBy('id', 'DESC')
                ->get();
            \Log::info($data);

            \Log::info('Ajax request received.');



            return DataTables::of($data)



                ->addIndexColumn()
                ->addColumn('action', function ($row)  {
                    $privilege = \App\
                    Privilege::where('user_id',auth()->user()->id)->where('hotel_id',auth()->user()->hotel_id)->where('hotel_chain_id',auth()->user()->hotel_chain_id)->first();
                    $buttonsHtml = '';

                    if(auth()->user()->role == 'Admin' or $privilege->reservation_edit == 'Allow') {
                        $buttonsHtml .= '<a class="btn btn-trigger btn-icon updateRecordButton" data-reservationid="' . $row->id . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Reservation"><em class="icon ni ni-pen2"></em></a>';
                    }

                    if(auth()->user()->role == 'Admin' or $privilege->reservation_delete == 'Allow') {
                        $buttonsHtml .= '<div class="dropdown">';
                        $buttonsHtml .= '<a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-sign-xrp-new-alt"></em></a>';
                        $buttonsHtml .= '<div class="dropdown-menu dropdown-menu-end dropdown-menu-xs" style="">';
                        $buttonsHtml .= '<ul class="link-list-plain">';
                        $buttonsHtml .= '<li><a class="deleteRecordButton" data-reservationid="' . $row->id . '">Yes</a></li>';
                        $buttonsHtml .= '<li><a>No</a></li>';
                        $buttonsHtml .= '</ul>';
                        $buttonsHtml .= '</div>';
                    }

                    $buttonsHtml .= '<a class="btn btn-trigger btn-icon" href="' . route('hotel/reservation/invoice', ['reservation_id' => $row->id]) . '"><em class="icon ni ni-eye"></em></a>';
                    $buttonsHtml .= '<a class="btn btn-trigger btn-icon" href="' . route('hotel/reservation/invoice/pdf', ['reservation_id' => $row->id]) . '"><em class="icon ni ni-printer-fill"></em></a>';

                    $buttonsHtml .= '<a class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice Send Email" onclick="invoice_emaill_confirm(' . $row->id . ', \'' . $row->email . '\')"><em class="icon ni ni-send-alt"></em></a>';
                    if($row->booking_sync != 'Yes' and $row->booking_method == 'Walk-in'){
                        $buttonsHtml.= ' <a class="btn btn-trigger btn-icon" href="'.route('hotel/reservation/sync_booking',['reservation_id'=>$row->id]).' data-bs-toggle="tooltip" data-bs-placement="top" title="Sync with booking" ><em class="icon ni ni-repeat"></em></a>';
                    }
                    return $buttonsHtml;
                })

               ->addColumn('sortid', function ($row) {
                   $hotel_invoice = \App\Hotel_invoice::where('reservation_id', $row->id)->first();
                  $class = (!!$hotel_invoice && ($hotel_invoice->room_chargers == null || ($hotel_invoice->room_payment + $hotel_invoice->advance_payment) != $hotel_invoice->room_chargers)) ? 'text-danger' : '';

                  return '<span class="' . $class . '">' . $row->id . '</span>';
               })


                ->addColumn('user', function ($row) {
                    $checkInDate = new \DateTime($row->check_in_date);
                    $checkOutDate = new \DateTime($row->check_out_date);
                    $now = new \DateTime();

                    $badgeHtml = '';

                    if ($checkInDate <= $now && $checkOutDate >= $now) {
                        $badgeHtml = '<span class="badge badge-dot badge-dot-xs bg-success">&nbsp;</span>'; // Staying
                    } elseif ($checkOutDate->format('Y-m-d') == $now->format('Y-m-d')) {
                        $badgeHtml = '<span class="badge badge-dot badge-dot-xs bg-warning">&nbsp;</span>'; // Checkout today
                    } elseif ($checkOutDate < $now) {
                        $badgeHtml = '<span class="">&nbsp;&nbsp;</span>'; // Left
                    } else {
                        $badgeHtml = '<span class="badge badge-dot badge-dot-xs bg-danger">&nbsp;</span>'; // Not arrived yet
                    }

                    return $badgeHtml . ' ' . $row->first_name . ' ' . $row->last_name;
                })
//                ->addColumn('booking_method', function ($row) {
//                    $booking_method = $row->booking_method;
//                    return $booking_method;
//                })
//                ->addColumn('country', function ($row) {
//                    $country = $row->country;
//                    return $country;
//                })
//                ->addColumn('passport_number', function ($row) {
//                    $passport_number = $row->passport_number;
//                    return $passport_number;
//                })
                ->addColumn('email', function ($row) {
                    $email = $row->email;
                    return $email;
                })
                ->addColumn('whatsapp_number', function ($row) {
                    $whatsapp_number = '';
                    $whatsapp_number .= '<a href="https://wa.me/' . $row->whatsapp_number . '?text=Hey there! It\'s the Management team at Ravan Tangalle checking in. We want to make sure everything\'s going great during your stay. Mind giving us some quick feedback on the room and our staff? We\'re all ears!">' . $row->whatsapp_number . '</a>';
                    if (auth()->user()->role === 'Admin') {
                        $whatsapp_number .= '<a class="btn btn-trigger btn-icon whatsapp_edit_btn" data-reservationid="' . $row->id . '" data-whatsappnumber="' . $row->whatsapp_number . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Whatsapp number"><em class="icon ni ni-pen2"></em></a>';
                    } else {
                        // You can add code here for the case when the user's role is not 'Admin'
                    }
                    return $whatsapp_number;
                })
                ->addColumn('room_type', function ($row) {

                    $actionBtn = '';
                    if ($row->room_type1 == 'Booked') {
                        $actionBtn .= '<span >Cabana</span>';
                    }

                    elseif ($row->room_type2 == 'Booked') {
                        // Append a comma if $actionBtn is not empty
                        $actionBtn .= ($actionBtn ? ', ' : '') . '<span >Deluxe Double</span>';
                    }

                    elseif ($row->room_type3 == 'Booked') {
                        // Append a comma if $actionBtn is not empty
                        $actionBtn .= ($actionBtn ? ', ' : '') . '<span>Deluxe Triple</span>';
                    }

                    // Additional logic for room numbers
                    $roomNumbers = implode(', ', $row->reservation_rooms->pluck('room.room_number')->toArray());
                    $actionBtn .= '[' . $roomNumbers . ']';

                    $class = $row->room_chagers_lkr == null ? 'text-danger' : '';
                    $actionBtn = '<div class="' . $class . '">' . $actionBtn . '</div>';

                    // Add $actionBtn to $row
                    $row->actionBtn = $actionBtn;
                    return $actionBtn;
                })

//                ->addColumn('phone', function ($row) {
//                    $phone = $row->whatsapp_number;
//                    return $phone;
//                })
//                ->addColumn('breakfast', function ($row) {
//                    $breakfast = $row->breakfast;
//                    return $breakfast;
//                })
//                ->addColumn('special_note', function ($row) {
//                    $special_note = $row->special_note;
//                    return $special_note;
////                })
//                ->addColumn('check_in_date', function ($row) {
//                    $check_in_date = $row->check_in_date;
//
//                    return $check_in_date;
//                })
                ->addColumn('check_out_date', function ($row) {
                    $check_out_date_btn = '';
                    $check_out_date_btn = $row->check_out_date;
                    $check_out_date_btn .= "<a href=\"javascript:void(0)\" class=\"btn btn-trigger btn-icon\" onclick=\"extend_checkut_date_load('{$row->id}', '{$row->check_out_date}')\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Edit check out date\"><em class=\"icon ni ni-pen2\"></em></a>";


                    return $check_out_date_btn;
                })
//                ->addColumn('nights', function ($row) {
//                    $nights = $row->nights;
//                    return $nights;
//                })
//                ->addColumn('room_chagers_lkr', function ($row) {
//                    $room_chagers_lkr = $row->room_chagers_lkr;
//                    return $room_chagers_lkr;
//                })
//                ->addColumn('room_chagers_usd', function ($row) {
//                    $room_chagers_usd = $row->room_chagers_usd;
//                    return $room_chagers_usd;
//                })
                ->rawColumns(['action','sortid','room_type','user','whatsapp_number','check_out_date'])

                ->make(true);
        }





    }





























    public function reservation_sync_booking(Request $request)
    {
        $reservation_id = $request->input('reservation_id');
         $reservation = Reservation::with(['reservation_rooms'])->find($reservation_id);

        $booking = new Booking();
        $booking->first_name = $reservation->first_name;
        $booking->last_name = $reservation->last_name;
        $booking->phone = $reservation->phone;
        $booking->email = $reservation->email;
        $booking->total_person = $reservation->guests;
        $booking->country = $reservation->country;
        $booking->note = $reservation->special_note;
        $booking->adults = $reservation->guests;
        $booking->hotel_id = $reservation->hotel_id;
        $booking->w_number = $reservation->whatsapp_number;
       $booking->booking_method = $reservation->booking_method;
//        $booking->breakfast = $reservation->breakfast;
        $booking->passport = $reservation->passport_number;
        $booking->reservation_id = $reservation->id;
        $booking->checking_status = 'Checkin';
        $booking->booking_type  = 'Checkin';
        $booking->save();
        $reservation->booking_sync = 'Yes';
        $reservation->save();

        foreach ($reservation->reservation_rooms as $reservation_room){
            $booking_rooms = new Booking_room();
            $booking_rooms->booking_id = $booking->id;
            $booking_rooms->room_id = $reservation_room->room_id;
            $booking_rooms->save();
        }

        $room_categories = Room_category::where('hotel_id',$booking->hotel_id)->get();
        foreach ($room_categories as $room_category){

            $room_count_save= new Booking_room_count();
            $room_count_save->booking_id= $booking->id;
            $room_count_save->room_category_id=$room_category->id;
            $room_count_save->room_count=  $reservation->reservation_rooms->count();
            $room_count_save->save();
//                        $total= $total+$room_count_save->room_count;
        }
return redirect()->back()->with('success', 'Payment update success!');
        return view('hotel.reservation_view', ['reservations' => $reservation, 'rooms' => $rooms]);
    }

    public function room_invoice(Request $request)
    {
        $reservation_id = $request->input('reservation_id');
//        $reservation = Reservation::with(['reservation_rooms'])->find($reservation_id);
//        $hotel = Hotel::find(1);
//        return view('hotel.reservation_invoice_view', ['reservation' => $reservation,'hotel' => $hotel]);


        $hotel_invoice = Hotel_invoice::with('reservation.reservation_rooms')->where('reservation_id',$reservation_id)->first();
//        $invoice_id = $request->input('invoice_id');
        $invoices = Order_list::with('order_list_detail')
            ->where('reservation_id',$reservation_id)
            ->get();
        $hotel_invoice_payments = Hotel_invoice_payment::where('hotel_invoice_id',$hotel_invoice->id)->get();

        $hotel = Hotel::find(auth()->user()->hotel_id);
        return view('hotel.reservation_invoice_view',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);


    }

    public function room_invoice_pdf(Request $request)
    {
        $reservation_id = $request->input('reservation_id');
        $invoice_id = $request->input('invoice_id');
        $hotel_invoice = Hotel_invoice::with('reservation.reservation_rooms')->where('reservation_id',$reservation_id)->first();
        if(!$hotel_invoice)
            return redirect()->back()->with('error', 'Old  invoices cannot print');
        $invoices = Order_list::with('order_list_detail')
            ->where('reservation_id',$hotel_invoice->reservation_id)
            ->get();
        $hotel_invoice_payments = Hotel_invoice_payment::where('hotel_invoice_id',$invoice_id)->get();

        $hotel = Hotel::find(auth()->user()->hotel_id);
//        return view('hotel.hotel_invoice_print',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);

        $pdf = Facade\Pdf::loadView('hotel.hotel_invoice_print',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);
        return $pdf->download('invoice.pdf');
//        $reservation = Reservation::with(['reservation_rooms'])->find($reservation_id);
//        $hotel = Hotel::find(1);
//
//        $pdf = Facade\Pdf::loadView('hotel.reservation_invoice_print', ['reservation' => $reservation,'hotel' => $hotel]);
//        return $pdf->download('invoice.pdf');
//        return view('hotel.reservation_invoice_print', ['reservation' => $reservation,'hotel' => $hotel]);
    }

    public function room_invoice_send(Request $request)
    {

        $reservation_id = $request->input('reservation_id');
        $reservation_email = $request->input('email');
        $hotel_invoice = Hotel_invoice::with('reservation.reservation_rooms')->where('reservation_id',$reservation_id)->first();
        if(!$hotel_invoice)
            return redirect()->back()->with('error', 'Old  invoices cannot send');
        $invoices = Order_list::with('order_list_detail')
            ->where('reservation_id',$hotel_invoice->reservation_id)
            ->get();
        $hotel_invoice_payments = Hotel_invoice_payment::where('hotel_invoice_id',$hotel_invoice->id)->get();

        $hotel = Hotel::find(auth()->user()->hotel_id);

        $pdf = Facade\Pdf::loadView('hotel.hotel_invoice_print',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);
        $pdf_file = base64_encode($pdf->output());

        $pdf_data = new \stdClass;
        $pdf_data->pdf = $pdf_file;
        $pdf_data->name = $hotel_invoice->reservation->first_name.' '.$hotel_invoice->reservation->last_name;

        Mail::to($reservation_email)
            ->cc('indikaribelz@gmail.com')
           // ->cc('gayanmadumal97@gmail.com')
            ->send(new Invoice($pdf_data));
return redirect()->back()->with('success', 'Invoice has been send!');
        return response()->json(['success' => $pdf_data]);

//
//        $reservation_id = $request->input('reservation_id');
//        $reservation_email = $request->input('email');
//        $reservation = Reservation::with(['reservation_rooms'])->find($reservation_id);
//        $hotel = Hotel::find(1);
//
//        $pdf = Facade\Pdf::loadView('hotel.reservation_invoice_print', ['reservation' => $reservation,'hotel' => $hotel]);
//        $pdf_file = base64_encode($pdf->output());
//
//        $pdf_data = new \stdClass;
//        $pdf_data->pdf = $pdf_file;
//        $pdf_data->name = $reservation->first_name.' '.$reservation->last_name;
//
//        Mail::to($reservation_email)
//            ->cc('indikaribelz@gmail.com')
//            ->send(new Invoice($pdf_data));
//
//        return response()->json(['success' => $pdf_data]);

    }


    public function room_invoice_send_another(Request $request)
    {

        $reservation_id = $request->input('reservation_id');
        $reservation_email = $request->input('email');
        $hotel_invoice = Hotel_invoice::with('reservation.reservation_rooms')->where('reservation_id',$reservation_id)->first();
        if(!$hotel_invoice)
            return redirect()->back()->with('error', 'Old  invoices cannot send');
        $invoices = Order_list::with('order_list_detail')
            ->where('reservation_id',$hotel_invoice->reservation_id)
            ->get();
        $hotel_invoice_payments = Hotel_invoice_payment::where('hotel_invoice_id',$hotel_invoice->id)->get();

        $hotel = Hotel::find(auth()->user()->hotel_id);

        $pdf = Facade\Pdf::loadView('hotel.hotel_invoice_print',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);
        $pdf_file = base64_encode($pdf->output());

        $pdf_data = new \stdClass;
        $pdf_data->pdf = $pdf_file;
        $pdf_data->name = $hotel_invoice->reservation->first_name.' '.$hotel_invoice->reservation->last_name;

        Mail::to($reservation_email)
            //->cc('indikaribelz@gmail.com')
            // ->cc('gayanmadumal97@gmail.com')
            ->send(new Invoice($pdf_data));
        return redirect()->back()->with('success', 'Invoice has been send!');
        return response()->json(['success' => $pdf_data]);

//
//        $reservation_id = $request->input('reservation_id');
//        $reservation_email = $request->input('email');
//        $reservation = Reservation::with(['reservation_rooms'])->find($reservation_id);
//        $hotel = Hotel::find(1);
//
//        $pdf = Facade\Pdf::loadView('hotel.reservation_invoice_print', ['reservation' => $reservation,'hotel' => $hotel]);
//        $pdf_file = base64_encode($pdf->output());
//
//        $pdf_data = new \stdClass;
//        $pdf_data->pdf = $pdf_file;
//        $pdf_data->name = $reservation->first_name.' '.$reservation->last_name;
//
//        Mail::to($reservation_email)
//            ->cc('indikaribelz@gmail.com')
//            ->send(new Invoice($pdf_data));
//
//        return response()->json(['success' => $pdf_data]);

    }



    public function aditionalwifi_send(Request $request)
    {
        $email = $request->input('email');
        $wifi_password_id = $request->input('wifi_password_id');

        $maildetail = new \stdClass;
        $maildetail->wifi_id = $wifi_password_id;

        Mail::to($email)->send(new Aditionalwifi($maildetail));
        return redirect()->back();
//        return $request;

    }
    public function reservation_delete(Request $request)
    {
        $id = $request->input('reservation_id');
        $reservation = Reservation::find($id);
        $reservation->delete();

        $inv = Hotel_invoice::where('reservation_id' ,$id)->first();
        $inv->delete();
        return response()->json(['success' => $reservation]);

    }

    public function get_cash_book_monthly_record(Request $request)
    {
       $selected_date = $request->input('selected_date');

        $cash_book_id = $request->input('cash_book_id');
        $d_m_obj_start = new Carbon($selected_date);
        $d_m_obj_end = new Carbon($selected_date);

        $start_month = $d_m_obj_start->startOfMonth();
        $end_month = $d_m_obj_end->endOfMonth();
        $startDate = Carbon::parse($start_month)->format('Y-m-d');
        $endDate = Carbon::parse($end_month)->format('Y-m-d');
     //return $startDate;
        $cash_books = Cash_book_log_activity::where('cashbook_id', $cash_book_id)->where('hotel_id', auth()->user()->hotel_id)
            ->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'ASC')->get();

        $last_month_balance = Cashbook_monthly_record::where('cashbook_id', $cash_book_id)->where('date', $start_month)->first();

        return response()->json(['success' => 'success', 'cash_books' => $cash_books, 'last_month_balance' => $last_month_balance]);
    }

    public function cash_book_withdarw_money(Request $request)
    {
        $date = $request->input('c_date');
        $cash_book_id = $request->input('cash_book_id');
        $reason = $request->input('reason');
        $credit_amount = $request->input('credit_money');

        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Withdraw Money' . ' ' . '(' . $credit_amount . ')' . 'reason : ' . $reason;

        $cash_book_log = new Cash_book_log_activity();
        $cash_book_log->cashbook_id = $cash_book_id;
        $cash_book_log->hotel_id = auth()->user()->hotel_id;
        $cash_book_log->credit = $credit_amount;
        $cash_book_log->date = $date;
        $cash_book_log->user_id = auth()->user()->id;
        $cash_book_log->remark = $remark;
        $cash_book_log->reason = $reason;
        $cash_book_log->status = 'Active';
        $cash_book_log->save();

        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Credit');

        return response()->json(['success' => 'success', 'cash_book_log' => $cash_book_log]);
    }

    public function reservation_get(Request $request)
    {
        $id = $request->input('reservation_id');
        \Illuminate\Support\Facades\Log::info('r' . $id);
        $reservation = Reservation::with('reservation_rooms.room')->find($id);
        \Illuminate\Support\Facades\Log::info('r' . $reservation);
        $booking_rooms = Booking::with('booking_room_count.room_categories','booking_rooms.room')->where('reservation_id',$id)->first();
        return response()->json(['reservation' => $reservation,'booking_rooms'=>$booking_rooms]);
    }

    public function reservation_save(Request $request)
    {
        $id = $request->input('edit_res_id');
        $card_payment = $request->input('card_chagers_lkr');
        $cash_payment = $request->input('cash_chagers_lkr');
        $advanced_payment = $request->input('advance_chagers_lkr');
        $room_chagers = $request->input('room_chagerss_lkr');



        $reservation = Reservation::find($id);
        \Illuminate\Support\Facades\Log::info('r' . $reservation);


        $cash_old_value = $reservation->cash_payment;
        $card_old_value = $reservation->card_payment;
        $advance_old_value = $reservation->advance_payment;

        $reservation->room_chagers_usd = $request->input('room_chagers_usd');
        $reservation->room_chagers_lkr = $request->input('room_chagerss_lkr');
        $reservation->card_payment = $card_payment;
        $reservation->cash_payment = $cash_payment;
        $reservation->advance_payment = $advanced_payment;
        $reservation->save();








        $hotel_invoice = Hotel_invoice::where('reservation_id' ,$id)->first();
        $hotel_invoice->room_chargers = $request->input('room_chagerss_lkr');
        $hotel_invoice->advance_payment = $advanced_payment;
        $hotel_invoice->save();

        $reservation_setting_record = Hotel_reservation_setting::where('hotel_id', auth()->user()->hotel_id)->first();
        $cash_book_activity_cash = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'cash')->first();
        $cash_book_activity_card = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'card')->first();
        $cash_book_activity_advance = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'advance')->first();

        if (!isset($cash_book_activity_card->reservation_id) and $card_payment != null) {
            //new
            $cash_book_id = $reservation_setting_record->card_payment;
            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit (Card Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $card_payment;
            $cash_debit = new Cash_book_log_activity();
            $cash_debit->cashbook_id = $cash_book_id;
            $cash_debit->hotel_id = auth()->user()->hotel_id;
            $cash_debit->debit = $reservation->card_payment;
            $cash_debit->status = 'Active';
            $cash_debit->type = 'card';
            $cash_debit->date = $reservation->updated_at->format('Y-m-d');
            $cash_debit->user_id = auth()->user()->id;
            $cash_debit->remark = $remark;
            $cash_debit->reservation_id = $reservation->id;
            $cash_debit->save();
            \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
        } else {
            if (isset($cash_book_activity_card->reservation_id) and $card_payment != $card_old_value) {
                if ($card_payment != null) {
                    //update
                    $cash_book_id = $reservation_setting_record->card_payment;
                    $cash_debit = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'card')->first();
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Debited Amount (Card Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $card_payment;
                    $cash_debit->cashbook_id = $cash_book_id;
                    $cash_debit->hotel_id = auth()->user()->hotel_id;
                    $cash_debit->debit = $reservation->card_payment;
                    $cash_debit->status = 'Active';
                    $cash_debit->type = 'card';
                    $cash_debit->date = $reservation->updated_at->format('Y-m-d');
                    $cash_debit->user_id = auth()->user()->id;
                    $cash_debit->remark = $remark;
                    $cash_debit->reservation_id = $reservation->id;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
                } else {
                    //delete
                    $cash_debit = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'card')->first();
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Clear Debited Amount (Card Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $cash_debit->debit;
                    $cash_debit->status = 'Delete';
                    $cash_debit->remark = $remark;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Delete');
                }
            }
        }

        if (!isset($cash_book_activity_cash->reservation_id) and $cash_payment != null) {
            //new
            $cash_book_id = $reservation_setting_record->cash_payment;
            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit (Cash Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $cash_payment;
            $cash_debit = new Cash_book_log_activity();
            $cash_debit->cashbook_id = $cash_book_id;
            $cash_debit->hotel_id = auth()->user()->hotel_id;
            $cash_debit->debit = $cash_payment;
            $cash_debit->status = 'Active';
            $cash_debit->type = 'cash';
            $cash_debit->date = $reservation->updated_at->format('Y-m-d');
            $cash_debit->user_id = auth()->user()->id;
            $cash_debit->reservation_id = $reservation->id;
            $cash_debit->remark = $remark;
            $cash_debit->save();
            \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
        } else {
            if (isset($cash_book_activity_cash->reservation_id) and $cash_payment != $cash_old_value) {
                if ($cash_payment != null) {
                    //update
                    $cash_book_id = $reservation_setting_record->cash_payment;
                    $cash_debit = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'cash')->first();
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Debited Amount (Cash Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $cash_payment;
                    $cash_debit->cashbook_id = $cash_book_id;
                    $cash_debit->hotel_id = auth()->user()->hotel_id;
                    $cash_debit->debit = $cash_payment;
                    $cash_debit->status = 'Active';
                    $cash_debit->type = 'cash';
                    $cash_debit->date = $reservation->updated_at->format('Y-m-d');
                    $cash_debit->user_id = auth()->user()->id;
                    $cash_debit->remark = $remark;
                    $cash_debit->reservation_id = $reservation->id;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
                } else {
                    //delete
                    $cash_debit = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'cash')->first();
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Clear Debited Amount (Cash Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $cash_debit->debit;
                    $cash_debit->status = 'Delete';
                    $cash_debit->remark = $remark;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Delete');
                }
            }
        }

        if (!isset($cash_book_activity_advance->reservation_id) and $advanced_payment != null) {



            //new
            $cash_book_id = $reservation_setting_record->advance_payment;
            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit (Advance Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $advanced_payment;
            $cash_debit = new Cash_book_log_activity();
            $cash_debit->cashbook_id = $cash_book_id;
            $cash_debit->hotel_id = auth()->user()->hotel_id;
            $cash_debit->debit = $advanced_payment;
            $cash_debit->status = 'Active';
            $cash_debit->type = 'advance';
            $cash_debit->date = $reservation->updated_at->format('Y-m-d');
            $cash_debit->user_id = auth()->user()->id;
            $cash_debit->reservation_id = $reservation->id;
            $cash_debit->remark = $remark;
            $cash_debit->save();
            \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
        } else {
            if (isset($cash_book_activity_advance->reservation_id) and $advanced_payment != $advance_old_value) {
                if ($advanced_payment != null) {
                    //update
//                    $hotel_invoice_payment = Hotel_invoice_payment::where('payment_method','Advanced Payment')->where('hotel_invoice_id',$hotel_invoice->id)->first();
//                    $hotel_invoice_payment->amount = $advanced_payment;
//                    $hotel_invoice_payment->save();

                    $cash_book_id = $reservation_setting_record->advance_payment;
                    $cash_debit = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'advance')->first();
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Debited Amount (Advance Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $advanced_payment;
                    $cash_debit->cashbook_id = $cash_book_id;
                    $cash_debit->hotel_id = auth()->user()->hotel_id;
                    $cash_debit->debit = $advanced_payment;
                    $cash_debit->status = 'Active';
                    $cash_debit->type = 'advance';
                    $cash_debit->date = $reservation->updated_at->format('Y-m-d');
                    $cash_debit->user_id = auth()->user()->id;
                    $cash_debit->remark = $remark;
                    $cash_debit->reservation_id = $reservation->id;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');
                } else {
                    //delete
//                    $hotel_invoice_payment = Hotel_invoice_payment::where('payment_method','Advanced Payment')->where('hotel_invoice_id',$hotel_invoice->id)->first();
//                    $hotel_invoice_payment->delete();

                    $cash_debit = Cash_book_log_activity::where('reservation_id', $reservation->id)->where('type', 'advance')->first();
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Clear Debited Amount (Advance Payment from Reservation' . '(' . $reservation->id . ') ' . 'Rs. ' . $cash_debit->debit;
                    $cash_debit->status = 'Delete';
                    $cash_debit->remark = $remark;
                    $cash_debit->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Delete');
                }
            }
        }
        $booking = Booking::where('reservation_id',$id)->first();
        if($booking) {
            $booking_roomsdel = Booking_room::where('booking_id', $booking->id)->delete();
            if($booking->booking_method ==='Offline'){
                   $booking->status = 'Approved';
                   $booking->total_amount= $request->input('room_chagerss_lkr');
                   $booking->advance_payment = $advanced_payment;
                   $booking->card_payment    =    $card_payment;
                   $booking->cash_payment    =  $cash_payment;
                   $booking->balance         = $room_chagers - $advanced_payment;

                   $booking->booking_type    = 'Night Stay';
                   $booking->save();


        }

        }
        $assign_roomsdel = Reservation_room::where('reservation_id', $reservation->id)->delete();
        $assign_rooms = $request->input('assign_rooms');
        $categoryCounts = [];
        foreach ($assign_rooms as $assign_room) {
         //   $categoryId = $assign_room['category_id'];

            $rr = new Reservation_room();
            $rr->reservation_id = $reservation->id;
            $rr->room_id = $assign_room;
            $rr->save();
            if($booking) {
                $br = new Booking_room();
                $br->booking_id = $booking->id;
                $br->room_id = $assign_room;
                $br->save();
                $categoryId = Room::find($assign_room)->room_category->id;
                \Illuminate\Support\Facades\Log::info('r' . $categoryId);

                // Increment the count for the specific category
                $categoryCounts[$categoryId] = isset($categoryCounts[$categoryId]) ? $categoryCounts[$categoryId] + 1 : 1;
            }
        }

        if ($booking && $booking->booking_method === 'Offline') {
            foreach ($categoryCounts as $categoryId => $count) {
                $existingBooking_room_count = Booking_room_count::where('booking_id', $booking->id)
                    ->where('room_category_id', $categoryId)
                    ->first();

                if (!$existingBooking_room_count) {
                    $roomCountEntry = new Booking_room_count();
                    $roomCountEntry->booking_id = $booking->id;
                    $roomCountEntry->room_category_id = $categoryId;
                    $roomCountEntry->room_count = $count;
                    $roomCountEntry->save();
                } else {
                    $existingBooking_room_count->room_count = $count;
                    $existingBooking_room_count->save();
                }
            }

            $sumRoomCount = Booking_room_count::where('booking_id', $booking->id)
                ->sum('room_count');

            $booking->room_count = $sumRoomCount;
            $booking->save();
        }

//        $resrvation_id = $reservation->id;
//        $booking = Booking::where('resrvation_id', $resrvation_id)->first();
//        if($booking->booking_method ==='Offline'){
//
//        }
        return response()->json(['reservation' => $reservation]);
    }

    public function reservation_save_full(Request $request)
    {
        $reservation = new Reservation();

        $reservation->first_name = $request->input('first-name');
        $reservation->last_name = $request->input('last-name');
        $reservation->booking_method = $request->input('booking-method');
//        $reservation->address = $request->input('address');
        $reservation->country = $request->input('country');
        $reservation->passport_number = $request->input('passport-number');
        $reservation->email = $request->input('email');
        $reservation->phone = $request->input('phone');
        $reservation->whatsapp_number = $request->input('whatsapp-number');
        $reservation->check_in_date = $request->input('check-in-date');
        $reservation->check_out_date = $request->input('check-out-date');
        $reservation->room_type1 = $request->input('room-type1');
        $reservation->room_type2 = $request->input('room-type2');
        $reservation->room_type3 = $request->input('room-type3');
        $reservation->nights = $request->input('nights');
        $reservation->guests = $request->input('guests');
        $reservation->breakfast = $request->input('Breakfast');
        $reservation->special_note = $request->input('special-note');
        $reservation->room_chagers_usd = $request->input('room_chagers_usd');
        $reservation->room_chagers_lkr = $request->input('room_chagers_lkr');
        $reservation->hotel_id=$request->input('hotel_id');
        $reservation->save();



            $booking = new Booking();

            $booking->first_name = $request->input('first-name');
            $booking->last_name = $request->input('last-name');
            $booking->phone = $request->input('phone');
            $booking->email = $request->input('email');
            // $booking->address = $reservation->address;
            $booking->total_person = $request->input('guests');
            $booking->checking_date = $request->input('check-in-date');
            $booking->checkout_date = $request->input('check-out-date');
            $booking->country = $request->input('country');;
            $booking->note = $request->input('special-note');
            $booking->w_number = $request->input('whatsapp-number');
            $booking->breakfast = $request->input('Breakfast');;
            $booking->status = 'Pending';
            $booking->passport = $request->input('passport-number');
            $booking->booking_type = 'Night Stay';
            $booking->source = 'Outside';
            $booking->reservation_id = $reservation->id;
            $booking->booking_method = $request->input('booking-method');
            $booking->checking_time = '08:00:00';
            $booking->checkout_time = '12:00:00';
            $booking->total_amount = $request->input('room_chagers_lkr');
            $booking->hotel_id = $request->input('hotel_id');

            $booking->save();





        $reservation_id = $reservation->id;

        $assign_rooms = $request->input('assign_rooms');
        foreach ($assign_rooms as $assign_room) {
            $rr = new Reservation_room();
            $rr->reservation_id = $reservation->id;
            $rr->room_id = $assign_room;
            $rr->save();
            if($booking) {
                $br = new Booking_room();
                $br->booking_id = $booking->id;
                $br->room_id = $assign_room;
                $br->save();
                $roomCategory = Room::find($assign_room)->room_category;
                if($booking->booking_method ==='Offline' ){

                    if ($roomCategory) {
                        // Increment room_count in Booking_room_count table
                        $roomCountEntry = new Booking_room_count();
                        $roomCountEntry->booking_id = $booking->id;
                        $roomCountEntry->room_category_id = $roomCategory->id;
                        $roomCountEntry->room_count += 1;
                        $roomCountEntry->save();
                        $sumRoomCount = Booking_room_count::where('booking_id', $booking->id)
                            ->sum('room_count');
                        $booking = Booking::where('reservation_id',$reservation_id)->first();
                        $booking->room_count = $sumRoomCount;
                        $booking->save();


                    } else {
                        // Handle if room category is not found for the assigned room
                    }

                }


            }
        }



















        $Hotel_invoice = new Hotel_invoice();
        $Hotel_invoice->reservation_id = $reservation->id;
        $Hotel_invoice->customer_fname = $reservation->first_name;
        $Hotel_invoice->customer_lname = $reservation->last_name;
        $Hotel_invoice->address = $reservation->country;
        $Hotel_invoice->emaill = $reservation->email;
        $Hotel_invoice->teliphone = $reservation->phone;
        $Hotel_invoice->whatsapp = $reservation->whatsapp_number;
        $Hotel_invoice->status = 'Pending';
        $Hotel_invoice->due_amount = 0;
        $Hotel_invoice->total_amount = 0;
        $Hotel_invoice->total_payment = 0;
        $Hotel_invoice->hotel_id = auth()->user()->hotel_id;
        $Hotel_invoice->room_chargers = $reservation->room_chagers_lkr;
        $Hotel_invoice->save();
        return redirect()->back()->with('success', 'Reservation has been made!');
    }

    public function reservation_checkutdate_save(Request $request)
    {
        $id = $request->input('edit-r-id-input');
        $reservation = Reservation::find($id);
        $reservation->check_out_date = $request->input('edit-r-date-input');
        $reservation->save();
        return redirect()->back()->with('success', 'Reservation has been extended!');
    }

    public function reservation_whatsapp_number_save(Request $request)
    {
        $id = $request->input('edit-w-r-id-input');
        $reservation = Reservation::find($id);
        $reservation->whatsapp_number = $request->input('edit-r-whatsapp-input');
        $reservation->save();
        return redirect()->back()->with('success', 'Whatsapp Number has been Changed!');
    }

    public function cash_book_get_record_details(Request $request)
    {
        $detail_id = $request->input('id');
        $type = $request->input('type');
        if ($type == 'grn') {
            $record_details = Goods_received_note::with('goods_received_note_detail.item', 'user')->where('id', $detail_id)->first();
            $output = view('hotel.render_for_ajax.cashbook_grn_detail', ['record_details' => $record_details])->render();
        } elseif ($type == 'reservation') {
            $record_details = Reservation::where('id', $detail_id)->first();
            $output = view('hotel.render_for_ajax.cashbook_reservation_detail', ['record_details' => $record_details])->render();
        } elseif ($type == 'expenses') {
            $record_details = Expense::with('expense_detail.expense_sub_category', 'user')->where('id', $detail_id)->first();
            $output = view('hotel.render_for_ajax.cashbook_expenses_detail', ['record_details' => $record_details])->render();
        }
        return response()->json(['output' => $output]);
    }

    public function add_expenses_view()
    {
        $categories = Expense_category::with('expense_sub_category')->where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.add_expenses_view', ['categories' => $categories]);
    }

    public function checklist_view($id,Request $request)
    {
//        $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();
//        $room = Room::with('room_category')->find($id);
//        if ($room->check_list_layout_id != null) {
//            $check_list = Housekeeping::where('status', null)->where('check_list_layout_id',$room->check_list_layout_id )->get();
//        }
//        else{
//            return redirect()->back()->with('error', 'A checklist layout is not assigned.Tell the admin and get the checklist layout assigned!');
//        }
//        return view('hotel.check_list', ['hotel' => $hotel, 'check_list' => $check_list, 'rooms' => $room]);

        //        return $request;
        $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();

        $type = $request->input('type');
        if($type == 'room'){
            $location = Room::with('room_category')->find($id);
            $type = 'room';
        }
        else{
            $location = Other_location::find($id);
            $type = 'other_location';
        }

        if ($location->check_list_layout_id != null) {
            $check_list = Housekeeping::where('status', null)->where('check_list_layout_id',$location->check_list_layout_id )->get();
        }
        else{
            return redirect()->back()->with('error', 'A checklist layout is not assigned.Tell the admin and get the checklist layout assigned!');
        }

        return view('hotel.check_list', ['hotel' => $hotel, 'check_list' => $check_list, 'location' => $location, 'type'=>$type]);
    }

    public function check_list_save(Request $request)
    {

//       return $request;
//        $check_list = new Check_list();
//        $check_list->hotel_id = auth()->user()->hotel_id;
//        $check_list->room_id = $request->input('room_id');
//        $check_list->housekeeper_id = auth()->user()->id;
//        $check_list->status = 'Pending';
//
//        $check_list->save();
//
//        if ($request->has('check_list_item_yes')) {
//            $check_list_items_yes = $request->input('check_list_item_yes');
//            foreach ($check_list_items_yes as $check_list_item_yes) {
//                $check_list_detail = new Check_list_detail();
//                $check_list_detail->housekeeping_id = $check_list_item_yes;
//                $check_list_detail->check_list_id = $check_list->id;
//                $check_list_detail->housekeeper_status = 'Yes';
//                $check_list_detail->supervisor_status = 'Pending';
//                $check_list_detail->save();
//            }
//        }
//
//        if ($request->has('check_list_item_no')) {
//            $check_list_items_no = $request->input('check_list_item_no');
//            foreach ($check_list_items_no as $check_list_item_no) {
//                $check_list_detail = new Check_list_detail();
//                $check_list_detail->housekeeping_id = $check_list_item_no;
//                $check_list_detail->check_list_id = $check_list->id;
//                $check_list_detail->housekeeper_status = 'No';
//                $check_list_detail->supervisor_status = 'Pending';
//                $check_list_detail->save();
//            }
//        }
//        return redirect()->route('hotel/housekeeping/get_image_view', ['id'=>$check_list->id]);


        $type = $request->input('type');

        if($type == 'room'){
            $check_list = new Check_list();
            $check_list->hotel_id = auth()->user()->hotel_id;
            $check_list->room_id = $request->input('location_id');
            $check_list->housekeeper_id = auth()->user()->id;
            $check_list->status = 'Pending';
            $check_list->save();

            $rooms = Room::find($request->input('location_id'));
            $check_list_layout_id = $rooms->check_list_layout_id;
//            $janitorial_items = Janitorial_item::where('check_list_layout_id',$check_list_layout_id)->get();
//
//            foreach ($janitorial_items as $janitorial_item){
//                $janitorial_item_quantity = $janitorial_item->quantity;
//                $item = Item::find($janitorial_item->item_id);
//
//                $item->quantity = $item->quantity - $janitorial_item_quantity;
////                \LogActivity::addToLog('HOUSEKEEPING', Carbon::now(), 'HOUSEKEEPING', null, null, null, null, ($recipi_item->quantity * $recipes_q['qty']), $item->quantity, Auth::id(), 'for ' . $recipes_q['qty'] . ' ' . $order_item->recipe_name, $item->id);
//                $item->save();
//            }

        }
        else{
            $check_list = new Other_check_list();
            $check_list->hotel_id = auth()->user()->hotel_id;
            $check_list->other_location_id = $request->input('location_id');
            $check_list->housekeeper_id = auth()->user()->id;
            $check_list->status = 'Pending';
            $check_list->save();

            $other_locations = Other_location::find($request->input('location_id'));
            $check_list_layout_id = $other_locations->check_list_layout_id;
//            $janitorial_items = Janitorial_item::where('check_list_layout_id',$check_list_layout_id)->get();
//
//            foreach ($janitorial_items as $janitorial_item){
//                $janitorial_item_quantity = $janitorial_item->quantity;
//                $item = Item::find($janitorial_item->item_id);
//
//                $item->quantity = $item->quantity - $janitorial_item_quantity;
//                \LogActivity::addToLog('HOUSEKEEPING', Carbon::now(), 'HOUSEKEEPING', null, null, null, null, ($recipi_item->quantity * $recipes_q['qty']), $item->quantity, Auth::id(), 'for ' . $recipes_q['qty'] . ' ' . $order_item->recipe_name, $item->id);
//                $item->save();
//
//
//
//            }

        }
//        return $request;

        if ($request->has('check_list_item_yes')) {
            $check_list_items_yes = $request->input('check_list_item_yes');
            foreach ($check_list_items_yes as $check_list_item_yes) {
                $check_list_detail = new Check_list_detail();
                $check_list_detail->housekeeping_id = $check_list_item_yes;
                if($type == 'room'){
                    $check_list_detail->check_list_id = $check_list->id;
                }
                else{
                    $check_list_detail->other_check_list_id = $check_list->id;
                }
                $check_list_detail->housekeeper_status = 'Yes';
                $check_list_detail->supervisor_status = 'Pending';
                $check_list_detail->save();
            }
        }

        if ($request->has('check_list_item_no')) {
            $check_list_items_no = $request->input('check_list_item_no');
            foreach ($check_list_items_no as $check_list_item_no) {
                $check_list_detail = new Check_list_detail();
                $check_list_detail->housekeeping_id = $check_list_item_no;
                if($type == 'room'){
                    $check_list_detail->check_list_id = $check_list->id;
                }
                else{
                    $check_list_detail->other_check_list_id = $check_list->id;
                }
                $check_list_detail->housekeeper_status = 'No';
                $check_list_detail->supervisor_status = 'Pending';
                $check_list_detail->save();
            }
        }

        if($type == 'room'){
            return redirect()->route('hotel/housekeeping/get_image_view', ['id'=>$check_list->id,'type'=>$type,'check_list_layout_id'=>$check_list_layout_id,'location_id'=>$rooms->id]);

        }
        else{
            return redirect()->route('hotel/housekeeping/get_image_view', ['id'=>$check_list->id,'type'=>$type,'check_list_layout_id'=>$check_list_layout_id,'location_id'=>$other_locations->id]);

        }


    }

    public function get_image_view($id,Request $request)
    {
//        $check_list = Check_list::with('room')->find($id);
//        return view('hotel.check_list_get_image', ['check_list' => $check_list]);

        $type = $request->input('type');
        $check_list_layout_id = $request->input('check_list_layout_id');

        $janitorial_items = Janitorial_item::with('item','check_list_layouts')->where('check_list_layout_id',$check_list_layout_id)->where('status', null)->get();
        $refilling_items = Refilling_item::with('item','check_list_layouts')->where('check_list_layout_id',$check_list_layout_id)->where('status', null)->get();

        if($type == 'room'){
            $check_list = Check_list::with('room')->find($id);
        }
        else{
            $check_list = Other_check_list::with('other')->find($id);
        }

        return view('hotel.check_list_get_image', ['check_list' => $check_list,'type'=>$type,'refilling_items'=>$refilling_items , 'janitorial_items' => $janitorial_items]);
    }

    public function housekeeper_get_edit($id,Request $request)
    {
        $type = $request->input('type');
        if($type == 'room'){
            $edit_item = Check_list::with('check_list_detail.housekeeping', 'housekeeper', 'room')->find($id);
        }
        else{
            $edit_item = Other_check_list::with('check_list_detail.housekeeping', 'housekeeper', 'other','check_list_image')->find($id);
        }
        return view('hotel.check_list_housekeeper_edit',  ['edit_item' => $edit_item, 'type'=>$type]);
    }

    public function view_checklist()
    {
        $check_list = Check_list::with('housekeeper', 'supervisor', 'room')->orderBy('id','desc')->get();
        $other_check_list = Other_check_list::with('housekeeper', 'supervisor', 'other')->orderBy('id','desc')->get();
//        return $check_list;
        return view('hotel.check_list_view', ['check_list' => $check_list, 'other_check_list' => $other_check_list]);
    }

    public function get_edit_checklist_details($id,Request $request)
    {
        $type = $request->input('type');
        if($type == 'room'){
            $edit_item = Check_list::with('check_list_detail.housekeeping', 'housekeeper', 'room')->find($id);
        }
        else{
            $edit_item = Other_check_list::with('check_list_detail.housekeeping', 'housekeeper', 'other')->find($id);
        }


//        return $edit_item;

        return view('hotel.check_list_supervisor', ['edit_item' => $edit_item, 'type'=>$type]);
    }

    public function supervisor_save(Request $request)
    {

//        return $request;
        $type = $request->input('type');
        $check_list_id = $request->input('check_list_id');

        if($type == 'room'){
            $check_list = Check_list::find($check_list_id);
            $check_list->supervisor_id = auth()->user()->id;
            $check_list->status = 'Checked';
            $check_list->room_status = $request->input('room_status');
            $check_list->save();
        }
        else{
            $check_list = Other_check_list::find($check_list_id);
            $check_list->supervisor_id = auth()->user()->id;
            $check_list->status = 'Checked';
            $check_list->save();
        }


        if ($request->has('check_list_item_yes')) {
            $check_list_items_yes = $request->input('check_list_item_yes');
            foreach ($check_list_items_yes as $check_list_item_yes) {
                $check_list_item = Check_list_detail::find($check_list_item_yes);
                $check_list_item->supervisor_status = 'Yes';
                $check_list_item->save();
            }
        }

        if ($request->has('check_list_item_no')) {
            $check_list_items_no = $request->input('check_list_item_no');
            foreach ($check_list_items_no as $check_list_item_no) {
                $reason = $request->input('reason-'.$check_list_item_no);
                $check_list_item = Check_list_detail::find($check_list_item_no);
                $check_list_item->supervisor_status = 'No';
                $check_list_item->reason = $reason;
                $check_list_item->save();
            }
        }

        if($type == 'room'){
            return redirect()->route('hotel/housekeeping/room_view');
        }
        else{
            return redirect()->route('hotel/housekeeping/other_location_view');
        }

    }

    public function view_detail_checklist($id,Request $request)
    {
        $page= $request->input('form');
        $type = $request->input('type');

        if(($type == 'room')){
            $edit_item = Check_list::with('check_list_detail.housekeeping', 'housekeeper', 'check_list_image','supervisor')->find($id);
            $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();
            $check_list = Check_list_detail::get();
        }
        else{
            $edit_item = Other_check_list::with('check_list_detail.housekeeping', 'housekeeper', 'check_list_image' ,'supervisor')->find($id);
            $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();
            $check_list = Check_list_detail::get();
        }

        return view('hotel.check_list_view_all_details', ['hotel' => $hotel, 'check_list' => $check_list, 'edit_item' => $edit_item, 'page' => $page, 'type'=>$type]);

    }

    public function view_detail_housekeeping_checklist($id,Request $request)
    {
        $page= $request->input('form');
        $type = $request->input('type');

        if($type == 'room'){
            $edit_item = Check_list::with('check_list_detail.housekeeping', 'housekeeper', 'check_list_image' , 'room')->find($id);
            $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();
            $check_list = Check_list_detail::get();
        }
        else{
            $edit_item = Other_check_list::with('check_list_detail.housekeeping', 'housekeeper', 'check_list_image' , 'other')->find($id);
            $hotel = Item::where('hotel_id', auth()->user()->hotel_id)->get();
            $check_list = Check_list_detail::get();
        }

//        return $page.'-'.$id;

//        return  $check_list;

        return view('hotel.check_list_view_housekeeping', ['hotel' => $hotel, 'check_list' => $check_list, 'edit_item' => $edit_item, 'page' => $page, 'type'=>$type]);

    }

    public function check_list_image_save(Request $request)
    {
   // return $request;
        $type = $request->input('type');
        $check_list_layout_id = $request->input('check_list_layout_id');
        $check_list_id = $request->input('check_list_id');
        $location_id = $request->input('location_id');

//        $location = null;
//        return $check_list_id ;

        if($type == 'room'){
            $room_status = $request->input('room_status');
            $check_list = Check_list::find($check_list_id);
            $check_list->room_status = $room_status;
            $check_list->save();
        }

            $count = $request->input('count');
            for ($i = 1; $i <= $count; $i++) {

                if ($request->has('Description-' . $i) && $request->has('check_list_avatar-' . $i)) {

                    $img_des = $request->input('Description-' . $i);
                    $img_pic = $request->file('check_list_avatar-' . $i);

                    $check_list_image = new Check_list_image();
                    $check_list_image->user_id = Auth::id();
                    $check_list_image->hotel_id = auth()->user()->hotel_id;

                     //   $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
                    //    $contentType = $imagefile->getClientMimeType();
                        $path = Storage::putFile('/checklist_image/thumbnail', $img_pic, 'public');
                        $file = Image::make($img_pic)
                            ->orientate()
                            ->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                        Storage::put($path, (string)$file->encode());

                    $check_list_image->image = $path;
                    $check_list_image->description = $img_des;
                    if($type == 'room'){
                        $check_list_image->check_list_id = $check_list_id;
                    }
                    else{
                        $check_list_image->other_check_list_id = $check_list_id;
                    }

                    $check_list_image->save();
                }

            }


        if($type == 'room'){
            $location = Room::find($location_id);
        }
        else{
            $location = Other_location::find($location_id);
        }
        $check_list_layout_id = $location->check_list_layout_id;

        $count_item = $request->input('count_item');
        for ($i = 1;$i<=$count_item;$i++) {
            if($request->has('refilling_item_id-' . $i) && $request->has('Quantity-' . $i)){
                $item_refilling = $request->input('refilling_item_id-' . $i);
                $quantity = $request->input('Quantity-' . $i);
                if($item_refilling != "" && $quantity != ""){

                    $refilling_items = Refilling_item::where('id',$item_refilling)->where('check_list_layout_id',$check_list_layout_id)->first();

                    $janitorial_item_detail = new Janitorial_item_detail();
                    $janitorial_item_detail->check_list_id	 = $check_list_id;
                    $janitorial_item_detail->item_id = $refilling_items->item_id;
                    $janitorial_item_detail->quantity = $quantity;
                    $janitorial_item_detail->category = 'Refilling';
                    $janitorial_item_detail->save();

                    $item = Item::find($janitorial_item_detail->item_id);
                    $item->quantity = $item->quantity - $quantity;
                    $item->save();


                    if($type == 'room'){
                        $location = Room::find($location_id);
                        \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $quantity, $item->quantity, Auth::id(), 'for ' . $location->room_number . ' Refilling',$refilling_items->item_id, $check_list_id);
                    }
                    else{
                        $location = Other_location::find($location_id);
                        \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $quantity, $item->quantity, Auth::id(), 'for ' . $location->name . ' Refilling',$refilling_items->item_id , $check_list_id);
                    }


//                    \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $quantity, $item->quantity, Auth::id(), 'for ' . $location->room_number . ' Refilling', $item->id , $check_list_id);

                }
            }
        }


//        $janitorial_items = Janitorial_item::where('check_list_layout_id',$check_list_layout_id)->get();
//
//        foreach ($janitorial_items as $janitorial_item){
//            $janitorial_item_quantity = $janitorial_item->quantity;
//            $item = Item::find($janitorial_item->item_id);
//            $item->quantity = $item->quantity - $janitorial_item_quantity;
//            $item->save();
//
//            if($type == 'room'){
//                $location = Room::find($location_id);
//                \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $janitorial_item_quantity, $item->quantity, Auth::id(), 'for ' . $location->room_number . ' Chemical', $item->id , $check_list_id);
//            }
//            else{
//                $location = Other_location::find($location_id);
//                \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $janitorial_item_quantity, $item->quantity, Auth::id(), 'for ' . $location->name . ' Chemical', $item->id , $check_list_id);
//            }
//
////            \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $janitorial_item_quantity, $item->quantity, Auth::id(), 'for ' . $location->room_number . ' Chemical', $item->id , $check_list_id);
//
//            $janitorial_item_detail = new Janitorial_item_detail();
//            $janitorial_item_detail->check_list_id	 = $check_list_id;
//            $janitorial_item_detail->item_id = $janitorial_item->item_id;
//            $janitorial_item_detail->quantity = $janitorial_item_quantity;
//            $janitorial_item_detail->category = 'Chemical';
//            $janitorial_item_detail->save();
//        }


        $count_item_chemical = $request->input('count_item_chemical');
        for ($i = 1;$i<=$count_item_chemical;$i++) {
            if($request->has('chemical_item_id-' . $i) && $request->has('janitorial_item_use-' . $i)){
                $item_id = $request->input('chemical_item_id-' . $i);
                if($item != ""){
                    $janitorial_item = Janitorial_item::where('id',$item_id)->where('check_list_layout_id',$check_list_layout_id)->first();
                    $janitorial_item_quantity = $janitorial_item->quantity;
                    $item = Item::find($janitorial_item->item_id);
                    $item->quantity = $item->quantity - $janitorial_item_quantity;
                    $item->save();


                    if($type == 'room'){
                        $location = Room::find($location_id);
                        \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $janitorial_item_quantity, $item->quantity, Auth::id(), 'for ' . $location->room_number . ' Chemical', $item->id , $check_list_id);
                    }
                    else{
                        $location = Other_location::find($location_id);
                        \LogActivity::addToLog('HOUSEKEEPING', Carbon::now()->format('Y-m-d'), 'HOUSEKEEPING', null, null, null, null, $janitorial_item_quantity, $item->quantity, Auth::id(), 'for ' . $location->name . ' Chemical', $item->id , $check_list_id);
                    }

                    $janitorial_item_detail = new Janitorial_item_detail();
                    $janitorial_item_detail->check_list_id	 = $check_list_id;
                    $janitorial_item_detail->item_id = $janitorial_item->item_id;
                    $janitorial_item_detail->quantity = $janitorial_item_quantity;
                    $janitorial_item_detail->category = 'Chemical';
                    $janitorial_item_detail->save();

                }
            }
        }

             if($type == 'room'){
                 return redirect()->route('hotel/housekeeping/room_view');
             }
             else{
                 return redirect()->route('hotel/housekeeping/other_location_view');
             }

            return redirect()->back()->with('success');
    }

    public function upload_test(Request $request){
        $form = '<form action="' . route('hotel/upload/test') . '" method="POST" enctype="multipart/form-data">';
        $form .= csrf_field();
        $form .= '<input type="file" name="file">';
        $form .= '<button type="submit">Upload File</button>';
        $form .= '</form>';

        // Return HTML response
        return response($form);
    }
    public function upload_test_save(Request $request){
// Validate the uploaded file
//        $request->validate([
//            'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

        // Store the uploaded file
        $file = $request->file('file');
        if ($file) {
        $path = Storage::putFile('/checklist_image/thumbnail', $file, 'public');

            return response(['File uploaded successfully.',$path]);
        }
        // You can save the file details to the database if needed
// Return a failure response
        return response('File upload failed. Please check the file and try again.', 422);
        // Return a response
    }
    public function hotel_invoice(Request $request){
        $invoices = Hotel_invoice::with('reservation.reservation_rooms')->where('hotel_id',auth()->user()->hotel_id)->where('status' ,'!=' ,'Delete')->get();
        return view('hotel.hotel_invoice_all',compact('invoices'));
    }

    public function hotel_invoice_detail($id){
        $hotel_invoice = Hotel_invoice::with('reservation.reservation_rooms')->find($id);
        $invoices = Order_list::with('order_list_detail')
            ->where('reservation_id',$hotel_invoice->reservation_id)
//            ->where('room_id',$reservation_rooms->room_id)
            ->get();
        $hotel_invoice_payments = Hotel_invoice_payment::where('hotel_invoice_id',$id)->get();
        return view('hotel.hotel_invoice_detail',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments]);
    }

  public function hotel_invoice_detail_add_payment_delete(Request $request){
//return $request;
      $hotel_invoice_payment = Hotel_invoice_payment::find($request->input('id'));
      $cash_debit = Cash_book_log_activity::where('re_invoice_pay_id', $hotel_invoice_payment->id)->first();
      $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Clear Debited Amount (Payment from Reservation' . '(' . $cash_debit->reservation_id . ') ' . 'Rs. ' . $hotel_invoice_payment->amount;
      $cash_debit->status = 'Delete';
      $cash_debit->remark = $remark;
      $cash_debit->save();
      \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Delete');

      $hspds = Hotel_invoice_payment_detail::where('hotel_invoice_payment_id',$hotel_invoice_payment->id)->get();
        foreach ($hspds as $hspd){
            if($hspd->type == 'Room'){
                $hotel_invoice = Hotel_invoice::find($hotel_invoice_payment->hotel_invoice_id);
                $hotel_invoice->room_payment = $hotel_invoice->room_payment - $hspd->amount;
                $hotel_invoice->save();
            }elseif ($hspd->type == 'Food'){
                $orderlist = Order_list::find($hspd->order_list_id);
                $orderlist->paid_amount = $orderlist->paid_amount - $hspd->amount;
                $orderlist->payment_method = 'Pay later';
                $orderlist->save();
            }
        }
        Hotel_invoice_payment_detail::where('hotel_invoice_payment_id',$hotel_invoice_payment->id)->delete();
        $hotel_invoice_payment->delete();


        return redirect()->back()->with(['success'=>'payment delete success']);
    }

    public function hotel_invoice_detail_invoice_print(Request $request)
    {
        $invoice_id = $request->input('invoice_id');
        $hotel_invoice = Hotel_invoice::with('reservation.reservation_rooms')->find($invoice_id);
        $invoices = Order_list::with('order_list_detail')
            ->where('reservation_id',$hotel_invoice->reservation_id)
            ->get();
        $hotel_invoice_payments = Hotel_invoice_payment::where('hotel_invoice_id',$invoice_id)->get();

        $hotel = Hotel::find(auth()->user()->hotel_id);
//        return view('hotel.hotel_invoice_print',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);

        $pdf = Facade\Pdf::loadView('hotel.hotel_invoice_print',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);
        return $pdf->download('invoice.pdf');
//        return view('hotel.reservation_invoice_print', ['reservation' => $reservation,'hotel' => $hotel]);
    }

    public function hotel_invoice_detail_invoice_view(Request $request)
    {
        $invoice_id = $request->input('invoice_id');
        $hotel_invoice = Hotel_invoice::with('reservation.reservation_rooms')->find($invoice_id);
        $invoices = Order_list::with('order_list_detail')
            ->where('reservation_id',$hotel_invoice->reservation_id)
            ->get();
        $hotel_invoice_payments = Hotel_invoice_payment::where('hotel_invoice_id',$invoice_id)->get();

        $hotel = Hotel::find(auth()->user()->hotel_id);
        return view('hotel.hotel_invoice_view',['hotel_invoice'=>$hotel_invoice,'invoices'=>$invoices,'hotel_invoice_payments'=>$hotel_invoice_payments,'hotel' => $hotel]);


    }

    public function hotel_invoice_detail_make_payment_save(Request $request)
    {

        $invoice_id = $request->input('hotel_invoice_id');
        $hotel_invoice = Hotel_invoice::find($invoice_id);

        $hotel_invoice_payment = new Hotel_invoice_payment();
        $hotel_invoice_payment->hotel_invoice_id = $hotel_invoice->id;
        $hotel_invoice_payment->amount = $request->input('make-payment-total-amount');
        $hotel_invoice_payment->payment_method = $request->input('payment_method');
        $hotel_invoice_payment->save();


        if ($request->has('romm-chagers')){
            $hotel_invoice->room_payment = $hotel_invoice->room_payment+$request->input('romm-chagers-payment');
            $hotel_invoice->save();


            $hipd = new Hotel_invoice_payment_detail();
            $hipd->hotel_invoice_payment_id = $hotel_invoice_payment->id;
            $hipd->amount = $request->input('romm-chagers-payment');
            $hipd->type = 'Room';
            $hipd->save();
        }

        $invoices = Order_list::where('reservation_id',$hotel_invoice->reservation_id)->get();
        foreach ($invoices as $invoice){
            if ($request->has('pid-'.$invoice->id)){

                $hipd = new Hotel_invoice_payment_detail();
                $hipd->hotel_invoice_payment_id = $hotel_invoice_payment->id;
                $hipd->order_list_id = $invoice->id;
                $hipd->amount = $request->input('pay-a-'.$invoice->id);
                $hipd->type = 'Food';
                $hipd->save();

                $orderlist = Order_list::find($invoice->id);
                $orderlist->paid_amount = $invoice->paid_amount+$hipd->amount;
                if($invoice->paid_amount+$hipd->amount == $invoice->total){
                    $orderlist->payment_method = 'Paid';
                }
                 $orderlist->save();
            }

        }

        $reservation_setting_record = Hotel_reservation_setting::where('hotel_id', auth()->user()->hotel_id)->first();
        if ($hotel_invoice_payment->payment_method == 'Card') {
            $cash_book_id = $reservation_setting_record->card_payment;
            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' (' . auth()->user()->role . ')' . ' Debit (Card Payment from Reservation (' . $hotel_invoice->reservation_id . ') Rs. ' . $hotel_invoice_payment->amount;
        } elseif ($hotel_invoice_payment->payment_method == 'Cash'){
            $cash_book_id = $reservation_setting_record->cash_payment;
            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' (' . auth()->user()->role . ')' . ' Debit (Cash Payment from Reservation (' . $hotel_invoice->reservation_id . ') Rs. ' . $hotel_invoice_payment->amount;
        }

        $cash_debit = new Cash_book_log_activity();
        $cash_debit->cashbook_id = $cash_book_id;
        $cash_debit->hotel_id = auth()->user()->hotel_id;
        $cash_debit->debit = $hotel_invoice_payment->amount;
        $cash_debit->re_invoice_pay_id = $hotel_invoice_payment->id;
        $cash_debit->status = 'Active';
        $cash_debit->type = $hotel_invoice_payment->payment_method == 'Card' ? 'card' : 'cash';
        $cash_debit->date = $hotel_invoice_payment->updated_at->format('Y-m-d');
        $cash_debit->user_id = auth()->user()->id;
        $cash_debit->remark = $remark;
        $cash_debit->reservation_id = $hotel_invoice->reservation_id;
        $cash_debit->save();
        \Cashbook_monthly_record_sync::sync_cash_log($cash_debit, 'Debit');

        return redirect()->back()->with(['success' => 'Payment added successfully']);

    }

    public function check_list_image_delete(Request $request)
    {
        $date = date('Y-m-d');
        $image = $request->input('image_id');
        $check_list_image = Check_list_image::find( $image);

        // \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $repair->id, $repair->reason, null, $repair->location, $repair->person, Auth::id(), 'Delete wastage');

        $check_list_image->delete();
        return response()->json(['success' => 'success']);
    }

    public function view_housekeeping_room()
    {
        $room = Room::with('room_category')
            ->whereDoesntHave('room_repairs', function ($query) {
                $today = now()->format('Y-m-d');
                $query->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today);
            })

            ->where('status', null)
            ->where('hotel_id', auth()->user()

                ->hotel_id)->orderBy('room_number','asc')->get();
        $other_location = Other_location::where('status', null)->where('hotel_id', auth()->user()->hotel_id)->orderBy('id','asc')->get();

//        return view('hotel.housekeeping_roomList', ['hotel' => $hotel, 'check_list' => $check_list, 'rooms' => $room]);
        return view('hotel.housekeeping_roomList',['rooms' => $room,'other_locations' => $other_location]);

    }

    public function view_other_location()
    {
        $other_location = Other_location::where('status', null)->where('hotel_id', auth()->user()->hotel_id)->orderBy('id','asc')->get();

//        return view('hotel.housekeeping_roomList', ['hotel' => $hotel, 'check_list' => $check_list, 'rooms' => $room]);
        return view('hotel.other_location',['other_locations' => $other_location]);

    }

    public function view_housekeeping_room_get_no_item(Request $request)
    {
        $check_list_id = $request->input('checklist_id');
        $check_list = \App\Check_list::with([
//            'check_list_detail.housekeeping' => function ($query) {
//                $query->where('housekeeper_status', 'No');
//            },
            'check_list_detail.housekeeping',
            'housekeeper',
            'supervisor',
            'check_list_image'
        ])->find($check_list_id);
        return response()->json(['check_list' => $check_list]);
    }

    public function view_housekeeping_other_location_get_no_item(Request $request)
    {
        $check_list_id = $request->input('checklist_id');
        $check_list = \App\Other_check_list::with([
//            'check_list_detail.housekeeping' => function ($query) {
//                $query->where('housekeeper_status', 'No');
//            },
            'check_list_detail.housekeeping',
            'housekeeper',
            'supervisor',
            'check_list_image'
        ])->find($check_list_id);
        return response()->json(['check_list' => $check_list]);
    }

    public function housekeeper_check_list_edit_save(Request $request)
    {

//        return $request;
        $type = $request->input('type');
        $check_list_id = $request->input('check_list_id');

        if($type == 'room'){
            $check_list = Check_list::find($check_list_id);
//        $check_list->supervisor_id = auth()->user()->id;
            $check_list->status = 'Pending';
            $check_list->room_status = $request->input('room_status');
            $check_list->save();

        }
        else{
            $check_list = Other_check_list::find($check_list_id);
//        $check_list->supervisor_id = auth()->user()->id;
            $check_list->status = 'Pending';
            $check_list->save();

        }


        if ($request->has('check_list_item_yes')) {
            $check_list_items_yes = $request->input('check_list_item_yes');
            foreach ($check_list_items_yes as $check_list_item_yes) {
                $check_list_item = Check_list_detail::find($check_list_item_yes);
                $check_list_item->housekeeper_status = 'Yes';
                $check_list_item->save();
            }
        }

        if ($request->has('check_list_item_no')) {
            $check_list_items_no = $request->input('check_list_item_no');
            foreach ($check_list_items_no as $check_list_item_no) {
                $reason = $request->input('reason-'.$check_list_item_no);
                $check_list_item = Check_list_detail::find($check_list_item_no);
                $check_list_item->housekeeper_status = 'No';
                $check_list_item->reason = $reason;
                $check_list_item->save();
            }
        }


        $count = $request->input('count');
        for ($i = 1; $i <= $count; $i++) {

            if ($request->has('Description-' . $i) && $request->has('check_list_avatar-' . $i)) {

                $img_des = $request->input('Description-' . $i);
                $img_pic = $request->file('check_list_avatar-' . $i);

                $check_list_image = new Check_list_image();
                $check_list_image->user_id = Auth::id();
                $check_list_image->hotel_id = auth()->user()->hotel_id;

                //   $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
                //    $contentType = $imagefile->getClientMimeType();
                $path = Storage::putFile('/checklist_image/thumbnail', $img_pic, 'public');
                $file = Image::make($img_pic)
                    ->orientate()
                    ->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                Storage::put($path, (string)$file->encode());

                $check_list_image->image = $path;
                $check_list_image->description = $img_des;
                if($type == 'room'){
                    $check_list_image->check_list_id = $check_list_id;
                }
                else{
                    $check_list_image->other_check_list_id = $check_list_id;
                }

                $check_list_image->save();
            }

        }
        if($type == 'room'){
            return redirect()->route('hotel/housekeeping/room_view');
        }
        else{
            return redirect()->route('hotel/housekeeping/other_location_view');
        }


    }

    public function expenses_save_first(Request $request)
    {
        $date = $request->input('date');
        $expenses = new Expense();
        $expenses->date = $date;
        $expenses->supplier = $request->input('supplier');
        $expenses->user_id = auth()->user()->id;
        $expenses->hotel_id = auth()->user()->hotel_id;

//        if ($image = $request->file('bill_image')) {
//
//            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
//            $contentType = $image->getClientMimeType();
//
//            if (!in_array($contentType, $allowedMimeTypes)) {
//                $path = Storage::putFile('/expenses/thumbnail', $image, 'public');
//                $expenses->image = $path;
//            } else {
//                $path = Storage::putFile('/expenses/thumbnail', $image, 'public');
//                $file = Image::make($image)
//                    ->orientate()
//                    ->resize(500, null, function ($constraint) {
//                        $constraint->aspectRatio();
//                        $constraint->upsize();
//                    });
//                Storage::put($path, (string)$file->encode());
//                $expenses->image = $path;
//            }
//        }



        if ($file = $request->file('bill_image')) {
            $allowedImageMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $file->getClientMimeType();

            if (in_array($contentType, $allowedImageMimeTypes)) {
                $path = Storage::putFile('/expenses/thumbnail', $file, 'public');

                $image = Image::make($file)
                    ->orientate()
                    ->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                Storage::put($path, (string)$image->encode());
                $expenses->image = $path;

            }else {
                $documentPath = Storage::putFile('/expenses/documents', $file, 'public');
                $expenses->image = $documentPath;
            }

        }

        $expenses->save();

        $total = 0;
        $count = $request->input('count');
        for ($i = 1; $i <= $count; $i++) {
            $expense_sub_category = $request->input('sub_category-' . $i);
            $expense_description = $request->input('description-' . $i);
            $expense_price = $request->input('price-' . $i);
            if ($expense_sub_category != "" && $expense_description != "" && $expense_price != "") {
                $expense_detail = new Expense_detail();
                $expense_detail->description = $expense_description;
                $expense_detail->price = $expense_price;
                $expense_detail->expenses_sub_category_id = $expense_sub_category;
                $expense_detail->expenses_id = $expenses->id;
                $expense_detail->save();
                $total = $total + $expense_price;
            }
        }
        $expenses->total_cost = $total;
        $expenses->save();

        $supplier = Supplier::find($expenses->supplier);
//        return $supplier;
        $supplier_total_amount = $supplier->total_amount;

        $supplier->total_amount = $supplier_total_amount+$expenses->total_cost;
        $supplier->paid_status = 'Pending Amount';
        $supplier->save();

        $cash_books = Assign_expenses_cashbook::with('cashbook')->where('hotel_id', auth()->user()->hotel_id)->get();
        return view('hotel.expenses_payment', ['expenses' => $expenses, 'cash_books' => $cash_books]);
    }
    public function expenses_save_second(Request $request)
    {

        $expense_id = $request->input('expenses_id');
        $cashbook_id = $request->input('cash_book_id');
        $total_amount = $request->input('total_amount');
        $paid_amount = $request->input('paid_amount');
        $balance = $request->input('balance');
        $payment_date = $request->input('payment_date');

        $payment = new Payment();
        $payment->date = $payment_date;
        $payment->expenses_id = $expense_id;
        $payment->cashbook_id = $cashbook_id;
        $payment->total_amount = $total_amount;
        $payment->paid_amount = $paid_amount;
        $payment->balance = $balance;
        $payment->hotel_id = auth()->user()->hotel_id;
        $payment->user_id = auth()->user()->id;
        $payment->save();

        $expenses = Expense::find($payment->expenses_id);
        $expenses->paid_cost = $paid_amount;
        $expenses->balance = $balance;
        if ($payment->total_amount == $payment->paid_amount) {
            $expenses->status = 'Paid';
        } else {
            $expenses->status = 'Pending Amount';
        }
        $expenses->save();

        $supplier = Supplier::find($expenses->supplier);

        $supplier_total_amount = $supplier->total_amount;
        $supplier_paid_amount = $supplier->paid_amount;

        $supplier->paid_amount = $supplier_paid_amount+$paid_amount;
        if ($supplier_total_amount == $supplier_paid_amount+$paid_amount) {
            $supplier->paid_status = 'Paid';
        } else {
            $supplier->paid_status = 'Pending Amount';
        }
        $supplier->save();

        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Pay By' . ' ' . '(' . $payment->expenses_id . ') ' . 'Bill';

        $cash_book_log = new Cash_book_log_activity();
        $cash_book_log->cashbook_id = $cashbook_id;
        $cash_book_log->hotel_id = auth()->user()->hotel_id;
        $cash_book_log->credit = $payment->paid_amount;
        $cash_book_log->date = $payment->date;
        $cash_book_log->user_id = auth()->user()->id;
        $cash_book_log->expense_id = $payment->expenses_id;
        $cash_book_log->payment_id = $payment->id;
        $cash_book_log->remark = $remark;
        $cash_book_log->status = 'Active';
        $cash_book_log->save();

        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Credit');

        return redirect()->route('hotel/expenses/view_expenses');
    }

    public function expenses_view()
    {
        $expenses = Expense::with('user')->where('hotel_id', auth()->user()->hotel_id)->get();
        //return $expenses;
        $cash_books = Assign_expenses_cashbook::with('cashbook')->where('hotel_id', auth()->user()->hotel_id)->get();
        $categories = Expense_category::with('expense_sub_category')->where('hotel_id', auth()->user()->hotel_id)->get();

        return view('hotel.view_expenses', ['expenses' => $expenses, 'cash_books' => $cash_books, 'categories' => $categories]);
    }

    public function get_second_payment_details(Request $request)
    {
        $expense_id = $request->input('expense_id');
        $expense = Expense::find($expense_id);
        return response()->json(['expense' => $expense]);
    }

    public function save_second_payment(Request $request)
    {
        $expense_id = $request->input('expenses_id');
        $paid_amount = $request->input('paid_amount');
        $total_amount = $request->input('total_amount');
        $balance = $request->input('balance');
        $date = $request->input('sp_date');
        $cashbook_id = $request->input('cash_book_id');

        $payment = new Payment();
        $payment->date = $date;
        $payment->expenses_id = $expense_id;
        $payment->cashbook_id = $cashbook_id;
        $payment->total_amount = $total_amount;
        $payment->paid_amount = $paid_amount;
        $payment->balance = $balance;
        $payment->hotel_id = auth()->user()->hotel_id;
        $payment->user_id = auth()->user()->id;
        $payment->save();

        $expense = Expense::find($expense_id);
        $expense->paid_cost = $expense->paid_cost + $paid_amount;

        if ($payment->total_amount == $expense->paid_cost) {
            $expense->status = 'Paid';
            $expense->balance = 0;
        } else {
            $expense->status = 'Pending Amount';
            $expense->balance = $expense->balance - $paid_amount;
            $payment->balance = $expense->balance;
            $payment->save();
        }
        $expense->save();

        $supplier = Supplier::find($expense->supplier);

        $supplier_total_amount = $supplier->total_amount;
        $supplier_paid_amount = $supplier->paid_amount;

        $supplier->paid_amount = $supplier_paid_amount+$paid_amount;
        if ($supplier_total_amount == $supplier_paid_amount+$paid_amount) {
            $supplier->paid_status = 'Paid';
        } else {
            $supplier->paid_status = 'Pending Amount';
        }

        $supplier->save();
        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Pay Balance By' . ' ' . '(' . $payment->expenses_id . ') ' . 'Bill';

        $cash_book_log = new Cash_book_log_activity();
        $cash_book_log->cashbook_id = $cashbook_id;
        $cash_book_log->hotel_id = auth()->user()->hotel_id;
        $cash_book_log->credit = $payment->paid_amount;
        $cash_book_log->date = $payment->date;
        $cash_book_log->user_id = auth()->user()->id;
        $cash_book_log->expense_id = $payment->expenses_id;
        $cash_book_log->payment_id = $payment->id;
        $cash_book_log->remark = $remark;
        $cash_book_log->status = 'Active';
        $cash_book_log->save();

        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Credit');

        return redirect()->back()->with('success', 'Successfully Add Payment!');
    }

    public function get_all_expense_details(Request $request)
    {
        $expense_id = $request->input('expense_id');
        $expense_details = Expense::with('expense_detail.expense_sub_category', 'user')->where('id', $expense_id)->first();
        return response()->json(['expense_details' => $expense_details]);
    }

    public function get_all_expense_history(Request $request)
    {

        $expense_id = $request->input('expense_id');

        $record_details = Payment::with('user')->where('expenses_id', $expense_id)->get();
        $output = view('hotel.render_for_ajax.expenses_history', ['record_details' => $record_details])->render();

        return response()->json(['output' => $output]);
    }

    public function get_expenses_details_first(Request $request)
    {
        $expense_id = $request->input('expense_id');
        $expense_details = Expense::with('expense_detail')->where('id', $expense_id)->first();
        $categories = Expense_category::with('expense_sub_category')->where('hotel_id', auth()->user()->hotel_id)->get();
        return response()->json(['expense_details' => $expense_details, 'categories' => $categories]);
    }

    public function expenses_edit_first_save(Request $request)
    {
        $e_expense_id = $request->input('e_expense_id');
        $supplier = $request->input('e_supplier');
        $date = $request->input('e_date');

        $expenses = Expense::find($e_expense_id);
        if ($expenses->supplier != $supplier){
            $supplier = Supplier::find($expenses->supplier);
            $supplier->total_amount = $supplier->total_amount-$expenses->total_cost;
            $supplier->save();
        }
        $expenses->supplier = $supplier;
        $expenses->date = $date;
        $expenses->user_id = auth()->user()->id;
        $expenses->hotel_id = auth()->user()->hotel_id;

        $supplier = Supplier::find($expenses->supplier);

        $supplier->total_amount = $supplier->total_amount-$expenses->total_cost;


//        if ($image = $request->file('e_bill_image')) {
//            Storage::delete($expenses->image);
//            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
//            $contentType = $image->getClientMimeType();
//
//            if (!in_array($contentType, $allowedMimeTypes)) {
//                $path = Storage::putFile('/expenses/thumbnail', $image, 'public');
//                $expenses->image = $path;
//            } else {
//                $path = Storage::putFile('/expenses/thumbnail', $image, 'public');
//                $file = Image::make($image)
//                    ->orientate()
//                    ->resize(500, null, function ($constraint) {
//                        $constraint->aspectRatio();
//                        $constraint->upsize();
//                    });
//                Storage::put($path, (string)$file->encode());
//                $expenses->image = $path;
//            }
//        }

        if ($file = $request->file('e_bill_image')) {
            $allowedImageMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $file->getClientMimeType();

            if (in_array($contentType, $allowedImageMimeTypes)) {
                $path = Storage::putFile('/expenses/thumbnail', $file, 'public');

                $image = Image::make($file)
                    ->orientate()
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                Storage::put($path, (string)$image->encode());
                $expenses->image = $path;

            }else {
                $documentPath = Storage::putFile('/expenses/documents', $file, 'public');
                $expenses->image = $documentPath;
            }

        }
        $expenses->save();
        $total = 0;
        $count = $request->input('count');
        $expense_dt_ids = array();
        for ($i = 1; $i <= $count; $i++) {
            $expense_sub_category = $request->input('e_sub_category-' . $i);
            $expense_description = $request->input('e_description-' . $i);
            $expense_price = $request->input('e_price-' . $i);
            if ($expense_sub_category != "" && $expense_description != "" && $expense_price != "") {
                $expense_dt_id = $request->input('expense-details-id-' . $i);
                if ($expense_dt_id == 'new') {
                    $expense_dt = new Expense_detail();
                } else {
                    $expense_dt = Expense_detail::find($expense_dt_id);
                }
                $expense_dt->description = $expense_description;
                $expense_dt->price = $expense_price;
                $expense_dt->expenses_sub_category_id = $expense_sub_category;
                $expense_dt->expenses_id = $expenses->id;
                $expense_dt->save();
                $total = $total + $expense_price;
                array_push($expense_dt_ids, $expense_dt->id);
            }
        }
        $expense_dt_delete_rows2 = Expense_detail::where('expenses_id', $e_expense_id)->whereNotIn('id', $expense_dt_ids)->delete();

        $expenses->total_cost = $total;
        $expenses->balance = $expenses->total_cost - $expenses->paid_cost;
        if($expenses->balance == 0 ){
            $expenses->status = 'Paid';
        }else{
            $expenses->status = 'Pending Amount';
        }
        $expenses->save();
        $payments = Payment::where('expenses_id',$expenses->id)->orderBy('date', 'ASC')->get();
        $balance = $expenses->total_cost;
        foreach ($payments as $payment){
            $payment->total_amount = $expenses->total_cost;
            $balance = $balance - $payment->paid_amount;
            $payment->balance = $balance;
            $payment->save();
        }

        $supplier_total_amount = $supplier->total_amount;
        $supplier_paid_amount = $supplier->paid_amount;

        $supplier->total_amount = $supplier_total_amount+$total;
        if ($supplier->total_amount == $supplier_paid_amount) {
            $supplier->paid_status = 'Paid';
        } else {
            $supplier->paid_status = 'Pending Amount';
        }
        $supplier->save();
        $expenses_n = Expense::with('user')->where('id',$expenses->id)->first();
        return response()->json(['expenses' => $expenses_n]);
        }
    public function get_edit_second_payment_detail(Request $request){
        $payment_id = $request->input('payment_id');
        $payment = Payment::find($payment_id);
        return response()->json(['payment' => $payment]);
    }

    public function edit_second_payment_detail_save(Request $request){

        $payment_id = $request->input('payment_id');
        $total_amount = $request->input('e_total_amount');
        $paid_amount = $request->input('e_paid_amount');
        $balance = $request->input('e_balance');
        $date = $request->input('e_sp_date');
        $cashbook_id = $request->input('e_cash_book_id');

        $payment = Payment::find($payment_id);
        $old_cashbook_id = Cash_book_log_activity::where('payment_id', $payment_id)->where('status', 'Active')->first();

            $date_record = new Carbon($old_cashbook_id->date);
            $this_month = Carbon::now()->startOfMonth();
            $date_record2 = new Carbon($old_cashbook_id->date);
            $date_record3 = $date_record2->startOfMonth();
            $cash_book_date = $date_record->startOfMonth()->addMonth();
            $cash_book_monthly = Cashbook_monthly_record::where('date', $cash_book_date)->where('cashbook_id', $old_cashbook_id->cashbook_id)->first();
             $expenses_main = Expense::find($payment->expenses_id);

            if ($old_cashbook_id->cashbook_id == $cashbook_id) {
                if ($old_cashbook_id->date == $date) {
                    if ($date_record3 != $this_month) {
                        $cash_book_monthly->total_credit = $cash_book_monthly->total_credit - $old_cashbook_id->credit;
                        $cash_book_monthly->balance = $cash_book_monthly->balance + $old_cashbook_id->credit;
                        $cash_book_monthly->save();
                    }
                    $payment->paid_amount = $paid_amount;
                    $payment->date = $date;
                    $payment->save();
                    $payments = Payment::where('expenses_id',$payment->expenses_id)->orderBy('date', 'ASC')->get();
                    $balance = $payment->total_amount;
                    $expenses_total_paid_cost = 0;
                    foreach ($payments as $payment_update){
                        $balance = $balance - $payment_update->paid_amount;
                        $payment_update->balance = $balance;
                        $payment_update->save();
                        $expenses_total_paid_cost = $expenses_total_paid_cost + $payment_update->paid_amount;
                    }

                    $expenses_main->paid_cost = $expenses_total_paid_cost;
                    $expenses_main->balance = $expenses_main->total_cost - $expenses_total_paid_cost;
                    $expenses_main->save();

                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Pay Amount in Expense' . ' ' . '(' . $expenses_main->id . ')'.'-'.'Amount ('.$old_cashbook_id->credit.'=>'.$paid_amount.')';
                    $old_cashbook_id->credit = $paid_amount;
                    $old_cashbook_id->remark = $remark;
                    $old_cashbook_id->date = $date;
                    $old_cashbook_id->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                } else {
                    $payment->date = $date;
                    $payment->paid_amount = $paid_amount;
                    $payment->save();
                    $payments = Payment::where('expenses_id',$payment->expenses_id)->orderBy('date', 'ASC')->get();
                    $balance = $payment->total_amount;
                    $expenses_total_paid_cost = 0;
                    foreach ($payments as $payment_update){
                        $balance = $balance - $payment_update->paid_amount;
                        $payment_update->balance = $balance;
                        $payment_update->save();
                        $expenses_total_paid_cost = $expenses_total_paid_cost + $payment_update->paid_amount;
                    }

                    $expenses_main->paid_cost = $expenses_total_paid_cost;
                    $expenses_main->balance = $expenses_main->total_cost - $expenses_total_paid_cost;
                    $expenses_main->save();
                    $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Date/Amount in Expense' . ' ' . '(' . $expenses_main->id . ')';
                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
                    $old_cashbook_id->credit = $paid_amount;
                    $old_cashbook_id->remark = $remark;
                    $old_cashbook_id->date = $date;
                    $old_cashbook_id->save();
                    \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
                }
            } else {
                $payment->cashbook_id = $cashbook_id;
                $payment->paid_amount = $paid_amount;
                $payment->date = $date;
                $payment->save();
                $payments = Payment::where('expenses_id',$payment->expenses_id)->orderBy('date', 'ASC')->get();
                $balance = $payment->total_amount;
                $expenses_total_paid_cost = 0;
                foreach ($payments as $payment_update){
                    $balance = $balance - $payment_update->paid_amount;
                    $payment_update->balance = $balance;
                    $payment_update->save();
                    $expenses_total_paid_cost = $expenses_total_paid_cost + $payment_update->paid_amount;
                }
                $expenses_main->paid_cost = $expenses_total_paid_cost;
                $expenses_main->balance = $expenses_main->total_cost - $expenses_total_paid_cost;
                $expenses_main->save();

        $daysInMonth = [];
        $startDate = Carbon::parse($selectedDate)->startOfMonth();
        $endDate = Carbon::parse($selectedDate)->endOfMonth();
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $daysInMonth[] = $date->format('Y-m-d');
        }

                \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit_Delete');
                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Change CashBook in Expense' . ' ' . '(' . $expenses_main->id . ')';
                $old_cashbook_id->credit = $paid_amount;
                $old_cashbook_id->remark = $remark;
                $old_cashbook_id->date = $date;
                $old_cashbook_id->cashbook_id = $cashbook_id;
                $old_cashbook_id->save();
                \Cashbook_monthly_record_sync::sync_cash_log($old_cashbook_id, 'Credit');
            }

        return response()->json(['success' => 'success','expenses_main'=>$expenses_main]);
    }

        public function add_booking_view(){
        $room_categories =  Room_category::where('hotel_id',auth()->user()->hotel_id)->get();
        return view('hotel.add_booking_view',['room_categories'=>$room_categories]);
        }
        public function add_booking_save(Request $request){
      //return $request;
            $first_name =$request->input('f_name');
            $last_name =$request->input('l_name');
            $phone =$request->input('phone');
            $email =$request->input('email');
            $address =$request->input('address');
            $checking_date =$request->input('check_in_date');
            $checkout_date =$request->input('check_out_date');
            $booking_method =$request->input('booking_method');
            $passport =$request->input('passport_number');
            $whatsapp_number =$request->input('whatsapp_number');
            $adults =$request->input('adults');
            $children =$request->input('children');
            $advance_payment =$request->input('advanced_payment');
            $breakfast =$request->input('Breakfast');

            $country =$request->input('country');
            $note =$request->input('note');
            $bookingcom_id =$request->input('bookingcom_id');
            $bookingtype = $request->input('bookingtype');

            $total_person =$adults+$children;

            $hotel = Hotel::find(auth()->user()->hotel_id);

            $booking = new Booking();
        $booking->first_name = $first_name;
        $booking->last_name = $last_name;
        $booking->phone = $phone;
        $booking->email = $email;
        $booking->address = $address;
        $booking->booking_method = $booking_method;
        $booking->passport = $passport;
        $booking->w_number = $whatsapp_number;
        $booking->adults = $adults;
        $booking->children = $children;
        $booking->advance_payment = $advance_payment;
        $booking->breakfast = $breakfast;
        $booking->total_person = $total_person;
        $booking->checking_date = $checking_date;
        $booking->checkout_date = $checkout_date;
        $booking->country = $country;
        $booking->note = $note;
        $booking->hotel_id = auth()->user()->hotel_id;
        $booking->user_id = auth()->user()->id;
        $booking->payment = 'Due';
        $booking->status = 'Pending';
        $booking->source='Inside';
        $booking->booking_code = $bookingcom_id;
        $booking->booking_type=$bookingtype;

            if ($bookingtype == 'Day Stay'){
                $booking->checking_date=$checking_date;
                $booking->checkout_date=$checking_date;
                $booking->checking_time= '08:00:00';
                $booking->checkout_time='16:00:00';
            }else{
                $booking->checking_date=$checking_date;
                $booking->checkout_date=$checkout_date;
                $booking->checking_time= '14:00:00';
                $booking->checkout_time='12:00:00';
            }

            if ($image = $request->file('image')) {
                $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
                $contentType = $image->getClientMimeType();

                if (!in_array($contentType, $allowedMimeTypes)) {
                    $path = Storage::putFile('/booking/thumbnail', $image, 'public');
                    $booking->payment_slip = $path;
                } else {
                    $path = Storage::putFile('/booking/thumbnail', $image, 'public');
                    $file = Image::make($image)
                        ->orientate()
                        ->resize(500, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    Storage::put($path, (string)$file->encode());
                    $booking->payment_slip = $path;
                }
            }
           $booking->save();

            $room_categories = Room_category::where('hotel_id',$booking->hotel_id)->get();
            $total = 0;
            foreach ($room_categories as $room_category){

                $room_count_save= new Booking_room_count();
                $room_count_save->booking_id= $booking->id;
                $room_count_save->room_category_id=$room_category->id;
                $room_count_save->room_count=  $request->input('available_room_count-' . $room_category->id);
                $room_count_save->save();
                $total= $total+$room_count_save->room_count;
            }
            $booking->room_count = $total;
            $booking->save();
            $rooms = Booking_room_count::with('room_categories')->where('booking_id',$booking->id)->get();
            $booking_data = new \stdClass;
            $booking_data->bookingdetails = $booking;
            $booking_data->roomdata = $rooms;
            Mail::to('info@ravantangalle.com')->send(new Pending_booking_mail($booking_data));
//            Mail::to('keshanribelz@gmail.com')->send(new Pending_booking_mail($booking_data));
            return redirect()->back()->with('success','Successfully Add Booking');
    }
    public function view_booking(){
        $bookings = Booking::with('booking_rooms.room')
            ->where('status', 'Approved')
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('checkout_date', '>=', date('Y-m-d')) // Filter out past bookings
            ->get();
        $pending_bookings = Booking::with('booking_room_count')
            ->where('status','Pending')
            ->where('hotel_id',auth()->user()->hotel_id)
            ->get();

        $checkout_bookings = Booking::with('booking_rooms.room')
            ->where('status', 'Approved')
            ->where('hotel_id', auth()->user()->hotel_id)
            ->where('checkout_date', '<', date('Y-m-d')) // Filter out upcoming bookings
            ->get();

        $deleted_bookings = Booking::with('booking_room_count')
            ->where('status','Deleted')
            ->where('hotel_id',auth()->user()->hotel_id)
            ->get();


        return view('hotel.view_booking',['bookings'=>$bookings,'pending_bookings'=>$pending_bookings,'checkout_bookings'=>$checkout_bookings,'deleted_bookings'=>$deleted_bookings]);
        }

    public function view_booking_archive(){

            $archive_bookings = Booking_archive::where('hotel_id',auth()->user()->hotel_id)->get();

            return view('hotel.view_booking_archive',['archive_bookings'=>$archive_bookings]);
    }
    public function archive_booking_restore(Request $request){

        $id = $request->input('booking_id');
        $archive_booking = Booking_archive::find($id);
        $archive_booking->source = 'Execl-Restore';
        // Create a new booking record using the data from the archived record
        $new_booking = new Booking();
        $fillableData = Arr::except($archive_booking->toArray(), ['booking_rooms', 'booking_room_count']);
        $new_booking->fill($fillableData);
        $new_booking->save();

        // Restore related records (if any)
        if ($archive_booking->booking_rooms) {
            $booking_rooms = json_decode($archive_booking->booking_rooms, true);

            foreach ($booking_rooms as $room) {
                $new_booking->booking_rooms()->create($room);
            }
        }

        if ($archive_booking->booking_room_count) {
            $booking_room_count = json_decode($archive_booking->booking_room_count, true);

            foreach ($booking_room_count as $room_count) {
                $new_booking->booking_room_count()->create($room_count);
            }
        }

        // Delete the archived booking record
        $archive_booking->delete();

        return response()->json(['message' => 'Booking restored successfully.']);

    }


    public function over_roll_bookingv2(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;
        /*return*/ $roomCategories = Room_category::where('hotel_id', $hotelId)->get();

        $selectedDate = $request->input('b_date');

        $startDate = Carbon::parse($selectedDate)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($selectedDate)->endOfMonth()->format('Y-m-d');

        $result = [];

        foreach ($roomCategories as $category) {
            $categoryData = [
                'category_id' => $category->id,
                'category_name' => $category->category,
                'rooms' => [],
            ];

            $rooms = Room::where('hotel_id', $hotelId)
                ->where('room_category_id', $category->id)
                ->get();

            foreach ($rooms as $room) {
                $roomData = [
                    'room_id' => $room->id,
                    'room_number' => $room->room_number,
                    'bookings' => [],
                ];

                $bookings = Booking::where('hotel_id', $hotelId)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereDate('checking_date', '<=', $endDate)
                                ->whereDate('checkout_date', '>=', $startDate);
                        });
                    })
                    ->with('rooms')
                    ->get();

                foreach ($bookings as $booking) {
                    foreach ($booking->rooms as $bookingRoom) {
                        if ($bookingRoom->id === $room->id) {
                            $duration = ($booking->booking_type === 'Day Stay') ? 0 : Carbon::parse($booking->checking_date)->diffInDays(Carbon::parse($booking->checkout_date));

                            $bookingData = [
                                'booking_id' => $booking->id,
                                'first_name' => $booking->first_name,
                                'last_name' => $booking->last_name,
                                'checking_date' => $booking->checking_date,
                                'checkout_date' => $booking->checkout_date,
                                'booking_type' => $booking->booking_type,
                                'duration' => $duration,
                            ];

                            $roomData['bookings'][] = $bookingData;
                        }
                    }
                }

                $categoryData['rooms'][] = $roomData;
            }

            $result[] = $categoryData;
        }

        return response()->json($result);
    }
    public function over_roll_bookingv3(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;
        /*return*/ $roomCategories = Room_category::where('hotel_id', $hotelId)->get();

        $selectedDate = $request->input('b_date');

        $startDate = Carbon::parse($selectedDate)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($selectedDate)->endOfMonth()->format('Y-m-d');

        $result = [];

        foreach ($roomCategories as $category) {
            $categoryData = [
                'category_id' => $category->id,
                'category_name' => $category->category,
                'rooms' => [],
            ];

            $rooms = Room::where('hotel_id', $hotelId)
                ->where('room_category_id', $category->id)
                ->get();

            foreach ($rooms as $room) {
                $roomData = [
                    'room_id' => $room->id,
                    'room_number' => $room->room_number,
                    'bookings' => [],
                ];

                $bookings = Booking::where('hotel_id', $hotelId)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereDate('checking_date', '<=', $endDate)
                                ->whereDate('checkout_date', '>=', $startDate);
                        });
                    })
                    ->with('rooms')
                    ->get();

                foreach ($bookings as $booking) {
                    foreach ($booking->rooms as $bookingRoom) {
                        if ($bookingRoom->id === $room->id) {
                            $duration = ($booking->booking_type === 'Day Stay') ? 0 : Carbon::parse($booking->checking_date)->diffInDays(Carbon::parse($booking->checkout_date));

                            $bookingData = [
                                'booking_id' => $booking->id,
                                'first_name' => $booking->first_name,
                                'last_name' => $booking->last_name,
                                'checking_date' => $booking->checking_date,
                                'checkout_date' => $booking->checkout_date,
                                'booking_type' => $booking->booking_type,
                                'duration' => $duration,
                            ];

                            $roomData['bookings'][] = $bookingData;
                        }
                    }
                }

                $categoryData['rooms'][] = $roomData;
            }

            $result[] = $categoryData;
        }

        return response()->json($result);
    }
    public function over_roll_bookingv4my(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;
        /*return*/ $roomCategories = Room_category::where('hotel_id', $hotelId)->get();

        $selectedDate = $request->input('b_date');

        $startDate = Carbon::parse($selectedDate)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($selectedDate)->endOfMonth()->format('Y-m-d');

        $result = [];
        $daysInMonth = [];
        while ($startDate <= $endDate) {
            $daysInMonth[] = $startDate->copy()->format('Y-m-d');
            $startDate->addDay();
        }

        foreach ($roomCategories as $category) {
            $categoryData = [
                'category_id' => $category->id,
                'category_name' => $category->category,
                'rooms' => [],
            ];

            $rooms = Room::where('hotel_id', $hotelId)
                ->where('room_category_id', $category->id)
                ->get();

            foreach ($rooms as $room) {
                $roomData = [
                    'room_id' => $room->id,
                    'room_number' => $room->room_number,
                    'bookings' => [],
                ];

                $bookings = Booking::where('hotel_id', $hotelId)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereDate('checking_date', '<=', $endDate)
                                ->whereDate('checkout_date', '>=', $startDate);
                        });
                    })
                    ->with('rooms')
                    ->get();

                foreach ($bookings as $booking) {
                    foreach ($booking->rooms as $bookingRoom) {
                        if ($bookingRoom->id === $room->id) {
                            $duration = ($booking->booking_type === 'Day Stay') ? 0 : Carbon::parse($booking->checking_date)->diffInDays(Carbon::parse($booking->checkout_date));

                            $bookingData = [
                                'booking_id' => $booking->id,
                                'first_name' => $booking->first_name,
                                'last_name' => $booking->last_name,
                                'checking_date' => $booking->checking_date,
                                'checkout_date' => $booking->checkout_date,
                                'booking_type' => $booking->booking_type,
                                'duration' => $duration,
                            ];

                            $roomData['bookings'][] = $bookingData;
                        }
                    }
                }

                $categoryData['rooms'][] = $roomData;
            }

            $result[] = $categoryData;
        }

//        return response()->json($result);
//        return $daysInMonth;
        return [$result,$daysInMonth,$selectedDate ];
        return view('hotel.view_reservation_overall', compact('result', 'daysInMonth', 'selectedDate'));
    }
    public function over_roll_bookingv6(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;
        $roomCategories = Room_category::where('hotel_id', $hotelId)->get();

        $selectedDate = $request->input('b_date');

        $startDate = Carbon::parse($selectedDate)->startOfMonth();
        $endDate = Carbon::parse($selectedDate)->endOfMonth();

        $result = [];
        $daysInMonth = [];

        // Use a clone of $startDate to avoid modifying the original date
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $daysInMonth[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        foreach ($roomCategories as $category) {
            $categoryData = [
                'category_id' => $category->id,
                'category_name' => $category->category, // Assuming 'category' is the correct field name
                'rooms' => [],
            ];

            $rooms = Room::where('hotel_id', $hotelId)
                ->where('room_category_id', $category->id)
                ->get();

            foreach ($rooms as $room) {
                $roomData = [
                    'room_id' => $room->id,
                    'room_number' => $room->room_number,
                    'bookings' => [],
                ];

                $bookings = Booking::where('hotel_id', $hotelId)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where(function ($query) use ($startDate, $endDate) {
                            $query->whereDate('checking_date', '<=', $endDate)
                                ->whereDate('checkout_date', '>=', $startDate);
                        });
                    })
                    ->with('rooms')
                    ->get();

                foreach ($bookings as $booking) {
                    foreach ($booking->rooms as $bookingRoom) {
                        if ($bookingRoom->id === $room->id) {
                            $duration = ($booking->booking_type === 'Day Stay') ? 0 : Carbon::parse($booking->checking_date)->diffInDays(Carbon::parse($booking->checkout_date));

                            $bookingData = [
                                'booking_id' => $booking->id,
                                'first_name' => $booking->first_name,
                                'last_name' => $booking->last_name,
                                'checking_date' => $booking->checking_date,
                                'checkout_date' => $booking->checkout_date,
                                'booking_type' => $booking->booking_type,
                                'duration' => $duration,
                            ];

                            $roomData['bookings'][] = $bookingData;
                        }
                    }
                }

                $categoryData['rooms'][] = $roomData;
            }

            $result[] = $categoryData;
        }
        return view('hotel.view_booking_overall', compact('result', 'daysInMonth', 'selectedDate'));

//        return [$result, $daysInMonth, $selectedDate];
    }

    public function assign_spliit_booking(Request $request)
    {
        $booking_id = $request->booking_id;
        $checkInDate = Carbon::parse($request->checkInDate)->format('Y-m-d');
        $checkOutDate = Carbon::parse($request->checkOutDate)->format('Y-m-d');
        $booking = Booking::findOrFail($booking_id);

        // Create the first split booking
        $newBooking = new Booking();
        $newBooking->fill($booking->toArray());
        $newBooking->id = null;
        $newBooking->checking_date = $checkInDate;
        $newBooking->checkout_date = $checkOutDate;
        $newBooking->status = 'Approved';

        $room_ids = $request->selectedRooms;
        Log::info('selectedRooms');
        Log::info($room_ids);
        $newBooking->save();
        $newBooking->rooms()->sync($room_ids);


        Log::info('newBooking');
        Log::info($newBooking);

        // Update the original booking
        $booking->checkout_date = $checkInDate;
        $booking->status = 'Approved';
        $booking->save();
        Log::info('booking');
        Log::info($booking);

        return redirect()->back()->with('success', 'Successfully splitted booking');
    }


    public function over_roll_booking(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;
        $roomCategories = Room_category::where('hotel_id', $hotelId)->get();
//        Log::debug($roomCategories);

        $selectedDate = $request->input('b_date');

        $startDate = Carbon::parse($selectedDate)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($selectedDate)->endOfMonth()->format('Y-m-d');

        $roomData = [];
//        $roomCategories = json_decode('[{"id":2,"created_at":"2023-04-10T18:18:24.000000Z","updated_at":"2023-06-09T18:38:06.000000Z","deleted_at":null,"hotel_id":1,"category":"Cabana","status":"Active","room_count":4,"num_of_bed":null,"num_of_living_rooms":null,"num_of_bathroom":null,"smoking_policy":null,"custome_name":null,"image":"Hotel\/Rooms\/thumbnail\/lIud9IpdMymt2UVZfZsoEhkicd7tJCVs1wiAJtoF.jpg","room_type":null,"price":7000,"note":null}]');
//        Log::debug($roomCategories);
        foreach ($roomCategories as $category) {

            $rooms = Room::where('hotel_id', $hotelId)
                ->where('room_category_id', $category->id)
                ->get();

//Log::notice($category);
            $bookings = Booking::where('hotel_id', $hotelId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('checking_date', '<=', $endDate)
                            ->whereDate('checkout_date', '>=', $startDate);
                    });
                })
                ->with('rooms')
                ->get();
Log::notice($bookings);

            $roomBookings = [];


            foreach ($bookings as $booking) {
                foreach ($booking->rooms as $room) {






                    if ($room->room_category_id == $category->id) {
                        if (!isset($roomBookings[$room->id])) {
                            $roomBookings[$room->id] = collect();

                        }

                        $bookingDateRange = CarbonPeriod::create($booking->checking_date, $booking->checkout_date)->excludeEndDate();


                        Log::notice($bookingDateRange);
//                        Log::notice($booking);
//                        Log::info($booking->booking_type);
                        if ($booking->booking_type == "Day Stay"){
                            $roomBookings[$room->id]->push([
                                'booking' => $booking,
                                'date' => $booking->checking_date,
                            ]);
                        }
                        elseif($booking->booking_type == "Night Stay"){
                            foreach ($bookingDateRange as $date) {
                                $roomBookings[$room->id]->push([
                                    'booking' => $booking,
                                    'date' => $date->format('Y-m-d'),
                                ]);
                            }
                        }

                    }
                }
            }
             foreach ($rooms as $room) {
                 if (!isset($roomBookings[$room->id])) {
                     $roomBookings[$room->id] = collect();


                 }
                 $roomid = $room->id;
                 $roomRepairs = Room_rapair::select('room_id', 'start_date', 'end_date', 'status')
                     ->where('room_id', $roomid)
                     ->get();



                 if (!$roomRepairs->isEmpty()) {

                     foreach ($roomRepairs as $repair) {
                         $repairDateRange = CarbonPeriod::create($repair->start_date, $repair->end_date)->excludeEndDate();
                         if ($repair->status == "repair") {
                             foreach ($repairDateRange as $date) {
                                 $roomBookings[$room->id]->push([
                                     'repair' => $repair,
                                     'date' => $date->format('Y-m-d'),
                                 ]);
                             }
                         }
                     }


                 }
             }





            $roomDetails = [];

            foreach ($roomBookings as $roomId => $bookings) {
                $room = Room::find($roomId);
                $dates = [];

                foreach ($bookings as $booking) {
                    if(isset($booking['booking'])) {
                        $dates[$booking['date']] = $booking['booking'];
                    } elseif(isset($booking['repair'])) {
                        $dates[$booking['date']] = $booking['repair'];
                    }
                }
                $roomDetails[] = [
                    'room' => $room,
                    'dates' => $dates,
                ];
            }

            $roomData[] = [
                'category' => $category,
                'roomDetails' => $roomDetails,
            ];
        }

        $daysInMonth = [];
        $startOfMonth = Carbon::parse($selectedDate)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedDate)->endOfMonth();

        while ($startOfMonth->lte($endOfMonth)) {
            $daysInMonth[] = $startOfMonth->format('Y-m-d');
            $startOfMonth->addDay();
        }
//return $roomBookings;
//        return $roomData;
        return view('hotel.view_booking_overall', compact('roomData', 'daysInMonth', 'selectedDate'));
    }

    public function over_roll_booking_assign_rooms(Request $request){
        $booking_id = $request->input('booking_id');
        $room_ids = $request->input('select_rooms');
        $bookings_r = Booking::find($booking_id);
        $bookings_r->rooms()->sync($room_ids);
        return redirect()->back()->with('success', 'Room Change success!');
    }

    public function overall_reservation(Request $request){
        $hotelId = auth()->user()->hotel_id;
        $roomCategories = Room_category::where('hotel_id', $hotelId)->get();

        $selectedDate = $request->input('b_date');

        $startDate = Carbon::parse($selectedDate)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($selectedDate)->endOfMonth()->format('Y-m-d');

        $roomData = [];

        foreach ($roomCategories as $category) {
            $rooms = Room::where('hotel_id', $hotelId)
                ->where('room_category_id', $category->id)
                ->get();

            $reservations = Reservation::where('hotel_id', $hotelId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('check_in_date', '<=', $endDate)
                            ->whereDate('check_out_date', '>=', $startDate);
                    });
                })
                ->with('rooms')
                ->get();

            $roomBookings = [];

            foreach ($reservations as $reservation) {
                foreach ($reservation->rooms as $room) {
                    if ($room->room_category_id == $category->id) {
                        if (!isset($roomBookings[$room->id])) {
                            $roomBookings[$room->id] = collect();
                        }

                        $bookingDateRange = CarbonPeriod::create($reservation->check_in_date, $reservation->check_out_date)->excludeEndDate();

                        foreach ($bookingDateRange as $date) {
                            $roomBookings[$room->id]->push([
                                'reservation' => $reservation,
                                'date' => $date->format('Y-m-d'),
                            ]);
                        }
                    }
                }
            }

            foreach ($rooms as $room) {
                if (!isset($roomBookings[$room->id])) {
                    $roomBookings[$room->id] = collect();
                }
                $roomid = $room->id;
                $roomRepairs = Room_rapair::select('room_id', 'start_date', 'end_date', 'status')
                    ->where('room_id', $roomid)
                    ->get();



                if (!$roomRepairs->isEmpty()) {

                    foreach ($roomRepairs as $repair) {
                        $repairDateRange = CarbonPeriod::create($repair->start_date, $repair->end_date)->excludeEndDate();
                        if ($repair->status == "repair") {
                            foreach ($repairDateRange as $date) {
                                $roomBookings[$room->id]->push([
                                    'repair' => $repair,
                                    'date' => $date->format('Y-m-d'),
                                ]);
                            }
                        }
                    }


                }

            }

            $roomDetails = [];

            foreach ($roomBookings as $roomId => $reservations) {
                $room = Room::find($roomId);
                $dates = [];

                foreach ($reservations as $reservation) {
                    if(isset($reservation['reservation'])) {
                        $dates[$reservation['date']] = $reservation['reservation'];
                    } elseif(isset($reservation['repair'])) {
                        $dates[$reservation['date']] = $reservation['repair'];
                    }
                }

                $roomDetails[] = [
                    'room' => $room,
                    'dates' => $dates,
                ];
            }

            $roomData[] = [
                'category' => $category,
                'roomDetails' => $roomDetails,
            ];
        }

        $daysInMonth = [];
        $startOfMonth = Carbon::parse($selectedDate)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedDate)->endOfMonth();

        while ($startOfMonth->lte($endOfMonth)) {
            $daysInMonth[] = $startOfMonth->format('Y-m-d');
            $startOfMonth->addDay();
        }
//return $roomData;
        return view('hotel.view_reservation_overall', compact('roomData', 'daysInMonth', 'selectedDate'));
    }

    public function get_booking_details_for_overall(Request $request){
        $booking_id =$request->input('booking_id');
        $booking = Booking::with('booking_rooms','booking_room_count.room_categories')->where('id',$booking_id)->first();
        return response()->json(['success' => 'success','booking'=>$booking]);

//        $booking_id = $request->input('booking_id');
//        $pending_booking = Booking::with('booking_room_count.room_categories')->where('id',$booking_id)->first();
//        return response()->json(['success'=>'success','pending_booking'=>$pending_booking]);
    }
    public function get_reservation_details_for_overall(Request $request){
        $reservation_id =$request->input('reservation_id');
        $reservation = Reservation::with('reservation_rooms')->where('id',$reservation_id)->first();
        return response()->json(['success' => 'success','reservation'=>$reservation]);
    }
    public function delete_booking(Request $request){
        $booking_id = $request->input('booking_id');
        $booking = Booking::find($booking_id);
        Storage::delete($booking->image);
        Storage::delete($booking->payment_slip);
        $booking_rooms = Booking_room::where('booking_id',$booking_id)->delete();
        $booking_room_count =Booking_room_count::where('booking_id',$booking_id)->delete();
        $booking->delete();
        return response()->json(['success'=>'success']);
    }
    public function get_pending_booking_details(Request $request){
        $booking_id = $request->input('booking_id');
        $pending_booking = Booking::with('booking_room_count.room_categories')->where('id',$booking_id)->first();
        return response()->json(['success'=>'success','pending_booking'=>$pending_booking]);
    }
    public function delete_pending_booking(Request $request){
        $booking_id = $request->input('booking_id');
        $booking = Booking::find($booking_id);
//        Storage::delete($booking->image);
//        Storage::delete($booking->payment_slip);
//        $booking_rooms_count = Booking_room_count::where('booking_id',$booking_id)->delete();
//        $booking->delete();

        $booking_archive = new Booking_archive();
        $bookingDataArray = $booking->toArray();

        $bookingDataArray['booking_rooms'] = json_encode($booking->booking_rooms);
        $bookingDataArray['booking_room_count'] = json_encode($booking->booking_room_count);
        $booking_archive->fill($bookingDataArray);

        $booking_archive->save();


        $booking_rooms = Booking_room::where('booking_id',$booking->id)->delete();
        $booking_room_count =Booking_room_count::where('booking_id',$booking->id)->delete();

        $booking->delete();
        return response()->json(['success'=>'success']);
    }

    public function delete_booking_details(Request $request){

        $booking_id = $request->input('booking_id');
        $booking = Booking::find($booking_id);
        $booking->status = 'FineDeleted';
        $booking->save();

//        Storage::delete($booking->image);
//        Storage::delete($booking->payment_slip);
        $booking_rooms_count = Booking_room_count::where('booking_id',$booking_id)->delete();

        return response()->json(['success'=>'success']);
    }


    public function get_available_rooms_details_for_edit_pending_booking(Request $request){

        $hotel_id = auth()->user()->hotel_id;
        $checkoutDate = $request->input('checkout_date');
        $checkinDate = $request->input('checking_date'); // Corrected variable name to 'checkin_date'
        // Fetch only the rooms with a valid room category
        $roomCategories = Room_category::where('hotel_id', $hotel_id)->get();
        $availableRoomCounts = [];
        foreach ($roomCategories as $category) {
            // Use Eloquent relationships to fetch available rooms for the category
            $bookedRoomIds = Booking_Room::whereHas('booking', function ($query) use ($checkinDate, $checkoutDate) {
                $query->where(function ($q) use ($checkinDate, $checkoutDate) {
                    $q->where('checkout_date', '>', $checkinDate)
                        ->orWhere(function ($subQuery) use ($checkinDate) {
                            $subQuery->where('checkout_date', '=', $checkinDate)
                                ->where('checkout_time', '>', '14:00:00');
                        });
                })->where(function ($q) use ($checkinDate, $checkoutDate) {
                    $q->where('checking_date', '<', $checkoutDate)
                        ->orWhere(function ($subQuery) use ($checkoutDate) {
                            $subQuery->where('checking_date', '=', $checkoutDate)
                                ->where('checking_time', '<=', '12:00:00');
                        });
                });
            })->pluck('room_id')->toArray();

            $availableRooms = Room::where('room_category_id', $category->id)
                ->whereNotIn('id', $bookedRoomIds)
                ->get();

            $availableRoomCount = count($availableRooms);

            $availableRoomCounts[] = [
                'category' => $category, // Assuming the category has a 'name' attribute
                'available_count' => $availableRoomCount,
            ];
        }
        return response()->json(['availableRoomCounts' => $availableRoomCounts]);
    }
    public function edit_pending_booking_save(Request $request){
//return $request;
        $booking_id = $request->input('ep_booking_id');
        $adults = $request->input('ep_adults');
        $children = $request->input('ep_children');
        $total_person = $adults+$children;
        $booking = Booking::find($booking_id);
        $booking->first_name=$request->input('ep_f_name');
        $booking->last_name=$request->input('ep_l_name');
        $booking->phone=$request->input('ep_phone');
        $booking->email=$request->input('ep_email');
        $booking->total_person=$total_person;
        $booking->checking_date=$request->input('ep_check_in_date');
        $booking->checkout_date=$request->input('ep_check_out_date');
        $booking->country=$request->input('ep_country');
        $booking->note=$request->input('ep_note');
        $booking->advance_payment=$request->input('ep_advanced_payment');
        $booking->adults=$adults;
        $booking->children=$children;
        $booking->w_number=$request->input('ep_whatsapp_number');
        $booking->breakfast=$request->input('ep_Breakfast');
        $booking->passport=$request->input('ep_passport_number');
        $booking->booking_method=$request->input('ep_booking_method');
        $booking->booking_code=$request->input('ep_bookingcom_id');
        $booking->booking_type = $request->input('bookingtype');
        if ( $booking->booking_type == 'Day Stay'){
            $booking->checking_date=$booking->checking_date;
            $booking->checkout_date=$booking->checking_date;
            $booking->checking_time= '08:00:00';
            $booking->checkout_time='16:00:00';
        }else{
            $booking->checking_date=$booking->checking_date;
            $booking->checkout_date=$booking->checkout_date;
            $booking->checking_time= '14:00:00';
            $booking->checkout_time='12:00:00';
        }

        if ($image = $request->file('ep_image')) {
            Storage::delete($booking->payment_slip);
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $contentType = $image->getClientMimeType();

            if (!in_array($contentType, $allowedMimeTypes)) {
                $path = Storage::putFile('/booking/thumbnail', $image, 'public');
                $booking->payment_slip = $path;
            } else {
                $path = Storage::putFile('/booking/thumbnail', $image, 'public');
                $file = Image::make($image)
                    ->orientate()
                    ->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                Storage::put($path, (string)$file->encode());
                $booking->payment_slip = $path;
            }
        }
        $booking->save();
        $room_categories = Room_category::where('hotel_id', $booking->hotel_id)->get();
        $total = 0;

        foreach ($room_categories as $room_category) {
            $room_count = $request->input('available_room_count-' . $room_category->id);

            // Update existing booking_room_count if it exists, or create a new one
            $room_count_save = Booking_room_count::updateOrCreate(
                ['booking_id' => $booking->id, 'room_category_id' => $room_category->id],
                ['room_count' => $room_count]
            );

            $total += $room_count;
        }

        // Update the total room count in the booking table
        $booking->room_count = $total;
        $booking->save();

        return redirect()->back()->with('success', 'Booking update success!');
    }
    public function get_pending_booking_details_for_assign(Request $request)
    {
        $booking_id = $request->input('booking_id');
        $pending_booking_details = Booking::with('booking_room_count.room_categories')
            ->where('id', $booking_id)
            ->first();

        $checkingDateTime = Carbon::parse($pending_booking_details->checking_date . ' 14:00:00'); // Set default checking time as 2:00 PM
        $checkoutDateTime = Carbon::parse($pending_booking_details->checkout_date . ' 12:00:00'); // Set default checkout time as 12:00 PM

        $availableRooms = DB::table('rooms')
            ->whereNotIn('id', function ($query) use ($checkingDateTime, $checkoutDateTime) {
                $query->select('room_id')
                    ->from('booking_rooms')
                    ->join('bookings', 'booking_rooms.booking_id', '=', 'bookings.id')


                    ->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                        $query->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checking_date', '<', $checkoutDateTime->format('Y-m-d'))
                                ->where('checkout_date', '>', $checkingDateTime->format('Y-m-d'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checking_date', '=', $checkingDateTime->format('Y-m-d'))
                                ->whereTime('checkout_date', '>=', $checkingDateTime->format('H:i:s'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checkout_date', '=', $checkoutDateTime->format('Y-m-d'))
                                ->whereTime('checking_date', '<=', $checkoutDateTime->format('H:i:s'));
                        });

                    });

            }) ->whereNotIn('id', function ($query) use ($checkingDateTime, $checkoutDateTime) {
                $query->select('room_id')
                    ->from('room_rapairs')
                    ->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                        $query->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('start_date', '<', $checkoutDateTime->format('Y-m-d'))
                                ->where('end_date', '>', $checkingDateTime->format('Y-m-d'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('start_date', '=', $checkingDateTime->format('Y-m-d'))
                                ->whereTime('end_date', '>=', $checkingDateTime->format('H:i:s'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('end_date', '=', $checkoutDateTime->format('Y-m-d'))
                                ->whereTime('start_date', '<=', $checkoutDateTime->format('H:i:s'));
                        });
                    });
            })
            ->get();






        if ($availableRooms->isEmpty()) {
            return response()->json('No rooms available for the selected dates and times.');
        } else {
            return response()->json(['success' => 'success', 'pending_booking_details' => $pending_booking_details, 'availableRooms' => $availableRooms]);
        }
    }

    public function assign_pending_booking_save(Request $request)
    {
        try {
            $booking_id = $request->input('aep_booking_id');
            $total_amount = $request->input('aepf_total_payment');
            $additional_note = $request->input('additional-note');

            $save_booking = Booking::findOrFail($booking_id);
            $agencyModel = AgencyOrGuide::find($save_booking->agency_id);

            if ($agencyModel && ($agencyEmail = $agencyModel->emailAddress ?? $agencyModel->guideEmail)) {
                // If agency email exists, use it
            } elseif ($save_booking->email) {
                // If agency email doesn't exist, use $save_booking->email
                $agencyEmail = $save_booking->email;
            } else {
                // Provide a default email or handle the case where neither agency email nor booking email is available
                $agencyEmail = 'keshanribelz@gmail.com';
            }

            $save_booking->balance = $total_amount - $save_booking->advance_payment;
            $save_booking->status = 'Approved';
            $save_booking->additional_note = $additional_note;

            // Check if rooms are selected before syncing
            $room_ids = $request->input('select_rooms', []);
            if (!empty($room_ids)) {
                $save_booking->rooms()->sync($room_ids);
            }

            $save_booking->save();
        $save_booking->total_amount = $total_amount;
        $customerEmail ='';
        if($save_booking->booking_method == 'Agency'){
            $agencyorguide = AgencyOrGuide::where('id', $save_booking->agency_id)->first();
            if($agencyorguide->AgencyOrGuide == 'agency'){
                $customerEmail = $agencyorguide->emailAddress;
            }else{
                $customerEmail = $agencyorguide->guideEmail;
            }
        }elseif ($save_booking->email!=null){
            $customerEmail = $save_booking->email;
        }

//        return $agencyEmail;
        $save_booking->balance = $total_amount-$save_booking->advance_payment;
        $save_booking->status = 'Approved';
        $save_booking->additional_note = $additional_note;
        $room_ids = $request->input('select_rooms');
        $bookings_r = Booking::find($save_booking->id);
        $bookings_r->rooms()->sync($room_ids);
        $save_booking->save();

            $rooms = Booking_room_count::with('room_categories')->where('booking_id', $save_booking->id)->get();
            $booking_data = new \stdClass;
            $booking_data->bookingdetails = $save_booking;
            $booking_data->roomdata = $rooms;

            // Use Mail::bcc to send emails to multiple recipients
            $recipients = ['info@ravantangalle.com', $agencyEmail, 'indikaribelz@gmail.com', 'kanushkajayanidu99@icloud.com'];
            Mail::to($recipients)->send(new Booking_approved_mail($booking_data));

            return redirect()->back()->with('success', 'Assigned Rooms successfully!');
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        Mail::to('info@ravantangalle.com')->send(new Booking_approved_mail($booking_data));
        Mail::to('indikaribelz@gmail.com')->send(new Booking_approved_mail($booking_data));
        Mail::to('kanushkajayanidu99@icloud.com')->send(new Booking_approved_mail($booking_data));
        if($request->has('notify_customer') and $customerEmail !=''){
            Mail::to($customerEmail)->send(new Booking_approved_mail($booking_data));
        }
        return redirect()->back()->with('success', 'Assigned Rooms successfully!');
    }









    public function change_booking_status_approved_booking(Request $request){
        $booking_id = $request->input('booking_id');
        $booking = Booking::find($booking_id);
        $booking->status = 'Pending';

        $booking_rooms = Booking_room::where('booking_id',$booking_id)->delete();
        $booking->save();
        return response()->json(['success' => 'success']);
    }

    public function upload_xls(Request $request){
        return view('hotel.upload_xls');
    }


    public function upload_xls_save(Request $request){
        $bookings = [];
        $booking_canceled = [];
        $booking_conflict = [];

        $bookinlist = json_decode($request->input('customJSON'), true);

        foreach ($bookinlist as $bookinlistitem){
            if ($bookinlistitem['Booking status'] == "Cancelled" || $bookinlistitem['Booking status'] == "fraudulent"){
                $booking = Booking::with('booking_rooms','booking_room_count')->where('booking_code', $bookinlistitem['Booking No.'])->first();

                if($booking){
                    if ($booking->source == 'Execl-Restore'){
                        continue;
                    }

                    $booking_archive = new Booking_archive();
                    $bookingDataArray = $booking->toArray();

                    $bookingDataArray['booking_rooms'] = json_encode($booking->booking_rooms);
                    $bookingDataArray['booking_room_count'] = json_encode($booking->booking_room_count);
                    $booking_archive->fill($bookingDataArray);

                    $booking_archive->save();

                    $booking_rooms = Booking_room::where('booking_id', $booking->id)->delete();
                    $booking_room_count = Booking_room_count::where('booking_id', $booking->id)->delete();
                    $booking->status = $bookinlistitem['Booking status'].' (Archive)';

                    array_push($booking_canceled, $booking);
                    $booking->delete();

                }else{
                    $booking_archive = Booking_archive::where('booking_code', $bookinlistitem['Booking No.'])->first();

                    if (!$booking_archive){
                        $nameParts = explode(' ', $bookinlistitem['Guest']);

                        $lastName = $nameParts[0]; // First part is always last name

// Check if there's a second part (first name)
                        if (isset($nameParts[1])) {
                            $firstName = $nameParts[1];
                        } else {
                            $firstName = ''; // If only one part, set first name to an empty string
                        }

                        $bookforarchive = new Booking();
                        $bookforarchive->first_name = $firstName;
                        $bookforarchive->last_name = $lastName;
                        $bookforarchive->total_person = $bookinlistitem['Guests'];
                        $bookforarchive->checking_date = $bookinlistitem['Arrival date'];
                        $bookforarchive->checkout_date = $bookinlistitem['Departure date'];
                        $bookforarchive->checking_time = '14:00:00';
                        $bookforarchive->checkout_time = '12:00:00';
                        $bookforarchive->hotel_id = auth()->user()->hotel_id;
                        $bookforarchive->booking_code = $bookinlistitem['Booking No.'];

                        $persons = $bookinlistitem['Guests'] == "" ? 0 : $bookinlistitem['Guests'];
                        $audelts = $persons;

                        $bookforarchive->adults = $audelts;
                        $bookforarchive->booking_method =$bookinlistitem['Point of sale'];
                        $bookforarchive->booking_type ="Night Stay";
                        $bookforarchive->status = "Pending"; //Approved
                        $bookforarchive->source = "Execl";
                        $priceStr = str_replace(["USD", " "], "", $bookinlistitem['Total amount']);
                        $price = floatval($priceStr);
                        $bookforarchive->total_amount = $price * $request->input('exchange_rate');
                        $bookforarchive->balance = $bookforarchive->total_amount;
                        $bookforarchive->payment = "Due";
                        $bookforarchive->note = $bookinlistitem['Guest comment'];
                        $bookforarchive->usd_amount = $price;
                        $bookforarchive->additional_note = $bookinlistitem['Total amount'];
                        $roomCountData = json_decode($bookinlistitem['Room type'], true);
                        $totalRoomCount = array_sum($roomCountData);
                        $bookforarchive->room_count = $totalRoomCount;

                        $bookforarchive->save();

                        $bookingDataArray = $bookforarchive->toArray();

                        $booking_archive = Booking_archive::create($bookingDataArray);

                        $bookforarchive->delete();
                    }
                }
            } elseif ($bookinlistitem['Booking status'] == "Active") {
                Log::info('active');
                $nameParts = explode(' ', $bookinlistitem['Guest']);

                $lastName = $nameParts[0]; // First part is always last name

// Check if there's a second part (first name)
                if (isset($nameParts[1])) {
                    $firstName = $nameParts[1];
                } else {
                    $firstName = ''; // If only one part, set first name to an empty string
                }

                $bookingSearch = Booking::where('booking_code', $bookinlistitem['Booking No.'])->first();
                if ($bookingSearch) {
                    Log::info('have');
                    $bookingSearch->first_name = $firstName;
                    $bookingSearch->last_name = $lastName;
                    $bookingSearch->total_person = $bookinlistitem['Guests'];

                    if (strpos($bookinlistitem['Total amount'], '$') !== false) {
                        $priceStr = str_replace(["$", " "], "", $bookinlistitem['Total amount']);
                        $pricelPre = floatval($priceStr);
                        $price = $pricelPre * $request->input('exchange_rate');
                    } else {
                        $priceStr = str_replace(["LKR", " "], "", $bookinlistitem['Total amount']);
                        $price = floatval($priceStr);
                    }

                    // Fetch room categories associated with the hotel
                    $roomCategories = Room_category::where('hotel_id', $bookingSearch->hotel_id)->pluck('category', 'id')->toArray();

                    // Retrieve room counts associated with the booking
                    $bookingId = Booking::where('booking_code', $bookinlistitem['Booking No.'])->value('id');
                    $roomCountsBack = Booking_room_count::where('booking_id', $bookingId)
                        ->pluck('room_count', 'room_category_id')
                        ->toArray();

                    // Create the final result array with room categories as keys and counts as values
                    $result = [];
                    foreach ($roomCountsBack as $roomId => $count) {
                        // Check if the $roomId exists in $roomCategories
                        // If it does, assign the category to $category, otherwise, set $category to null
                        $category = $roomCategories[$roomId] ?? null;

                        // Ignore items where $count is 0
                        if ($category !== null && $count !== 0) {
                            // If $category is not null and $count is not 0,
                            // set the value in the $result array with the category as the key and the count as the value
                            $result[$category] = $count;
                        }
                    }

                    // Convert the result array to JSON
                    $resultJson = json_encode($result);

                    $checking_date = $bookinlistitem['Arrival date'];
                    $checkout_date = $bookinlistitem['Departure date'];

                    $roomTypeArray = json_decode($bookinlistitem['Room type'], true);
                    $resultArray = json_decode($resultJson, true);

                    // Sort the arrays by keys to ensure consistent order
                    ksort($roomTypeArray);
                    ksort($resultArray);

                    Log::info('room array');
                    Log::info($roomTypeArray);
                    Log::info('result array');
                    Log::info($resultArray);

                    if ($bookinlistitem['Total amount'] != $bookingSearch->usd_amount || $checking_date != $bookingSearch->checking_date || $checkout_date != $bookingSearch->checkout_date || $roomTypeArray != $resultArray) {
                        $bookingSearch->checking_date = $bookinlistitem['Arrival date'];
                        $bookingSearch->checkout_date = $bookinlistitem['Departure date'];
                        $bookingSearch->status = "Pending";
                        $bookingSearch->total_amount = $price;
                        $bookingSearch->usd_amount = $bookinlistitem['Total amount'];

                        $bookingSearchRooms = Booking_room::where('booking_id', $bookingSearch->id)->delete();
                        $bookingSearchRooms = Booking_room_count::where('booking_id', $bookingSearch->id)->delete();

                        array_push($bookings, $bookingSearch);

                        $roomCategories = Room_category::where('hotel_id', $bookingSearch->hotel_id)->get();
                        $roomCounts = json_decode($bookinlistitem['Room type'], true);
                        $total = 0;
                        foreach ($roomCategories as $roomCategory) {
                            $roomCountSave = new Booking_room_count();
                            $roomCountSave->booking_id = Booking::where('booking_code', $bookinlistitem['Booking No.'])->value('id');
                            $roomCountSave->room_category_id = $roomCategory->id;

                            if (isset($roomCounts[$roomCategory->category])) {
                                $roomCountSave->room_count = $roomCounts[$roomCategory->category];
                            } else {
                                $roomCountSave->room_count = 0;
                            }

                            $roomCountSave->save();
                            $total += $roomCountSave->room_count;
                        }
                        $bookingSearch->room_count = $total;
                        $bookingSearch->save();
                    }

                    $persons = $bookinlistitem['Guests'] == "" ? 0 : $bookinlistitem['Guests'];
                    $audelts = $persons;
                    $bookingSearch->adults = $audelts;
                    $bookingSearch->booking_method = $bookinlistitem['Point of sale'];
                    $bookingSearch->note = $bookinlistitem['Guest comment'];
                    $bookingSearch->additional_note = $bookinlistitem['Total amount'];
                    $bookingSearch->phone = $bookinlistitem['Phone'];
                    $bookingSearch->country = $bookinlistitem['Country'];
                    if (strpos($bookinlistitem['Extra services'], 'Breakfast') !== false) {
                        $bookingSearch->breakfast = 'Breakfast';
                    } else {
                        $bookingSearch->breakfast = 'None';
                    }
                    $bookingSearch->save();

                } else {
                    Log::info('have not');
                    // Create a new booking if no existing booking found
                    $booking = new Booking();
                    $booking->first_name = $firstName;
                    $booking->last_name = $lastName;
                    $booking->total_person = $bookinlistitem['Guests'];
                    $booking->checking_date = $bookinlistitem['Arrival date'];
                    $booking->checkout_date = $bookinlistitem['Departure date'];
                    $booking->checking_time = '14:00:00';
                    $booking->checkout_time = '12:00:00';
                    $booking->hotel_id = auth()->user()->hotel_id;
                    $booking->booking_code = $bookinlistitem['Booking No.'];

                    $persons = $bookinlistitem['Guests'] == "" ? 0 : $bookinlistitem['Guests'];
                    $audelts = $persons;

                    $booking->adults = $audelts;
                    $booking->booking_method = $bookinlistitem['Point of sale'];
                    $booking->booking_type = "Night Stay";
                    $booking->status = "Pending";
                    $booking->source = "Excel";

                    if (strpos($bookinlistitem['Total amount'], '$') !== false) {
                        $priceStr = str_replace(["$", " "], "", $bookinlistitem['Total amount']);
                        $price = floatval($priceStr);
                        $booking->total_amount = $price * $request->input('exchange_rate');
                    } else {
                        $priceStr = str_replace(["LKR", " "], "", $bookinlistitem['Total amount']);
                        $price = floatval($priceStr);
                        $booking->total_amount = $price;
                    }

                    $booking->balance = $booking->total_amount;
                    $booking->payment = "Due";
                    $booking->note = $bookinlistitem['Guest comment'];
                    $booking->usd_amount = $price;
                    $booking->additional_note = $bookinlistitem['Total amount'];
                    $booking->booking_code = $bookinlistitem['Booking No.'];
                    $booking->phone = $bookinlistitem['Phone'];
                    $booking->country = $bookinlistitem['Country'];

                    if (strpos($bookinlistitem['Extra services'], 'Breakfast') !== false) {
                        $booking->breakfast = 'Breakfast';
                    } else {
                        $booking->breakfast = 'None';
                    }

                    $booking->save();

                    array_push($bookings, $booking);
                    $roomCategories = Room_category::where('hotel_id', $booking->hotel_id)->get();
                    $roomCounts = json_decode($bookinlistitem['Room type'], true);
                    $total = 0;
                    foreach ($roomCategories as $roomCategory) {
                        $roomCountSave = new Booking_room_count();
                        $roomCountSave->booking_id = Booking::where('booking_code', $bookinlistitem['Booking No.'])->value('id');
                        $roomCountSave->room_category_id = $roomCategory->id;

                        if (isset($roomCounts[$roomCategory->category])) {
                            $roomCountSave->room_count = $roomCounts[$roomCategory->category];
                        } else {
                            $roomCountSave->room_count = 0;
                        }

                        $roomCountSave->save();
                        $total += $roomCountSave->room_count;
                    }
                    $booking->room_count = $total;
                    $booking->save();
                }
            }
        }

        return response()->json(['bookings' => $bookings, 'booking_canceled' => $booking_canceled, 'booking_conflict' => $booking_conflict]);
    }




    public function upload_xls_assign_rooms(Request $request){
//        return $request;
        $booking_id = $request->input('booking_id');
        $breakfast = $request->input('Breakfast');
        $additional_note = $request->input('additional-note');
        $save_booking = Booking::find($booking_id);
        $save_booking->status = 'Approved';
        $save_booking->breakfast = $breakfast;
        $save_booking->additional_note = $save_booking->additional_note." / ".$additional_note;
//        $save_booking->additional_note = $additional_note;
        $room_ids = $request->input('select_rooms');
        Log::info('roooooommmm iiiidddd');
        Log::info($room_ids);
        $bookings_r = Booking::find($save_booking->id);
        $bookings_r->rooms()->sync($room_ids);
        $save_booking->save();
        $Booking = Booking::with('booking_rooms.room')->find($save_booking->id);


        $booking_room_counts = Booking_room_count::where('booking_id',$Booking->id)->get();

        foreach ($booking_room_counts as $booking_room_count){
            $thiscategoryRoomcount = 0;
            foreach ($Booking->booking_rooms as $booking_room){
                if($booking_room->room->room_category_id == $booking_room_count->room_category_id){
                    $thiscategoryRoomcount++;
                }
            }
            $room_count_save = Booking_room_count::find($booking_room_count->id);
            $room_count_save->room_count = $thiscategoryRoomcount;
            $room_count_save->save();

        }
//        $room_count_save = Booking_room_count::where('booking_id',$Booking->id)->where('room_category_id', )->
//        $room_count_save->save();


        $Rooms = implode(', ', $Booking->booking_rooms->pluck('room.room_number')->toArray());
        return response()->json(['rooms'=>$Rooms,'booking'=>$Booking]);
    }
    public function get_available_rooms_for_assign_xls(Request $request)
    {
        $booking_id = $request->input('booking_id');
        $pending_booking_details = Booking::with('booking_room_count.room_categories')
            ->where('id', $booking_id)
            ->first();

        $checkingDateTime = Carbon::parse($pending_booking_details->checking_date . ' 14:00:00'); // Set default checking time as 2:00 PM
        $checkoutDateTime = Carbon::parse($pending_booking_details->checkout_date . ' 12:00:00'); // Set default checkout time as 12:00 PM

        $availableRooms = DB::table('rooms')
            ->whereNotIn('id', function ($query) use ($checkingDateTime, $checkoutDateTime) {
                $query->select('room_id')
                    ->from('booking_rooms')
                    ->join('bookings', 'booking_rooms.booking_id', '=', 'bookings.id')
                    ->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                        $query->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checking_date', '<', $checkoutDateTime->format('Y-m-d'))
                                ->where('checkout_date', '>', $checkingDateTime->format('Y-m-d'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checking_date', '=', $checkingDateTime->format('Y-m-d'))
                                ->whereTime('checkout_date', '>=', $checkingDateTime->format('H:i:s'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checkout_date', '=', $checkoutDateTime->format('Y-m-d'))
                                ->whereTime('checking_date', '<=', $checkoutDateTime->format('H:i:s'));
                        });
                    });
            })
            ->get();

        $room_category = Room_category::with(['room'=>function ($query){$query->where('status',null);}])->where('status','Active')->where('hotel_id',auth()->user()->hotel_id)->get();

        if ($availableRooms->isEmpty()) {
            return response()->json('No rooms available for the selected dates and times.');
        } else {
            return response()->json(['success' => 'success', 'pending_booking_details' => $pending_booking_details, 'availableRooms' => $availableRooms, 'room_category' => $room_category]);
        }
    }
    public function get_available_rooms_for_assign_spliit(Request $request)
    {
        $booking_id = $request->input('booking_id');
        $checkInDate = $request->input('checkInDate');
        $checkOutDate = $request->input('checkOutDate');
        $pending_booking_details = Booking::with('booking_room_count.room_categories')
            ->where('id', $booking_id)
            ->first();

        $checkingDateTime = Carbon::parse($checkInDate . ' 14:00:00'); // Set default checking time as 2:00 PM
        $checkoutDateTime = Carbon::parse($checkOutDate . ' 12:00:00'); // Set default checkout time as 12:00 PM

        $availableRooms = DB::table('rooms')
            ->whereNotIn('id', function ($query) use ($checkingDateTime, $checkoutDateTime) {
                $query->select('room_id')
                    ->from('booking_rooms')
                    ->join('bookings', 'booking_rooms.booking_id', '=', 'bookings.id')
                    ->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                        $query->where(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checking_date', '<', $checkoutDateTime->format('Y-m-d'))
                                ->where('checkout_date', '>', $checkingDateTime->format('Y-m-d'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checking_date', '=', $checkingDateTime->format('Y-m-d'))
                                ->whereTime('checkout_date', '>=', $checkingDateTime->format('H:i:s'));
                        })->orWhere(function ($query) use ($checkingDateTime, $checkoutDateTime) {
                            $query->where('checkout_date', '=', $checkoutDateTime->format('Y-m-d'))
                                ->whereTime('checking_date', '<=', $checkoutDateTime->format('H:i:s'));
                        });
                    });
            })
            ->get();

        $room_category = Room_category::with(['room'=>function ($query){$query->where('status',null);}])->where('status','Active')->where('hotel_id',auth()->user()->hotel_id)->get();

        if ($availableRooms->isEmpty()) {
            return response()->json('No rooms available for the selected dates and times.');
        } else {
            return response()->json(['success' => 'success', 'pending_booking_details' => $pending_booking_details, 'availableRooms' => $availableRooms, 'room_category' => $room_category]);
        }
    }
    public function view_job_application_list()
    {

        $job_position_category = Job_position_category::where('status', null)->get();
        $jobapplications = Job_application_detail::with('job_positions.job_position_categories')->where('hotel_id', auth()->user()->hotel_id)->where('status', 'Active')->get();

       // return $jobapplications;
        return view('hotel.view_job_application', [
            'jobapplications' => $jobapplications,
            'job_position_category' => $job_position_category,
        ]);


    }



    public function view_detail_job_application_complete($id)
    {


        $jobapplications = Job_application_detail::where('hotel_id', auth()->user()->hotel_id)->get()->find($id);
        $food_attachments = Food_attachment::where('application_id', $id)->get();
        $job_position_category = Job_position_category::where('status', null)->get();





//        return view('hotel.view_application_details', ['jobapplications' => $jobapplications , 'uniq_id' => $uniqid , 'food_attachment' => $food_attachment]);
        return view('hotel.view_application_details', ['jobapplications' => $jobapplications,  'food_attachments' => $food_attachments ,  'job_position_category' => $job_position_category]);

    }


    public function job_application_delete(Request $request)
    {

        $date = date('Y-m-d');
        $job_application_id = $request->input('job_application_id');

        $jobapplications = Job_application_detail::find($job_application_id);
       // \LogActivity::addToLog('WASTAGE', $date, 'WASTAGE', null, null, $repair->id, $repair->reason, null, $repair->location, $repair->person, Auth::id(), 'Delete wastage');
        Storage::delete($jobapplications->image);
        $jobapplications->status = 'Block';
        $jobapplications->save();
        return response()->json(['success' => 'success']);
    }

    public function job_application_detail_get(Request $request)
    {
        $job_application_id = $request->input('job_application_id');
        $job_application_details = Job_application_detail::with('job_positions')->find($job_application_id);
        return response()->json(['job_application_details' => $job_application_details]);
    }


   public function update_add_remark(Request $request)
   {
       // Validate the request data as needed

       $job_application_id = $request->input('job_application_id');
       $jobapplication = Job_application_detail::find($job_application_id);

//       if (!$jobapplication) {
//           return response()->json(['error' => 'Job application not found!'], 404);
//       }

       // Update the job application details
       $jobapplication->date = $request->input('date');
       $jobapplication->first_name = $request->input('first_name');
       $jobapplication->last_name = $request->input('last_name');
       $jobapplication->address = $request->input('address');
       $jobapplication->country = $request->input('country');
       $jobapplication->city = $request->input('city');
       $jobapplication->birthday = $request->input('birthday');
       $jobapplication->email = $request->input('email');
       $jobapplication->phone = $request->input('phone');
       $jobapplication->whatsapp_number = $request->input('whatsapp_number');
       $jobapplication->gender = $request->input('gender');
       $jobapplication->experience = $request->input('experience');
       $jobapplication->english_level = $request->input('english_level');
       $jobapplication->salary = $request->input('salary');
       $jobapplication->special_note = $request->input('special_note');

       // Check if a new job_dp_image is uploaded and process it accordingly
       if ($image = $request->file('job_dp_image')) {
           $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
           $contentType = $image->getClientMimeType();
           if (in_array($contentType, $allowedMimeTypes)) {
               $path = Storage::putFile('/job_dp_image/thumbnail', $image, 'public');
               $file = Image::make($image)
                   ->orientate()
                   ->resize(500, null, function ($constraint) {
                       $constraint->aspectRatio();
                       $constraint->upsize();
                   });
               Storage::put($path, (string)$file->encode());
               $jobapplication->job_dp_image = $path;
           }
       }

       // Check if a new CV is uploaded and process it accordingly
       if ($cv = $request->file('cv')) {
           $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
           $contentType = $cv->getClientMimeType();
           $path = Storage::putFile('/cv/thumbnail', $cv, 'public');
           if (in_array($contentType, $allowedMimeTypes)) {
               $file = Image::make($cv)
                   ->orientate()
                   ->resize(800, null, function ($constraint) {
                       $constraint->aspectRatio();
                       $constraint->upsize();
                   });
               Storage::put($path, (string)$file->encode());
               $jobapplication->cv = $path;
           } else {
             $jobapplication->cv = $path;
           }
       }


       $positions = $request->input('position');
       if ($positions) {
           $job_positions = [];
           foreach ($positions as $position) {
               $job_positions[] = [
                   'application_id' => $jobapplication->id,
                   'job_position_category_id' => $position,
               ];
           }
           // Update the job positions for this job application
           Job_position::where('application_id', $jobapplication->id)->delete();
           Job_position::insert($job_positions);
       }
       // Save the updated job application
       $jobapplication->save();

       // Update food_attachments (if needed)
       $food_attachments = Food_attachment::where('application_id', $jobapplication->application_id)->get();
       foreach ($food_attachments as $food_attachment) {
           $food_attachment->application_id = $jobapplication->id;
           $food_attachment->save();
       }
       $jobapplication = Job_application_detail::with('job_positions.job_position_categories')->find($job_application_id);

       return response()->json(['success' => 'Job application has been updated successfully!', 'jobapplication' => $jobapplication]);
   }


    public function suppler(Request $request)
    {
        $supplier = Supplier::where('hotel_id', auth()->user()->hotel_id)->where('status', null)->get();

//        $grn_list = Goods_received_note::with('goods_received_note_detail', 'user' , 'supplier_details')->where('hotel_id', auth()->user()->hotel_id)->get();

        if (auth()->user()->role == 'Admin') {
            $cash_books = Cashbook::where('hotel_id', auth()->user()->hotel_id)->get();

        } elseif (auth()->user()->role == 'Staff') {

            $assing_cashbook_ids = Assigned_cash_book::select('cashbook_id')->where('user_id', auth()->user()->id)->get()->pluck('cashbook_id');
            $cash_books = Cashbook::whereIn('id', $assing_cashbook_ids)->get();
        }

//        $items = Item::where('hotel_id', auth()->user()->hotel_id)->get();
//        if (auth()->user()->role == 'Admin') {
//            $cash_books = Cashbook::where('hotel_id', auth()->user()->hotel_id)->get();
//
//        } elseif (auth()->user()->role == 'Staff') {
//
//            $assing_cashbook_ids = Assigned_cash_book::select('cashbook_id')->where('user_id', auth()->user()->id)->get()->pluck('cashbook_id');
//            $cash_books = Cashbook::whereIn('id', $assing_cashbook_ids)->get();
//        }


        return view('hotel.supplier', ['suppliers'=>$supplier,'grn_list' => '', 'cash_books' => $cash_books]);
    }
    public function supplier_save(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $supplier_name = $request->input('supplier_name');
        $address = $request->input('address');
        $shop_name = $request->input('shop_name');

        $supplier = new Supplier();
        $supplier->supplier_name = $supplier_name;
        $supplier->address = $address;
        $supplier->shop_name = $shop_name;
        $supplier->hotel_id = $hotel_id;
        $supplier->paid_status = 'New';

        $supplier->save();
        return response()->json(['success'=>'success','supplier'=>$supplier]);
    }

    public function get_edit_supplier_details(Request $request){
        $supplier_id =  $request->input('supplier_id');

        $edit_supplier = Supplier::where('id',$supplier_id)->first();

        return response()->json(['success'=>'success','edit_supplier'=>$edit_supplier]);
    }

    public function edit_supplier_save(Request $request){
        $id = $request->input('e_supplier_id');
        $supplier_name = $request->input('e_supplier_name');
        $address = $request->input('e_address');
        $shop_name = $request->input('e_shop_name');

        $supplier = Supplier::find($id);
        $supplier->supplier_name = $supplier_name;
        $supplier->address = $address;
        $supplier->shop_name = $shop_name;
        $supplier->save();

        return response()->json(['success'=>'success','supplier'=>$supplier]);
    }

    public function supplier_delete(Request $request){
        $supplier_id = $request->input('supplier_id');
        $grn = Goods_received_note::where('supplier',$supplier_id)->count();
        $sup_pay = Supplier_payment::where('supplier_id',$supplier_id)->count();
        if (($grn != 0) or ($sup_pay != 0)) {
            return response()->json(['error'=>$grn]);
        }
        else{
            $supplier = Supplier::find($supplier_id);
            $supplier->status = 'Block';
            $supplier->save();
            return response()->json(['success'=>'success']);
        }

    }

    public function get_supplier_second_payment_details(Request $request)
    {
        $supplier_id = $request->input('supplier_id');
//        return $supplier_id;
//        $supplier = Supplier::find($supplier_id);
        $grn = Goods_received_note::with('supplier_details')->where('supplier', $supplier_id)->where('status', 'Pending Amount')->get();
        $expance = Expense::with('supplier_details')->where('supplier', $supplier_id)->where('status', 'Pending Amount')->get();
        $record_details = Supplier_payment::where('supplier_id', $supplier_id)->get();
//        return $grn;
        return response()->json(['expance' => $expance,'grn' => $grn,'supplier_id' => $supplier_id,'record_details' => $record_details]);
    }

    public function supplier_save_payment(Request $request)
    {

        $grn_id = $request->input('grn_id');
        $total_amount = $request->input('total_amount');
        $cashbook_id = $request->input('cashbook_id');


        if($request->input('paid_amount') == null){
            $paid_amount = 0;
        }
        else{
            $paid_amount = $request->input('paid_amount');
        }

        if($request->input('balance') == null){
            $balance = $total_amount;
        }
        else{
            $balance = $request->input('balance');
        }

//        $grn_supplier = Goods_received_note::find($grn_id);
        $grn = Goods_received_note::find($grn_id);

        $payment = new Supplier_payment();
        $payment->date = date('Y-m-d');
        $payment->grn_id = $grn_id;
        $payment->total_amount = $total_amount;
        $payment->paid_amount = $paid_amount;
        $payment->balance = $balance;
        $payment->supplier_id = $grn->supplier;
        $payment->hotel_id = auth()->user()->hotel_id;

//        $payment->user_id = auth()->user()->id;


//        return $payment->supplier_id;
        $supplier = Supplier::find($payment->supplier_id);
        $supplier_total_amount = $supplier->total_amount;
        $supplier_paid_amount = $supplier->paid_amount;
        $supplier->total_amount = $supplier_total_amount+$total_amount;
        $supplier->paid_amount = $supplier_paid_amount+$paid_amount;
        if ($supplier_total_amount+$total_amount == $supplier_paid_amount+$paid_amount) {
            $supplier->paid_status = 'Paid';
        } else {
            $supplier->paid_status = 'Pending Amount';
        }
        $supplier->save();


        $grn->paid_cost = $paid_amount;
        $grn->balance = $balance;
        if ($payment->total_amount == $payment->paid_amount) {
            $grn->status = 'Paid';
        } else {
            $grn->status = 'Pending Amount';
        }
        $grn->save();

        $cash_book_id = $cashbook_id;
        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Credited By Grn' . ' ' . '(' . $grn->id . ')';

        $cash_book_log = new Cash_book_log_activity();
        $cash_book_log->cashbook_id = $cash_book_id;
        $cash_book_log->hotel_id = auth()->user()->hotel_id;
        $cash_book_log->credit = $paid_amount;
        $cash_book_log->date = $grn->date;
        $cash_book_log->user_id = auth()->user()->id;
        $cash_book_log->grn_id = $grn->id;
        $cash_book_log->remark = $remark;
        $cash_book_log->status = 'Active';
        $cash_book_log->save();

        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Credit');

        $payment->cashbook_id = $cash_book_log->id;
        $payment->save();

        return redirect()->route('hotel/grn/view');
        return redirect()->back()->with('success');
    }

    public function supplier_detail_make_payment_save(Request $request)
    {
//        return $request;
        $supplier_id = $request->input('supplier_id');

        $supplier_all_paid = 0;
//grn
        $grns = Goods_received_note::where('supplier', $supplier_id)->where('status', 'Pending Amount')->get();
        foreach ($grns as $grn){
            if ($request->has('grn-pid-'.$grn->id)){

                $payment = new Supplier_payment();
                $payment->date = date('Y-m-d');
                $payment->grn_id = $grn->id;
                $payment->total_amount = $grn->total;
                $payment->paid_amount = $request->input('pay-a-'.$grn->id);
                $payment->balance = $grn->total-($grn->paid_cost+$request->input('pay-a-'.$grn->id));
                $payment->supplier_id = $grn->supplier;
//                $payment->cashbook_id = $request->input('cash_book_id');
                $payment->hotel_id = auth()->user()->hotel_id;
                $payment->save();

                $grn_edit = Goods_received_note::find($grn->id);

                $grn_total = $grn_edit->total;
                $grn_paid_cost = $grn_edit->paid_cost;
                $update_grn_paid_cost = $grn_paid_cost + $request->input('pay-a-'.$grn->id);
                $grn_balance = $grn_total - $update_grn_paid_cost;


                $grn_edit->paid_cost = $update_grn_paid_cost;
                $grn_edit->balance = $grn_balance;
                if ($grn_edit->total == $update_grn_paid_cost) {
                    $grn_edit->status = 'Paid';
                    $grn_edit->remark = 'Paid';
                } else {
                    $grn_edit->status = 'Pending Amount';
                    $grn_edit->remark = 'Unpaid';
                }
                $grn_edit->save();

                $supplier_all_paid += $request->input('pay-a-'.$grn->id);

                $cash_book_id = $request->input('cash_book_id');
                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Credited By Grn' . ' ' . '(' . $grn->id . ')';

                $cash_book_log = new Cash_book_log_activity();
                $cash_book_log->cashbook_id = $cash_book_id;
                $cash_book_log->hotel_id = auth()->user()->hotel_id;
                $cash_book_log->credit = $request->input('pay-a-'.$grn->id);
                $cash_book_log->date = $grn->date;
                $cash_book_log->user_id = auth()->user()->id;
                $cash_book_log->grn_id = $grn->id;
                $cash_book_log->remark = $remark;
                $cash_book_log->status = 'Active';
                $cash_book_log->save();

                \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Credit');
                $payment->cashbook_id = $cash_book_log->id;
                $payment->save();
            }

        }


//expenses
        $expenses = Expense::where('supplier', $supplier_id)->where('status', 'Pending Amount')->get();
        foreach ($expenses as $expens){
            if ($request->has('expences-pid-'.$expens->id)){

//                $expense_id = $request->input('expenses_id');
//                $paid_amount = $request->input('paid_amount');
//                $total_amount = $request->input('total_amount');
//                $balance = $request->input('balance');
//                $date = $request->input('sp_date');
//                $cashbook_id = $request->input('cash_book_id');

                $payment = new Payment();
                $payment->date = date('Y-m-d');;
                $payment->expenses_id = $expens->id;
                $payment->cashbook_id = $request->input('cash_book_id');
                $payment->total_amount = $expens->total_cost;
                $payment->paid_amount = $request->input('expences-pay-a-'.$expens->id);
                $payment->balance = ($expens->total_cost - $request->input('expences-pay-a-'.$expens->id));
                $payment->hotel_id = auth()->user()->hotel_id;
                $payment->user_id = auth()->user()->id;
                $payment->save();

                $expense = Expense::find($expens->id);
                $expense->paid_cost = $expense->paid_cost + $request->input('expences-pay-a-'.$expens->id);

                if ($payment->total_amount == $expense->paid_cost) {
                    $expense->status = 'Paid';
                    $expense->balance = 0;
                } else {
                    $expense->status = 'Pending Amount';
                    $expense->balance = $expense->balance - $request->input('expences-pay-a-'.$expens->id);
                    $payment->balance = $expense->balance;
                    $payment->save();
                }
                $expense->save();

                $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Pay Balance By' . ' ' . '(' . $payment->expenses_id . ') ' . 'Bill';

                $cash_book_log = new Cash_book_log_activity();
                $cash_book_log->cashbook_id = $request->input('cash_book_id');;
                $cash_book_log->hotel_id = auth()->user()->hotel_id;
                $cash_book_log->credit = $payment->paid_amount;
                $cash_book_log->date = $payment->date;
                $cash_book_log->user_id = auth()->user()->id;
                $cash_book_log->expense_id = $payment->expenses_id;
                $cash_book_log->payment_id = $payment->id;
                $cash_book_log->remark = $remark;
                $cash_book_log->status = 'Active';
                $cash_book_log->save();

                \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Credit');

            }
        }
        $supplier = Supplier::find($supplier_id);
//        return $supplier;
        $supplier_total_amount = $supplier->total_amount;
        $supplier_paid_amount = $supplier->paid_amount;

        $supplier->paid_amount = $supplier_paid_amount+$supplier_all_paid;
        if ($supplier_total_amount == $supplier_paid_amount+$supplier_all_paid) {
            $supplier->paid_status = 'Paid';
        } else {
            $supplier->paid_status = 'Pending Amount';
        }
        $supplier->save();

        return redirect()->back()->with(['success' => 'Payment added successfully']);

    }

    public function get_all_supplier_history(Request $request)
    {

        $supplier_id = $request->input('supplier_id');

        $record_details = Supplier_payment::where('supplier_id', $supplier_id)->get();
        $record_details_grn = Goods_received_note::where('supplier', $supplier_id)->orderBy('id', 'desc')->get();
        $record_details_expences = Expense::with('payment')->where('supplier', $supplier_id)->orderBy('id', 'desc')->get();

        $merged_records = $record_details_grn->concat($record_details_expences);
        $sorted_records = $merged_records->sortBy('created_at');
        $sorted_records = $sorted_records->values()->all();
//        $record_details_expences = Goods_received_note::where('supplier', $supplier_id)->orderBy('id', 'desc')->get();
        $record_details_supplier = Supplier::where('id', $supplier_id)->first();

        return response()->json(['record_details' => $record_details,'record_details_grn' => $sorted_records,'record_details_supplier' => $record_details_supplier]);
    }

    public function finance(Request $request)
    {
        $start_date = null;
        $end_date = null;

        if($request->has('start_date') and $request->has('end_date')){
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
        }

        $start = Carbon::parse($start_date); //2023-08-27T10:44:16.594986Z
        $end = Carbon::parse($end_date);  //2023-09-27T10:44:16.595025Z

//        return [$start,$end];
         $rooms_income = Reservation::whereBetween('check_in_date', [$start_date, $end_date]) ->sum('room_chagers_lkr');
         $food_postpaid_income = Order_list::whereNotIn('payment_method', ['Pre-paid', 'Free'])->whereBetween('finalize_date', [$start_date, $end_date])->sum('total');
         $food_prepaid_income = Order_list::whereIn('payment_method', ['Pre-paid', 'Free'])->whereBetween('finalize_date', [$start_date, $end_date])->sum('total');
         $room_cost = Cash_book_log_activity::where('cashbook_id','7')->whereBetween('date', [$start_date, $end_date])->sum('credit');
         $food_cost = Cash_book_log_activity::where('cashbook_id','5')->whereBetween('date', [$start_date, $end_date])->sum('credit');
         $other_expense = Expense::select('id')->whereBetween('date', [$start_date, $end_date])->get()->pluck('id');
//        return [$rooms_income,$food_income,$room_cost,$food_cost,$other];

//        $record_details = Supplier_payment::where('supplier_id', $supplier_id)->get();
//        $record_details_grn = Goods_received_note::where('supplier', $supplier_id)->orderBy('id', 'desc')->get();
//        $record_details_supplier = Supplier::where('id', $supplier_id)->first();
//  room cost -
//        return response()->json(['record_details' => $record_details,'record_details_grn' => $record_details_grn,'record_details_supplier' => $record_details_supplier]);
        return view('hotel.view_finance', compact('rooms_income', 'food_prepaid_income','food_postpaid_income', 'room_cost', 'food_cost', 'other_expense','start_date','end_date'));
    }

    public function customer()
    {
//        $customerIds = Reservation::select([
//            DB::raw('MAX(id) as max_id'),
//            'email',
//        ])
//            ->where('hotel_id', auth()->user()->hotel_id)
//            ->whereNull('deleted_at')
//            ->groupBy('email')
//            ->get();
//
//        $emailAddresses = $customerIds->pluck('email')->toArray();

        $customers = Reservation::select('email')
            ->selectRaw('MAX(created_at) as created_at')
            ->selectRaw('MAX(updated_at) as updated_at')
            ->selectRaw('MAX(deleted_at) as deleted_at')
            ->selectRaw('MAX(id) as id')
            ->selectRaw('MAX(customer_id) as customer_id')
            ->selectRaw('MAX(first_name) as first_name')
            ->selectRaw('MAX(last_name) as last_name')
            ->selectRaw('MAX(booking_method) as booking_method')
            ->selectRaw('MAX(address) as address')
            ->selectRaw('MAX(country) as country')
            ->selectRaw('MAX(passport_number) as passport_number')
            ->selectRaw('MAX(phone) as phone')
            ->selectRaw('MAX(whatsapp_number) as whatsapp_number')
            ->selectRaw('MAX(check_in_date) as check_in_date')
            ->selectRaw('MAX(check_out_date) as check_out_date')
            ->selectRaw('MAX(room_type1) as room_type1')
            ->selectRaw('MAX(guests) as guests')
            ->selectRaw('MAX(special_note) as special_note')
            ->selectRaw('MAX(nights) as nights')
            ->selectRaw('MAX(room_type2) as room_type2')
            ->selectRaw('MAX(room_type3) as room_type3')
            ->selectRaw('MAX(breakfast) as breakfast')
            ->selectRaw('MAX(room_chagers_lkr) as room_chagers_lkr')
            ->selectRaw('MAX(room_chagers_usd) as room_chagers_usd')
            ->selectRaw('MAX(card_payment) as card_payment')
            ->selectRaw('MAX(cash_payment) as cash_payment')
            ->selectRaw('MAX(advance_payment) as advance_payment')
            ->selectRaw('MAX(hotel_id) as hotel_id')
            ->selectRaw('MAX(balance) as balance')
            ->whereNull('deleted_at')
            ->groupBy('email')
            ->orderBy('created_at', 'DESC')
            ->get();

     $customerts = Customer::with('reservation')

            ->where('hotel_id', auth()->user()->hotel_id)
            ->get();
        ;


//

        return view('hotel.customer', ['customers' => $customers , 'customerts'=> $customerts]);
    }

    public function customerdetails1($email){
        $customerDetails = Reservation::where('email', $email)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->orderBy('id','desc')
            ->first();






        $resvations = Reservation::with('reservation_rooms')->where('email', $email)
            ->where('hotel_id', auth()->user()->hotel_id)
            ->get();
        $results = Order_list::with('order_list_detail', 'room' )->whereIn('reservation_id',Reservation::select('id')->where('email', $email)->where('hotel_id', auth()->user()->hotel_id)->get()->pluck('id'))->get();

        return view('hotel.customer_details1', ['customerDetails' => $customerDetails, 'results' => $results, 'resvations'=>$resvations,  ]);
    }

    public function get_customer_edit(Request $request){
        $customer_id = $request->input('edit_customer_id');

        $customerDetails = Reservation::where('customer_id', $customer_id)->first();

        if (!$customerDetails) {
            return response()->json(['error' => 'Customer not found']);

        } else {
            return response()->json(['success' => 'success', 'customerDetails' => $customerDetails]);
        }
    }

//
//    public function save_customer_edit(Request $request)
//    {
//        $customer_id = $request->input('edit_customer_id');
//        $customer_fname = $request->input('e_fname');
//        $customer_lname = $request->input('e_lname');
//        $customer_email = $request->input('e_email');
//        $customer_passport = $request->input('e_passport');
//
//
//        $customerDetailsave = Customer::where('id', $customer_id)->first();
//
//        if ($customerDetailsave) {
//            $customerDetailsave->first_name = $customer_fname;
//            $customerDetailsave->last_name = $customer_lname;
//            $customerDetailsave->email = $customer_email;
//            $customerDetailsave->passport_number = $customer_passport;
//
//            $customerDetailsave->save();
//
//
//
//                Reservation::where('customer_id', $customer_id)
//                    ->update([
//                        'first_name' => $request->input('e_fname'),
//                        'last_name' => $request->input('e_lname'),
//                        // Update more columns as needed
//                    ]);
//
//
//
//
//            return response()->json(['success' => 'success', 'customerDetailsave' => $customerDetailsave, 'reservation' => $reservation]);
//        } else {
//            return response()->json(['error' => 'Customer not found']);
//        }
//    }



    public function save_customer_edit(Request $request)
    {
        $customer_id = $request->input('edit_customer_id');
        $customer_fname = $request->input('e_fname');
        $customer_lname = $request->input('e_lname');
        $customer_email = $request->input('e_email');
        $customer_passport = $request->input('e_passport');


        $customerDetailsave = Customer::where('id', $customer_id)->first();

        if ($customerDetailsave) {
            $customerDetailsave->first_name = $customer_fname;
            $customerDetailsave->last_name = $customer_lname;
            $customerDetailsave->email = $customer_email;
            $customerDetailsave->passport_number = $customer_passport;

            $customerDetailsave->save();


            Reservation::where('customer_id', $customer_id)
                ->update([
                    'first_name' => $request->input('e_fname'),
                    'last_name' => $request->input('e_lname'),
                    'email'     => $request->input('e_email'),
                    'passport_number'=>  $request->input('e_passport'),
                ]);

            return response()->json(['success' => 'success', 'customerDetailsave' => $customerDetailsave]);
        } else {
            return response()->json(['error' => 'Customer not found']);
        }
    }

    public function test()
    {

//        $cashbooks = Cashbook::all();
//        $this_month = Carbon::now()->startOfMonth();
//        $last_month_start = Carbon::now()->subMonths(2)->endOfMonth();
//        $last_month_start_real = Carbon::now()->subMonth()->startOfMonth();
//        $last_month_end = Carbon::now()->subMonth()->endOfMonth();
//
//        \Log::info("Testing Cron is Running ... !".$last_month_start.'last_end'.$last_month_end);
//
//        foreach ($cashbooks as $cashbook){
//            $Cost_Total = Cash_book_log_activity::whereBetween('date', [$last_month_start, $last_month_end])
//                ->where('cashbook_id' ,$cashbook->id)
//                ->where('status','Active')
//                ->selectRaw('SUM( debit) total_debit,SUM( credit) total_credit')
//                ->first();
//            $cashbook_monthly_records = Cashbook_monthly_record::where('date',$last_month_start_real)->where('cashbook_id',$cashbook->id)->first();
//
////            \Log::info($cashbook_monthly_records);
//
//            $new_cashbook_month_record = new Cashbook_monthly_record();
//            $new_cashbook_month_record->total_debit = $Cost_Total->total_debit != null ? $Cost_Total->total_debit:0;
//            $new_cashbook_month_record->total_credit = $Cost_Total->total_credit != null ? $Cost_Total->total_credit:0;
//            $new_cashbook_month_record->balance = ($cashbook_monthly_records->balance + $new_cashbook_month_record->total_debit) - $new_cashbook_month_record->total_credit;
//            $new_cashbook_month_record->date = $this_month;
//            $new_cashbook_month_record->cashbook_id = $cashbook->id;
//            $new_cashbook_month_record->save();
//
//            \Log::info($cashbook_monthly_records->balance);
//            \Log::info($new_cashbook_month_record->balance);
//
//        }
//        return 'testing:cron Command Run Successfully !';
    }



















































    public function other_income(Request $request)
    {
        $other_income_category_list = Other_income_category_list::where('status', null)->get();
        return view('hotel.other_income', ['other_income_category_lists'=>$other_income_category_list]);
    }

    public function other_income_save(Request $request)
    {
//        $hotel_id = auth()->user()->hotel_id;
        $f_name = $request->input('f_name');
        $l_name = $request->input('l_name');
        $date = $request->input('date');
        $country = $request->input('country');
        $telephone_number = $request->input('telephone_number');
        $whatsapp_number = $request->input('whatsapp_number');
        $passport_number = $request->input('passport_number');
        $email = $request->input('email');
//        $item = $request->input('item');
//        $quantity = $request->input('quantity');
//        $price = $request->input('price');
        $payment_method = $request->input('payment_method');
        $note = $request->input('note');
        $remark = $request->input('remark');

        $other_income = new Other_income();
        $other_income->date =$date;
        $other_income->first_name = $f_name;
        $other_income->last_name = $l_name;
        $other_income->country = $country;
        $other_income->telephone_number = $telephone_number;
        $other_income->whatsapp_number = $whatsapp_number;
        $other_income->passport_number = $passport_number;
        $other_income->email_address = $email;
        $other_income->payment_method = $payment_method;
        $other_income->note = $note;
        $other_income->hotel_id = auth()->user()->hotel_id;
        $other_income->save();




        $count = $request->input('count');
        $total_amount = 0;
//        $other_income_payment_history= new Other_income_payments_history();
//        $other_income_payment_history->date= $date;
//        $other_income_payment_history->other_income_id= $other_income->id;
//        $other_income_payment_history->payment_method= $payment_method;



        for ($i = 1; $i <= $count; $i++) {
            if ($request->has('item-' . $i) && $request->has('quantity-' . $i) && $request->has('price-' . $i) && $request->has('description-' . $i)) {

                $item = $request->input('item-' . $i);
                $quantity = $request->input('quantity-' . $i);
                $price = $request->input('price-' . $i);
                $description = $request->input('description-' . $i);

                // Calculate total amount for each item
                $item_total_amount = $quantity * $price;

                $total_amount += $item_total_amount;

                if ($item != "" && $quantity != "" && $price != "" && $description != "") {
                    $other_income_item_detail = new Other_income_item_detail();
                    $other_income_item_detail->other_income_id = $other_income->id;
                    $other_income_item_detail->item_id = $item;
                    $other_income_item_detail->quantity = $quantity;
                    $other_income_item_detail->price = $price;

                    $other_income_item_detail->description = $description;
                    $other_income_item_detail->save();
                }
            }
        }

// Update total_amount in the other_incomes table
        $other_income->total_amount = $total_amount;
//        $other_income_payment_history->total_amount = $total_amount;
//        $other_income_payment_history->paid_amount = $total_amount;
//        $other_income_payment_history->balance = 0;
//        $other_income_payment_history->save();

        $other_income->save();


//        return $total_amount;

        if ($remark == 'Unpaid') {
            $other_income->paid_status = 'Pending Amount';
            $other_income->total_amount = $total_amount;
            $other_income->paid_amount = 0;
            $other_income->save();

            $other_income_payment = new Other_income_payment();
            $other_income_payment->date = date('Y-m-d');
            $other_income_payment->other_income_id	 = $other_income->id;
            $other_income_payment->total_amount = $total_amount;
            $other_income_payment->paid_amount = 0;
            $other_income_payment->balance = $total_amount;
            $other_income_payment->status = 'Pending Amount';
            $other_income_payment->save();

            $other_income_payment_history= new Other_income_payments_history();
            $other_income_payment_history->date= $date;
            $other_income_payment_history->other_income_id= $other_income_payment->id;
            $other_income_payment_history->total_amount = $total_amount;
            $other_income_payment_history->paid_amount = 0;
            $other_income_payment->balance = $total_amount;
            $other_income_payment_history->payment_method= $payment_method;
            $other_income_payment_history->save();


            $url = route('hotel/other_income/view_list', ['id'=>$other_income->id]);
            $type = 'unpaid';

//            return response()->json(['success'=>'success']);
        }
        else if($remark == 'Paid'){
            $other_income->paid_status = 'Paid';
            $other_income->total_amount = $total_amount;
            $other_income->paid_amount = $total_amount;
            $other_income->save();

            $other_income_payment = new Other_income_payment();
            $other_income_payment->date = date('Y-m-d');
            $other_income_payment->other_income_id	 = $other_income->id;
            $other_income_payment->total_amount = $total_amount;
            $other_income_payment->paid_amount = $total_amount;
            $other_income_payment->balance = 0;
            $other_income_payment->status = 'Paid';
            $other_income_payment->save();

            $payment_meth = $other_income->payment_method;
            \Illuminate\Support\Facades\Log::info('cid'.$payment_meth);

            //cash book save

          //  $Other_income_payment_cash_book = Other_income::all();



            $cardCashBookId = null;



                if ($payment_meth === 'Card') {

                    $ncash_book=  Other_income_payment_cash_book::where('type','card')->first();
                    \Illuminate\Support\Facades\Log::info('w2'. $ncash_book);
                    $cardCashBookId = $ncash_book->cash_book_id;
                    \Illuminate\Support\Facades\Log::info('id'.$cardCashBookId);

                } elseif ($payment_meth === 'Cash') {

                    $ncash_book=  Other_income_payment_cash_book::where('type','cash')->first();
                    $cardCashBookId = $ncash_book->cash_book_id;

                } elseif ($payment_meth === 'Cheque') {
                    $ncash_book=  Other_income_payment_cash_book::where('type','cheque')->first();
                    $cardCashBookId = $ncash_book->cash_book_id;
                    \Illuminate\Support\Facades\Log::info('cid'.$cardCashBookId);
                }


            $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit Payment from Other Income' . ' ' . '(' . $other_income->id . ') ' . 'Bill';



            $cash_book_log = new Cash_book_log_activity();
            $cash_book_log->cashbook_id = $cardCashBookId;
            $cash_book_log->hotel_id = auth()->user()->hotel_id;
            $cash_book_log->debit =  $total_amount;
            $cash_book_log->date = $other_income_payment->date;
            $cash_book_log->user_id = auth()->user()->id;
            $cash_book_log->other_income_id = $other_income->id;
            //  $cash_book_log->payment_id = $other_income_payment->id;
            $cash_book_log->remark = $remark;
            $cash_book_log->status = 'Active';
            $cash_book_log->save();

            \Illuminate\Support\Facades\Log::info('w' . $cash_book_log);

            \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Debit');

            $cashbook_id = $cash_book_log->id;


            $other_income_payment_history= new Other_income_payments_history();
            $other_income_payment_history->date= $date;
            $other_income_payment_history->cashbook_id= $cashbook_id;

            $other_income_payment_history->other_income_id= $other_income->id;
            $other_income_payment_history->total_amount = $total_amount;
            $other_income_payment_history->paid_amount = $total_amount;
            $other_income_payment_history->balance= 0;

            $other_income_payment_history->payment_method= $payment_method;
            $other_income_payment_history->save();






            $url = route('hotel/other_income/view_list', ['id'=>$other_income->id]);
            $type = 'paid';
//            return response()->json(['success'=>'success']);
        }
        else if($remark == 'Half Payment'){
            $other_income->paid_status = 'Half Payment';
            $other_income->total_amount = $total_amount;



            $other_income->save();




            $url = route('hotel/other_income/save_income_payment', ['id'=>$other_income->id]);
            $type = 'half_payment';

        }
        return response()->json(['success'=>'success' , 'url' => $url , 'type'=> $type]);


    }

    public function save_income_payment(Request $request)
    {
        $other_income_id = $request->input('id');
        $other_income = Other_income::find($other_income_id);


        return view('hotel.other_income_payment', ['other_income' => $other_income]);
    }

    public function view_list_other_income(Request $request)
    {
        $other_income = Other_income::where('status', null)->get();
        $other_income_category_list = Other_income_category_list::where('status', null)->get();

        return view('hotel.view_other_income', ['other_incomes'=>$other_income,'other_income_category_lists'=>$other_income_category_list]);
    }

    public function get_edit_list_view_other_income_details(Request $request)
    {
        $other_income_id =  $request->input('otherIncomeid');

        $other_income = Other_income::where('status', null)->where('id', $other_income_id)->first();
        $other_income_item_detail = Other_income_item_detail::with('other_income_category')->where('other_income_id', $other_income_id)->get();
        $other_income_category_list = Other_income_category_list::where('status', null)->get();

        return response()->json(['other_incomes'=>$other_income, 'other_income_item_details'=>$other_income_item_detail,'other_income_category_lists'=>$other_income_category_list]);
    }

    public function get_other_income_payment_details(Request $request)
    {
        $other_income_id =  $request->input('otherIncomeid');
       return $other_income_item_payment_detail = Other_income_payments_history::where('other_income_id', $other_income_id)
           ->orderBy('id', 'ASC')
           ->get();

    }









    public function other_income_save_payment(Request $request)
    {

        $other_income_id = $request->input('other_income_id');
        $total_amount = $request->input('total_amount');

        if($request->input('paid_amount') == null){
            $paid_amount = 0;
        }
        else{
            $paid_amount = $request->input('paid_amount');
        }

        if($request->input('balance') == null){
            $balance = $total_amount;
        }
        else{
            $balance = $request->input('balance');
        }

        $other_income = Other_income::find($other_income_id);
        $other_income->paid_amount = $paid_amount;
        $other_income->save();



        $other_income_payment = new Other_income_payment();
        $other_income_payment->date = date('Y-m-d');
        $other_income_payment->other_income_id	 = $other_income->id;
        $other_income_payment->total_amount = $total_amount;
        $other_income_payment->paid_amount = $paid_amount;
        $other_income_payment->balance = $balance;
        $other_income_payment->status = 'Half Payment';
        $other_income_payment->save();
        \Illuminate\Support\Facades\Log::info('w' . $other_income_payment);






        $payment_meth = $other_income->payment_method;


        $cardCashBookId = null;



            if ($payment_meth === 'Card') {

              $ncash_book=  Other_income_payment_cash_book::where('type','card')->first();
                $cardCashBookId = $ncash_book->cash_book_id;

            } elseif ($payment_meth === 'Cash') {

                $ncash_book=  Other_income_payment_cash_book::where('type','cash')->first();
                $cardCashBookId = $ncash_book->cash_book_id;

            } elseif ($payment_meth === 'Cheque') {
                $ncash_book=  Other_income_payment_cash_book::where('type','cheque')->first();
                $cardCashBookId = $ncash_book->cash_book_id;

            }


        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debit Payment from Other Income' . ' ' . '(' . $other_income->id . ') ' . 'Bill';



        $cash_book_log = new Cash_book_log_activity();
        $cash_book_log->cashbook_id = $cardCashBookId;
        $cash_book_log->hotel_id = auth()->user()->hotel_id;
        $cash_book_log->debit =  $paid_amount;
        $cash_book_log->date = $other_income_payment->date;
        $cash_book_log->user_id = auth()->user()->id;
        $cash_book_log->other_income_id = $other_income->id;

        $cash_book_log->remark = $remark;
        $cash_book_log->status = 'Active';
         $cash_book_log->save();
         \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Debit');
        \Illuminate\Support\Facades\Log::info('M' .  $cash_book_log);

        $cashbook_id = $cash_book_log->id;

        $other_income_payments_history = Other_income_payments_history::where('other_income_id', $other_income_id)->first();

// Check if the record exists, if not, create a new one
        if (!$other_income_payments_history) {
            $other_income_payments_history = new Other_income_payments_history();
        }

        $other_income_payments_history->date = date('Y-m-d');
        $other_income_payments_history->other_income_id = $other_income_id;
        $other_income_payments_history->total_amount = $total_amount;
        $other_income_payments_history->paid_amount = $paid_amount;
        $other_income_payments_history->cashbook_id = $cashbook_id;
        $other_income_payments_history->payment_method = $other_income->payment_method;
        $other_income_payments_history->balance = $balance;


        $other_income_payments_history->save();



        return redirect()->route('hotel/other_income/view_list');
        return redirect()->back()->with('success');
    }
    public function other_income_delete(Request $request)
    {
        $otherIncomeid = $request->input('otherIncomeid');

        $other_income = Other_income::find($otherIncomeid);
        $other_income->status = 'Block';
        $other_income->save();
        return response()->json(['success' => 'success']);
    }

    public function update_other_income(Request $request){

        $other_income_id = $request->input('other_income_id');
        $f_name = $request->input('f_name');
        $date = $request->input('date');
        $country = $request->input('country');
        $telephone_number = $request->input('telephone_number');
        $whatsapp_number = $request->input('whatsapp_number');
        $passport_number = $request->input('passport_number');
        $email = $request->input('email');
        $remark = $request->input('remark');

        $payment_method = $request->input('payment_method');
        $note = $request->input('note');

        $other_income = Other_income::find($other_income_id);

        $firs_paid_status = $other_income->paid_status;

        $other_income->date =$date;
        $other_income->first_name = $f_name;
        $other_income->country = $country;
        $other_income->telephone_number = $telephone_number;
        $other_income->whatsapp_number = $whatsapp_number;
        $other_income->passport_number = $passport_number;
        $other_income->email_address = $email;
        $other_income->payment_method = $payment_method;
        $other_income->note = $note;
        $other_income->hotel_id = auth()->user()->hotel_id;
        $other_income->save();



//
//
//
//
//
//        if ($remark == 'Unpaid') {
//            $other_income->paid_status = 'Pending Amount';
//            $other_income->total_amount = $total_amount;
//            $other_income->paid_amount = 0;
//            $other_income->save();
//
//            $other_income_payment = Other_income_payment::where('other_income_id',$other_income->id)->first();
//            $other_income_payment->date = date('Y-m-d');
//            $other_income_payment->other_income_id	 = $other_income->id;
//            $other_income_payment->total_amount = $total_amount;
//            $other_income_payment->paid_amount = 0;
//            $other_income_payment->balance = $total_amount;
//            $other_income_payment->status = 'Pending Amount';
//            $other_income_payment->save();
//
//            $url = route('hotel/other_income/view_list', ['id'=>$other_income->id]);
//            $type = 'unpaid';
//
////            return response()->json(['success'=>'success']);
//        }
//        else if($remark == 'Paid'){
//            $other_income->paid_status = 'Paid';
//            $other_income->total_amount = $total_amount;
//            $other_income->paid_amount = $total_amount;
//            $other_income->save();
//
//            $other_income_payment = Other_income_payment::where('other_income_id',$other_income->id)->first();
//            $other_income_payment->date = date('Y-m-d');
//            $other_income_payment->other_income_id	 = $other_income->id;
//            $other_income_payment->total_amount = $total_amount;
//            $other_income_payment->paid_amount = $total_amount;
//            $other_income_payment->balance = 0;
//            $other_income_payment->status = 'Paid';
//            $other_income_payment->save();
//
//            $url = route('hotel/other_income/view_list', ['id'=>$other_income->id]);
//            $type = 'paid';
////            return response()->json(['success'=>'success']);
//        }
//        else if($remark == 'Half Payment'){
//            $other_income->paid_status = 'Half Payment';
//            $other_income->total_amount = $total_amount;
//            $other_income->save();
//
//            $other_income_payment = Other_income_payment::where('other_income_id',$other_income->id)->delete();
//
//            $url = route('hotel/other_income/save_income_payment', ['id'=>$other_income->id]);
//            $type = 'half_payment';
//
//        }
//
//        if ($remark == 'Paid') {
//
//        }
//        else if($remark == 'Pending Amount'){
//
//        }
//        else if  ($remark == 'Half Payment'){
//
//        }


        $other_income = Other_income::where('id', $other_income_id)->first();;
        return response()->json(['success' => 'Updated successfully!' , 'other_income' => $other_income]);


    }

    public function get_all_other_income_history(Request $request)
    {

        $other_income_id = $request->input('other_income_id');

        $other_income = Other_income::where('id', $other_income_id)->first();
        $other_income_item_detail= Other_income_item_detail::where('other_income_id', $other_income_id)->orderBy('id', 'desc')->get();
        $other_income_payment = Other_income_payment::where('other_income_id', $other_income_id)->orderBy('id', 'desc')->get();

//        $merged_records = $record_details_grn->concat($record_details_expences);
//        $sorted_records = $merged_records->sortBy('created_at');
//        $sorted_records = $sorted_records->values()->all();
////        $record_details_expences = Goods_received_note::where('supplier', $supplier_id)->orderBy('id', 'desc')->get();
//        $record_details_supplier = Supplier::where('id', $supplier_id)->first();

        return response()->json(['other_income' => $other_income,'other_income_item_detail' => $other_income_item_detail,'other_income_payment' => $other_income_payment]);
    }
    public function get_second_payment_details_other(Request $request)
    {
        $other_incomes_id = $request->input('other_incomes_id');
        $Other_income = Other_income::find($other_incomes_id);
        return response()->json(['Other_income' => $Other_income]);
    }
     public function second_payment_details_other_save(Request $request){

             $other_incomes_id = $request->input('other_incomes_id');
             $paid_amount = $request->input('paid_amount');
             $total_amount = $request->input('total_amount');
             $balance = $request->input('balance');
             $date = $request->input('sp_date');
             $cashbook_id = $request->input('cash_book_id');
             $payment_method = $request -> input('payment_method');



             $other_income = Other_income ::find($other_incomes_id);
             $other_income->paid_amount = $other_income->paid_amount+ $paid_amount;


             if ($other_income->total_amount == $other_income->paid_amount) {
                 $other_income->paid_status = 'Paid';


             } else {
                 $other_income->paid_status = 'Pending Amount';


             }

         $other_income->save();

       Other_income_payment::where('other_income_id', $other_incomes_id)
             ->update([
                 'paid_amount' =>  $other_income->paid_amount,
                 'balance' => $total_amount - ($other_income->paid_amount),
                 'status' => ($other_income->total_amount == $other_income->paid_amount) ? 'Paid' : 'Pending Amount',
             ]);



         $payment_meth = $other_income->payment_method;


         $cardCashBookId = null;



             if ( $payment_meth=== 'Card') {

                 $ncash_book=  Other_income_payment_cash_book::where('type','card')->first();
                 $cardCashBookId = $ncash_book->cash_book_id;

             } elseif ($payment_meth === 'Cash') {

                 $ncash_book=  Other_income_payment_cash_book::where('type','cash')->first();
                 $cardCashBookId = $ncash_book->cash_book_id;

             } elseif ($payment_meth === 'Cheque') {
                 $ncash_book=  Other_income_payment_cash_book::where('type','cheque')->first();
                 $cardCashBookId = $ncash_book->cash_book_id;
             }


         $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Debited Payment from Other Income' . ' ' . '(' . $other_income->id . ') ' . 'Bill';



         $cash_book_log = new Cash_book_log_activity();
         $cash_book_log->cashbook_id = $cardCashBookId;
         $cash_book_log->hotel_id = auth()->user()->hotel_id;
         $cash_book_log->debit =  $paid_amount;
         $cash_book_log->date = date('Y-m-d');
         $cash_book_log->user_id = auth()->user()->id;
         $cash_book_log->other_income_id = $other_income->id;

         $cash_book_log->remark = $remark;
         $cash_book_log->status = 'Active';
         $cash_book_log->save();


         \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Debit');
         $cashbook_id = $cash_book_log->id;

         \Illuminate\Support\Facades\Log::info('w*' . $cash_book_log);


         $other_income_payments_history =  new Other_income_payments_history();
         $other_income_payments_history->date = date('Y-m-d');
         $other_income_payments_history->other_income_id = $other_incomes_id;
         $other_income_payments_history-> total_amount = $total_amount;
         $other_income_payments_history-> cashbook_id = $cashbook_id;

         $other_income_payments_history->paid_amount =  $paid_amount;
         $other_income_payments_history->payment_method = $payment_method;

         $other_income_payments_history->balance = $total_amount - ($other_income->paid_amount);

         $other_income_payments_history->save();

















             return redirect()->back()->with('success', 'Successfully Add Payment!');
         }



    public function view_other_income_details($id)
    {
        $hotelId = auth()->user()->hotel_id;

        // Get the specific hotel estimate with related item details, categories, and payments
        $other_income = Other_income::with([
            'otherIncomeItemDetails' => function ($query) {
                // Add a where clause to filter records where status is null
                $query->where('status', null);
            },
            'otherIncomePayments'
        ])->where('hotel_id', $hotelId)->where('status', null)->find($id);

        // Extract item details from the retrieved estimate
        $other_income_item_detail = $other_income->otherIncomeItemDetails ?? [];
        \Log::info('other_income_item_detail: ' . $other_income_item_detail);
        // Extract payment details from the retrieved estimate
        $other_income_payments = $other_income->otherIncomePayments ?? [];



          $total = 0;
        $paidAmount = 0;


        foreach ($other_income_item_detail as $item_detail) {
            $total += ($item_detail->price * $item_detail->quantity);
            \Log::info('total: ' . $total);

        }

        $paidAmount += $other_income->paid_amount;
        \Log::info('paidAmount: ' . $paidAmount);
        $balance = $total - $paidAmount;
        \Log::info('Balance: ' . $balance);

        return view('hotel.other_income_detail_view', [
            'other_income' => $other_income,
            'item_detail' => $other_income_item_detail,
            'other_income_payments' => $other_income_payments,
            'total' => $total,
            'paidAmount' => $paidAmount,
            'balance' => $balance,
        ]);
    }

    public function hotel_other_income_print(Request $request)
    {
        $hotelId = auth()->user()->hotel_id;
        $other_incomes_id = $request->input('id');

        $other_income = Other_income::with([
            'otherIncomeItemDetails' => function ($query) {
                // Add a where clause to filter records where status is null
                $query->where('status', null);
            },
            'otherIncomePayments'
        ])->where('hotel_id', $hotelId)->find($other_incomes_id);



        $other_income_item_detail = $other_income->otherIncomeItemDetails ?? [];

        // Extract payment details from the retrieved estimate
        $other_income_payments = $other_income->otherIncomePayments ?? [];

        $total = 0;
        $paidAmount = 0;


        foreach ($other_income_item_detail as $item_detail) {
            $total += ($item_detail->price * $item_detail->quantity);
            \Log::info('total: ' . $total);

        }

        $paidAmount += $other_income->paid_amount;
        \Log::info('paidAmount: ' . $paidAmount);
        $balance = $total - $paidAmount;
        \Log::info('Balance: ' . $balance);


//        return view('hotel.other_income_detail_pdf_print',['other_income' => $other_income,
//            'item_detail' => $other_income_item_detail,
//            'other_income_payments' => $other_income_payments,
//            'totalAmount' => $totalAmount,
//            'paidAmount' => $paidAmount,
//            'balance' => $balance, ]);
        $pdf = Facade\Pdf::loadView('hotel.other_income_detail_pdf_print', [
            'other_income' => $other_income,
            'item_detail' => $other_income_item_detail,
            'other_income_payments' => $other_income_payments,
            'totalAmount' => $total,
            'paidAmount' => $paidAmount,
            'balance' => $balance,
        ]);

        return $pdf->download('invoice.pdf');
    }






    public function other_income_invoice_send(Request $request)
    {
        $other_incomes_id = $request->input('other_incomes_id');
        $invoice_send_email = $request->input('email');
        $hotel = Hotel::find(auth()->user()->hotel_id);

        // Fetch Other_income record
        $other_income = Other_income::with([
            'otherIncomeItemDetails' => function ($query) {
                // Add a where clause to filter records where status is null
                $query->where('status', null);
            },
            'otherIncomePayments'
        ])->where('hotel_id', $hotel->id)->find($other_incomes_id);

        // Check if $other_income is not null
        if (!$other_income) {
            \Log::error('Other Income not found', ['id' => $other_incomes_id]);
            return redirect()->back()->with('error', 'Error: Other Income not found');
        }

        // Extract item details from the retrieved estimate
        $other_income_item_detail = $other_income->otherIncomeItemDetails ?? [];

        // Extract payment details from the retrieved estimate
        $other_income_payments = $other_income->otherIncomePayments ?? collect();

        $total = 0;
        $paidAmount = 0;


        foreach ($other_income_item_detail as $item_detail) {
            $total += ($item_detail->price * $item_detail->quantity);
            \Log::info('total: ' . $total);

        }

        $paidAmount += $other_income->paid_amount;
        \Log::info('paidAmount: ' . $paidAmount);
        $balance = $total - $paidAmount;
        \Log::info('Balance: ' . $balance);

        $pdf = Facade\Pdf::loadView('hotel.other_income_detail_pdf_print', [
            'other_income' => $other_income,
            'item_detail' => $other_income_item_detail,
            'other_income_payments' => $other_income_payments,
            'totalAmount' => $total,
            'paidAmount' => $paidAmount,
            'balance' => $balance
        ]);

        $pdf_file = base64_encode($pdf->output());

        $pdf_data_otherincomeinvoice = new \stdClass;
        $pdf_data_otherincomeinvoice->pdf = $pdf_file;
        $pdf_data_otherincomeinvoice->name = $other_income->first_name;

        Mail::to($invoice_send_email)
            ->cc('nilumaheema@gmail.com')
            ->send(new Estimateinvoice($pdf_data_otherincomeinvoice));

        return redirect()->back()->with('success');
    }


    public function other_income_detail_edit($id)
    {
        $hotelId = auth()->user()->hotel_id;

        // Get the specific hotel estimate with related item details, categories, and payments
        $other_income = Other_income::with([
            'otherIncomeItemDetails' => function ($query) {
                // Add a where clause to filter records where status is null
                $query->where('status', null);
            },
            'otherIncomePayments'
        ])->where('hotel_id', $hotelId)->where('status', null)->find($id);

        // Extract item details from the retrieved estimate
        $other_income_item_detail = $other_income->otherIncomeItemDetails ?? [];

        // Extract payment details from the retrieved estimate
        $other_income_payments = $other_income->otherIncomePayments ?? [];

        // Get the list of categories for the dropdown
        $other_income_category_lists = Other_income_category_list::all(); // Assuming your model is named OtherIncomeCategory

        $total = 0;
        $paidAmount = 0;


        foreach ($other_income_item_detail as $item_detail) {
            $total += ($item_detail->price * $item_detail->quantity);
            \Log::info('total: ' . $total);

        }

        $paidAmount += $other_income->paid_amount;
        \Log::info('paidAmount: ' . $paidAmount);
        $balance = $total - $paidAmount;
        \Log::info('Balance: ' . $balance);

        return view('hotel.other_income_detail_edit', [
            'other_income' => $other_income,
            'item_detail' => $other_income_item_detail,
            'other_income_payments' => $other_income_payments,
            'other_income_category_lists' => $other_income_category_lists, // Add this line
            'totalAmount' => $total,
            'paidAmount' => $paidAmount,
            'balance' => $balance,
        ]);
    }


    public function edit_other_income_save_new(Request $request){
        $hotel = Hotel::find(auth()->user()->hotel_id);
        $other_incomes_id = $request->input('income_id');

// Add logging to check the provided hotel_estimate_id
        \Log::info('Provided income_id: ' . $other_incomes_id);

// Check if provided ID is null or not present
        if ($other_incomes_id === null) {
            \Log::error('Other Income ID is null or not provided');
            return response()->json(['error' => 'Other Income ID is null or not provided'], 404);
        }

        // Fetch Other_income record
        $other_income = Other_income::with([
            'otherIncomeItemDetails' => function ($query) {
                // Add a where clause to filter records where status is null
                $query->where('status', null);
            },
            'otherIncomePayments'
        ])->where('hotel_id', $hotel->id)->where('status', null)->find($other_incomes_id);

        // Check if $other_income is not null
        if (!$other_income) {
            \Log::error('Other Income not found', ['id' => $other_incomes_id]);
            return redirect()->back()->with('error', 'Error: Other Income not found');
        }

        // Extract item details from the retrieved estimate
        $other_income_item_detail = $other_income->otherIncomeItemDetails ?? [];

        // Extract payment details from the retrieved estimate
        $other_income_payments = $other_income->otherIncomePayments ?? collect();

        // Calculate total amount, paid amount, and balance
        $totalAmount = $other_income_payments->sum('total_amount');
        $paidAmount = $other_income_payments->sum('paid_amount');
        $balance = $totalAmount - $paidAmount;

        $count = $request->input('count');
        Log::info($count);

        // Initialize total amount before the loop
        $total_amount = 0;

        for ($i = 1; $i <= $count; $i++) {
            $item_id = $request->input('item_id-' . $i);
            if ($item_id == "new") {
                // Code for new item
                Log::info("Adding new item: " . $i);


                if ($request->has('item-' . $i) && $request->has('quantity-' . $i) && $request->has('price-' . $i) && $request->has('description-' . $i)) {
                    $item = $request->input('item-' . $i);
                    $quantity = $request->input('quantity-' . $i);
                    $price = $request->input('price-' . $i);
                    $description = $request->input('description-' . $i);

                    // Calculate total amount for each item
                    $item_total_amount = $quantity * $price;

                    $total_amount += $item_total_amount;

                    if ($item != "" && $quantity != "" && $price != "" && $description != "") {
                        $other_income_item_detail = new Other_income_item_detail();
                        $other_income_item_detail->other_income_id = $other_income->id;
                        $other_income_item_detail->item_id = $item;
                        $other_income_item_detail->quantity = $quantity;
                        $other_income_item_detail->price = $price;
                        $other_income_item_detail->description = $description;
                        $other_income_item_detail->save();
                    }
                }
            }else {

                Log::info("Updating existing item: " . $i);

                // Retrieve item details from the request
                $item = $request->input('item-' . $i);
                $quantity = $request->input('quantity-' . $i);
                $price = $request->input('price-' . $i);
                $description = $request->input('description-' . $i);

                // Calculate total amount for each item
                $item_total_amount = $quantity * $price;

                $total_amount += $item_total_amount;
                Log::info("Updating existing itemggg: " . $item_id);
                if ($item != "" && $quantity != "" && $price != "" && $description != "") {

                    // Find and update existing Item_detail model
                    $itemDetail = Other_income_item_detail::find($item_id);
                    Log::notice("updated data: " . $item_id);
                    if ($itemDetail) {
                        $itemDetail->item_id = $item;
                        $itemDetail->quantity = $quantity;
                        $itemDetail->price = $price;
                        $itemDetail->description = $description;
                        $itemDetail->save();
                        \Log::info("Updating existing item: " . $itemDetail->id);
                    }

                }


            }


        }

        // Update total_amount in the other_incomes table
        $other_income->total_amount = $total_amount;
        $other_income->save();

// Retrieve updated payment details after saving item details
        $other_income_payments = $other_income->otherIncomePayments ?? collect();

// Calculate total amount, paid amount, and balance after saving item details
        $totalAmount = $other_income_payments->sum('total_amount');
        $paidAmount = $other_income_payments->sum('paid_amount');
        $balance = $totalAmount - $paidAmount;

// Return success response with updated values
        return response()->json([
            'success' => 'Estimate has been updated successfully!',
            'other_income' => $other_income,
            'item_detail' => $other_income_item_detail,
            'other_income_payments' => $other_income_payments,
            'totalAmount' => $totalAmount,
            'paidAmount' => $paidAmount,
            'balance' => $balance,
        ]);

    }




    public function delete_other_income_details(Request $request)
    {
        $item_id = $request->input('item_detail_id');

        // Log the values for debugging
        \Log::info('Item ID: ' . $item_id);

        // Retrieve the item detail and related Other_income
        $itemDetail = Other_income_item_detail::with('otherIncome')->find($item_id);

        if (!$itemDetail) {
            return response()->json(['error' => 'Item detail not found.'], 404);
        }

        // Set status to 'Block' and save
        $itemDetail->status = 'Block';
        $itemDetail->save();

//        // Retrieve hotel and income_id
//        $hotel = Hotel::find(auth()->user()->hotel_id);
        $other_incomes_id = $request->input('income_id');

        // Add logging to check the provided hotel_estimate_id
        \Log::info('Provided income_id: ' . $other_incomes_id);

        // Check if provided ID is null or not present
        if ($other_incomes_id === null) {
            \Log::error('Other Income ID is null or not provided');
            return response()->json(['error' => 'Other Income ID is null or not provided'], 404);
        }



        $other_income = Other_income::find($other_incomes_id);

        $otherincomedetails = Other_income_item_detail::where('other_income_id' , $other_incomes_id)->where('status', null)->get();
        $total = 0;

     foreach($otherincomedetails as $otherincomedetail){
         $total = $total + ($otherincomedetail->price * $otherincomedetail->quantity);
     }
        $other_income->total_amount=$total;
        $other_income->save();

        // Log the success message for debugging
        \Log::info('Item detail marked as blocked successfully');

        return response()->json(['success' => 'Item detail marked as blocked successfully','total' => $total]);
    }













    public function room_estimation_save(Request $request)
    {
        $room_estimation = new Hotel_estimate();
        $room_estimation->hotel_id = auth()->user()->hotel_id;
        $room_estimation->date = $request->input('date');
        $room_estimation->full_name = $request->input('full_name');

        $room_estimation->country = $request->input('country');

        $room_estimation->email = $request->input('email');

        $room_estimation->whatsapp_number = $request->input('whatsapp_number');
        $room_estimation->check_in_date = $request->input('check_in_date');
        $room_estimation->check_out_date = $request->input('check_out_date');
        $room_estimation->nights = $request->input('nights');
        $room_estimation->guests = $request->input('guests');
        $room_estimation->roomscount = $request->input('roomscount');
        $room_estimation->discount_price = $request->input('discount_price');
        $room_estimation->discount_description = $request->input('discount_description');
        $room_estimation->note = $request->input('note');

        $room_estimation->save();

        $count = $request->input('count');
        $total = 0; // Initialize total variable

        for ($i = 1; $i <= $count; $i++) {
            // Retrieve item details from the request
            $category = $request->input('Category-' . $i);
            $description = $request->input('Description-' . $i);
            $rate = $request->input('Rate-' . $i);
            $quantity = $request->input('Quantity-' . $i);

            if ($category !== null && $rate !== null && $quantity !== null) {
                $itemTotal = $rate * $quantity;
                $total += $itemTotal;


                // Create and populate Item_detail model directly related to Hotel_estimate
                $itemDetail = new Item_detail();
                $itemDetail->hotel_id = auth()->user()->hotel_id;
                $itemDetail->hotel_estimate_id = $room_estimation->id; // Assuming the foreign key field name
                $itemDetail->category = $category;
                $itemDetail->description = $description;
                $itemDetail->rate = $rate;
                $itemDetail->quantity = $quantity;
                $itemDetail->price = $itemTotal;

                $itemDetail->save(); // Save the item detail
            }
        }



        // Check if discount_price is provided and valid
        $discount_price = $request->input('discount_price');
        if ($discount_price !== null && is_numeric($discount_price)) {
            // Subtract discount_price from total
            $total -= $discount_price;

            // Update discount information in Hotel_estimate model
            $room_estimation->discount_price = $discount_price;
            $room_estimation->discount_description = $request->input('discount_description');
        } else {
            // If discount_price is not provided or not valid, set it to 0
            $room_estimation->discount_price = 0;
            $room_estimation->discount_description = null;
        }

        // Update the total cost in Hotel_estimate model
        $room_estimation->total_cost = $total;

// Calculate and update the cost without discount
        $room_estimation->cost = $room_estimation->total_cost + $room_estimation->discount_price;

        // Save the updated model
        $room_estimation->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Estimate has been made!');
    }


    public function estimate_get(Request $request)
    {
        $estimate_id = $request->input('estimate_id');
        $room_estimation_details = Hotel_estimate::find($estimate_id);
        return response()->json(['estimate_details' => $room_estimation_details]);
    }



//    public function view_detail_room_estimate($id)
//    {
//        $room_estimation = Hotel_estimate::where('hotel_id', auth()->user()->hotel_id)
//            ->find($id);
//        $roomEstimateDetail = Room_estimate_detail::find($id);
//
//        return view('hotel.room_estimation_detail', ['room_estimation' => $room_estimation , 'roomEstimateDetail' => $roomEstimateDetail ]);
//    }







    public function add_estimate(){
        $items =Item::where('hotel_id',auth()->user()->hotel_id)->get();
        return view('hotel.add_estimate',['items'=>$items]);
    }

    public function view_estimate_details(){
        $estimate  = Item_detail::where('hotel_id',auth()->user()->hotel_id)->get();

        $room_estimation = Hotel_estimate::where('hotel_id',auth()->user()->hotel_id)->where('status', null)->orderBy('id', 'DESC')->get();

        $hotel_id = auth()->user()->hotel_id;


        return view('hotel.room_estimation_view',['estimate_detail'=>$estimate , 'room_estimation' => $room_estimation, 'hotel_id' => $hotel_id]);
    }

    public function get_estimate_details(Request $request){
        $estimate  = Item_detail::where('hotel_id', auth()->user()->hotel_id)->get();

        $estimate_id = $request->input('estimate_id');
        $room_estimation_details = Hotel_estimate::with('item_detail')->find($estimate_id);
        return response()->json(['estimate' => $room_estimation_details, 'estimate_detail' => $estimate]);
    }

    public function edit_estimate_save(Request $request){
        $date = $request->input('date');
        $full_name = $request->input('full_name');
        $country = $request->input('country');
        $email = $request->input('email');
        $whatsapp_number = $request->input('whatsapp_number');
        $check_in_date = $request->input('check_in_date');
        $check_out_date = $request->input('check_out_date');
        $guests = $request->input('guests');
        $nights = $request->input('nights');
        $estimate_id = $request->input('estimate_id');
        $roomscount = $request->input('roomscount');



        $room_estimation = Hotel_estimate::find($estimate_id);


        $room_estimation->date = $date;
        $room_estimation->full_name = $full_name;
        $room_estimation->country = $country;
        $room_estimation->email = $email;
        $room_estimation->whatsapp_number = $whatsapp_number;

        $room_estimation->check_in_date = $check_in_date;
        $room_estimation->check_out_date = $check_out_date;
        $room_estimation->guests = $guests;
        $room_estimation->nights = $nights;
        $room_estimation->roomscount = $roomscount;





        $room_estimation->save();
        $room_estimation_details = Hotel_estimate::with('item_detail')->find($estimate_id);
        return response()->json(['success' => 'Estimate has been updated successfully!' , 'room_estimation' => $room_estimation_details]);


    }

    public function view_detail_room_estimate($id)
    {
        $hotelId = auth()->user()->hotel_id;

        // Get the specific hotel estimate with related item details
        $room_estimation = Hotel_estimate::with(['item_detail' => function ($query) {
            $query->where('status', null);
        }])
            ->where('hotel_id', $hotelId)
            ->find($id);

        // Extract item details from the retrieved estimate
        $estimate_detail = $room_estimation->item_detail ?? [];

        return view('hotel.room_estimation_detail', [
            'room_estimation' => $room_estimation,
            'estimate_detail' => $estimate_detail,
        ]);
    }



    public function get_estimate_details_new(Request $request){
        $estimate  = Item_detail::where('hotel_id', auth()->user()->hotel_id)->get();

        $estimate_id = $request->input('estimate_id');
        $room_estimation_details = Hotel_estimate::with('item_detail')->find($estimate_id);
        return response()->json(['estimate' => $room_estimation_details, 'estimate_detail' => $estimate]);
    }

    public function edit_estimate_save_new(Request $request)
    {
        $estimate_id = $request->input('estimate_id');
        $total = 0; // Initialize total variable

        // Add logging to check the provided hotel_estimate_id
        \Log::info('Provided hotel_estimate_id: ' . $estimate_id);

        $room_estimation = Hotel_estimate::find($estimate_id);

        if (!$room_estimation) {
            // Add logging to check if the Hotel_estimate record is found
            \Log::info('Hotel_estimate record not found for id: ' . $estimate_id);

            return response()->json(['error' => 'Estimate not found'], 404);
        }

        $count = $request->input('count');
        Log::info($count);

        for ($i = 1; $i <= $count; $i++) {
            $item_id = $request->input('item_id-' . $i);

            if ($item_id == "new") {
                // Code for new item
                Log::info("Adding new item: " . $i);

                // Retrieve item details from the request
                $category = $request->input('Category-' . $i);
                $description = $request->input('Description-' . $i);
                $rate = $request->input('Rate-' . $i);
                $quantity = $request->input('Quantity-' . $i);

                if ($category !== null && $rate !== null && $quantity !== null) {
                    $itemTotal = $rate * $quantity;
                    $total += $itemTotal;

                    // Create and populate Item_detail model directly related to Hotel_estimate
                    $itemDetail = new Item_detail();
                    $itemDetail->hotel_id = auth()->user()->hotel_id;
                    $itemDetail->hotel_estimate_id = $room_estimation->id;
                    $itemDetail->category = $category;
                    $itemDetail->description = $description;
                    $itemDetail->rate = $rate;
                    $itemDetail->quantity = $quantity;
                    $itemDetail->price = $itemTotal;

                    // Explicitly set the item_id for new items
//                    $itemDetail->item_id = "new";

                    $itemDetail->save(); // Save the item detail
                    Log::info("Adding new item: " . $itemDetail);
                }
            } else {
                // Code for existing item
                Log::info("Updating existing item: " . $i);

                // Retrieve item details from the request
                $category = $request->input('Category-' . $i);
                $description = $request->input('Description-' . $i);
                $rate = $request->input('Rate-' . $i);
                $quantity = $request->input('Quantity-' . $i);

                if ($category !== null && $rate !== null && $quantity !== null) {
                    $itemTotal = $rate * $quantity;
                    $total += $itemTotal;

                    // Find and update existing Item_detail model
                    $itemDetail = Item_detail::find($item_id);
                    Log::notice($itemDetail);
                    if ($itemDetail) {
                        $itemDetail->category = $category;
                        $itemDetail->description = $description;
                        $itemDetail->rate = $rate;
                        $itemDetail->quantity = $quantity;
                        $itemDetail->price = $itemTotal;

                        $itemDetail->save(); // Save the updated item detail
                        Log::info("Updating existing item: " . $itemDetail);
                    }
                }
            }
        }

        // Update discount_price, discount_description, and note in Hotel_estimate model
        $room_estimation->discount_price = $request->input('discount_price');
        $room_estimation->discount_description = $request->input('discount_description');
        $room_estimation->note = $request->input('note');

        // Check if discount_price is provided and valid
        $discount_price = $room_estimation->discount_price;

        if ($discount_price !== null && is_numeric($discount_price)) {
            // Subtract discount_price from total
            $total -= $discount_price;
        } else {
            // If discount_price is not provided or not valid, set it to 0
            $room_estimation->discount_price = 0;
            $room_estimation->discount_description = null;
        }

        // Update the total cost in Hotel_estimate model
        $room_estimation->total_cost = $total;

        // Calculate and update the cost without discount
        $room_estimation->cost = $room_estimation->total_cost + $room_estimation->discount_price;

        // Save the updated model
        $room_estimation->save();

        // Retrieve the updated item details for the current estimate
        $updatedItemDetails = Item_detail::where('hotel_estimate_id', $estimate_id)->get();

        // Return success response with item details
        return response()->json([
            'success' => 'Estimate has been updated successfully!',
            'room_estimation' => $room_estimation,
            'item_details' => $updatedItemDetails,
        ]);
    }

    public function estimate_delete(Request $request)
    {
        $date = date('Y-m-d');
        $estimate_id = $request->input('estimate_id');

        $room_estimation = Hotel_estimate::find($estimate_id);

        // Check if the estimate record exists
        if (!$room_estimation) {
            return response()->json(['error' => 'Estimate not found'], 404);
        }

        // Update the status in the item_details table
        $room_estimation->itemDetails()->update(['status' => 'Block']);

        // Update the status in the Hotel_estimate table
        $room_estimation->status = 'Block';
        $room_estimation->save();

        return response()->json(['success' => 'success']);
    }


    public function view_detail_room_estimate_pdf($id)
    {
        $hotelId = auth()->user()->hotel_id;

        // Get the specific hotel estimate with related item details
//        $room_estimation = Hotel_estimate::with('item_detail')
//            ->where('hotel_id', $hotelId)
//            ->find($id);
        $room_estimation = Hotel_estimate::with(['item_detail' => function ($query) {
            $query->where('status', null);
        }])
            ->where('hotel_id', $hotelId)
            ->find($id);

        // Extract item details from the retrieved estimate
        $estimate_detail = $room_estimation->item_detail ?? [];

        return view('hotel.room_estimation_detail_pdf', [
            'room_estimation' => $room_estimation,
            'estimate_detail' => $estimate_detail,
        ]);
    }

    public function hotel_estimate_print(Request $request)
    {
        $estimate_id = $request->input('id');

        $room_estimation = Hotel_estimate::with(['item_detail' => function ($query) {
            $query->where('status', null);
        }])->find($estimate_id);

        Log::info($room_estimation);

        $estimate_detail = Item_detail::where('hotel_estimate_id', $estimate_id)
            ->where('status', null) // Move the status condition here
            ->get();

        $hotel = Hotel::find(auth()->user()->hotel_id);

        Log::info($estimate_detail);
//        return view('hotel.room_estimation_detail_pdf_print',['room_estimation' => $room_estimation,
//            'estimate_detail' => $estimate_detail , 'hotel' => $hotel]);
        $pdf = Facade\Pdf::loadView('hotel.room_estimation_detail_pdf_print', [
            'room_estimation' => $room_estimation,
            'estimate_detail' => $estimate_detail,
            'hotel' => $hotel
        ]);

        return $pdf->download('estimate_invoice.pdf');
    }


    public function delete_estimate_details(Request $request)
    {
        $item_id = $request->input('item_detail_id');

        $itemDetail = Item_detail::where('id', $item_id)->first();

        if (!$itemDetail) {
            return response()->json(['error' => 'Item detail not found.'], 404);
        }

        // Set status to 'Block' and save
        $itemDetail->status = 'Block';
        $itemDetail->save();

        return response()->json(['success' => 'Item detail marked as blocked successfully']);
    }

    public function room_estimate_invoice_send(Request $request)
    {
        $estimate_id = $request->input('estimate_id');
        $invoice_send_email = $request->input('email');
        $hotel = Hotel::find(auth()->user()->hotel_id);

        $room_estimation = Hotel_estimate::with(['item_detail' => function ($query) {
            $query->where('status', null);
        }])
            ->where('hotel_id', $hotel->id)
            ->find($estimate_id);



        if (!$room_estimation) {
            // Log an error and handle it accordingly
            \Log::error('Room Estimation not found');
            // You might want to return an error response or handle it in another way
            return redirect()->back()->with('error', 'Error: Room Estimation not found');
        }


        $estimate_detail = Item_detail::where('hotel_estimate_id', $estimate_id)
            ->where('status', null) // Move the status condition here
            ->get();
        $pdf = Facade\Pdf::loadView('hotel.room_estimation_detail_pdf_print', [
            'room_estimation' => $room_estimation,
            'estimate_detail' => $estimate_detail,
            'hotel' => $hotel
        ]);
//return $pdf;
        $pdf_file = base64_encode($pdf->output());

        $pdf_data_estimate = new \stdClass;
        $pdf_data_estimate->pdf = $pdf_file;
        $pdf_data_estimate->name = $room_estimation->full_name;

        Mail::to($invoice_send_email)
            ->cc('indikaribelz@gmail.com')
            ->send(new Estimateinvoice($pdf_data_estimate));

        return redirect()->back()->with('success');
    }


    public function other_income_edit_payment_amount_save(Request $request){
        $income_id = $request->input('modal-edit-paid-id');
        $income_paid = $request->input('modal-edit-paid-amounts');
        $otherIncomeId = $request->input('modal-other-income-id');
        $cash_bookId = $request->input('modal-edit-other-cashbook-id');

        \Illuminate\Support\Facades\Log::info('w1' .  $otherIncomeId );


        $other_income_payment_history = Other_income_payments_history::where('id', $income_id)->first();

        if ($other_income_payment_history) {
            $other_income_payment_history->paid_amount = $income_paid;
            $other_income_payment_history->balance = $other_income_payment_history->total_amount - $income_paid;
            $other_income_payment_history->save();
        } else {

        }
        $totalAmount = Other_income_payments_history::where('other_income_id', $otherIncomeId)
            ->sum('paid_amount');
        \Illuminate\Support\Facades\Log::info('w2' . $totalAmount);



        $Other_income = Other_income::where('id', $otherIncomeId )->first();
        $Other_income -> paid_amount = $totalAmount;
        if ($Other_income->total_amount == $totalAmount) {
            $Other_income->paid_status = 'Paid';
            $Other_income->save();
            \Illuminate\Support\Facades\Log::info('w3' . $Other_income);
        } else {
            $Other_income->paid_status = 'Half payment';

            $Other_income->save();
            \Illuminate\Support\Facades\Log::info('w4' . $Other_income);
        }




        $cash_book_id = $other_income_payment_history->cashbook_id;
        $Other_income_id = $other_income_payment_history->other_income_id;






//        $Other_income_payment_cash_book = Other_income::all();


//        $cardCashBookId = null;


//        foreach ($Other_income_payment_cash_book as $cashBook) {
//            if ($cashBook->payment_method === 'card') {
//
//                $ncash_book=  Other_income_payment_cash_book::where('type','card')->first();
//                $cardCashBookId = $ncash_book->cash_book_id;
//
//            } elseif ($cashBook->payment_method === 'cash') {
//
//                $ncash_book=  Other_income_payment_cash_book::where('type','cash')->first();
//                $cardCashBookId = $ncash_book->cash_book_id;
//
//            } elseif ($cashBook->payment_method === 'cheque') {
//                $ncash_book=  Other_income_payment_cash_book::where('type','cash')->first();
//                $cardCashBookId = $ncash_book->cash_book_id;
//            }
//        }

        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Edit Debited Amount ( Payment from Other Income' . ' ' . '(' . $Other_income_id . ') ' . 'Bill';




        $cash_book_log = Cash_book_log_activity::where('id', $cash_book_id)->first();
//        $cash_book_log->cashbook_id = $cardCashBookId;
        $cash_book_log->hotel_id = auth()->user()->hotel_id;
        $cash_book_log->debit =  $income_paid;
        $cash_book_log->date = date('Y-m-d');
        $cash_book_log->user_id = auth()->user()->id;
        $cash_book_log->other_income_id = $Other_income_id;
        //  $cash_book_log->payment_id = $other_income_payment->id;
        $cash_book_log->remark = $remark;
        $cash_book_log->status = 'Active';
        $cash_book_log->save();


        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Debit');





//        $Other_income_payment_cash_book = Other_income_payment_cash_book::all();
//
//
//        $cardCashBookId = null;
//
//
//        foreach ($Other_income_payment_cash_book as $cashBook) {
//            if ($cashBook->type === 'card') {
//
//                $ncash_book=  Other_income_payment_cash_book::where('type','card')->first();
//                $cardCashBookId = $ncash_book->cash_book_id;
//
//            } elseif ($cashBook->type === 'cash') {
//
//                $ncash_book=  Other_income_payment_cash_book::where('type','cash')->first();
//                $cardCashBookId = $ncash_book->cash_book_id;
//
//            } elseif ($cashBook->type === 'cheque') {
//                $ncash_book=  Other_income_payment_cash_book::where('type','cash')->first();
//                $cardCashBookId = $ncash_book->cash_book_id;
//            }
//        }
//
//        $remark = auth()->user()->name . ' ' . auth()->user()->lname . ' ' . '(' . auth()->user()->role . ')' . ' ' . 'Pay Balance By' . ' ' . '(' . $otherIncomeId . ') ' . 'Bill';
//
//        \Illuminate\Support\Facades\Log::info('w2' . $otherIncomeId);
//
//        $cash_book_log = Cash_book_log_activity::where('other_income_id', $otherIncomeId);
//        $cash_book_log->cashbook_id = $cardCashBookId;
//        $cash_book_log->hotel_id = auth()->user()->hotel_id;
//        $cash_book_log->debit =  $totalAmount;
//
//        $cash_book_log->user_id = auth()->user()->id;
//
//        $cash_book_log->remark = $remark;
//        $cash_book_log->status = 'Active';
//        $cash_book_log->save();
//
//
//
//        \Cashbook_monthly_record_sync::sync_cash_log($cash_book_log, 'Debit');





        return response()->json(['success' => '','$other_income_payment_history'=> $Other_income , '$other_income_payment_history' => $other_income_payment_history]);


    }

//    public function test1(Request $request){
//        $otherIncomePayments = Other_income_payment::all();
//        $otherIncomedetails = Other_income::all();
//        \Illuminate\Support\Facades\Log::info('w' . $otherIncomedetails);
//
//        if ($otherIncomePayments->isNotEmpty()) {
//            foreach ($otherIncomePayments as $otherIncomePayment) {
//                $paymentHistory = new Other_income_payments_history;
//                $paymentHistory->date = $otherIncomePayment->date;
//                $paymentHistory->other_income_id = $otherIncomePayment->other_income_id;
//                $paymentHistory->total_amount = $otherIncomePayment->total_amount;
//                $paymentHistory->paid_amount = $otherIncomePayment->paid_amount;
//                $paymentHistory->balance = $otherIncomePayment->balance;
//
//                if ($otherIncomedetails->isNotEmpty()) {
//                    $paymentHistory->payment_method = $otherIncomedetails->first()->payment_method;
//                }
//
//                $paymentHistory->save();
//            }
//
//            return response()->json(['success' => true, 'message' => 'All payments successfully moved to history.']);
//        } else {
//            return response()->json(['success' => false, 'message' => 'No payments found.']);
//        }
//    }






    public function test1(Request $request){
        $reservations = Reservation::all();

        if ($reservations->isNotEmpty()) {
            foreach ($reservations as $reservation) {

                $existingCustomer = Customer::where('email', $reservation->email)->first();

                // If the customer doesn't exist, create a new one
                if (!$existingCustomer) {
                    $customer = new Customer();
                    $customer->first_name = $reservation->first_name;
                    $customer->last_name = $reservation->last_name;
                    $customer->email = $reservation->email;
                    $customer->country = $reservation->country;
                    $customer->hotel_id = $reservation->hotel_id;
                    $customer->passport_number = $reservation->passport_number;
                    $customer->phone = $reservation->phone;

                    $customer->save();

                    // Link the new customer to the reservation
                    $reservation->customer_id = $customer->id;
                    $reservation->save();
                } else {
                    // If the customer exists, link the existing customer to the reservation
                    $reservation->customer_id = $existingCustomer->id;
                    $reservation->save();
                }
            }

            return response()->json(['success' => true, 'message' => 'All records successfully processed.']);
        } else {
            return response()->json(['success' => false, 'message' => 'No records found.']);
        }
    }

    public function promotion_view()
    {
        $promotions = Promotion::with('menu')->get();
//        return $promotions;
        return view('hotel.promotion_view', compact('promotions'));
    }

    public function add_promotion_save(Request $request)
    {
        $data = $request->all();

        foreach ($data['product'] as $productId) {
            // Parse the date
            $date = Carbon::parse($data['date']);
            // Parse the start time
            $startTime = Carbon::parse($data['start_time']);

            // Parse the end time
            $endTime = Carbon::parse($data['end_time']);

            // Combine date with start time
            $combinedStartTime = $date->copy()->setTime($startTime->hour, $startTime->minute, $startTime->second);

            // Combine date with end time
            $combinedEndTime = $date->copy()->setTime($endTime->hour, $endTime->minute, $endTime->second);

            $promotion = new Promotion();
            $promotion -> date = $date->toDateString();
            $promotion -> start_time = $combinedStartTime->format('Y-m-d H:i:s');
            $promotion -> end_time = $combinedEndTime->format('Y-m-d H:i:s');
            $promotion -> percentage = $data['percentage'];
            $promotion -> menu_id = $productId;

            $promotion->save();
        }

        return redirect()->back()->with('success', 'Promotions added successfully');
    }



    public function promotion_get_products()
    {
        // Fetch products from the database (assuming you have a Menu model)
        $products = Menu::select('id', 'name')->where('type', 'Visible')->get();

        // Return products as JSON
        return response()->json($products);
    }



    public function delete_promotion(Request $request){

//        return $request;

        $promotionId = $request->input('promotionId');

        $promotion = Promotion::find($promotionId)->delete();
        return response()->json(['success', 'Successfully deleted!']);

    }

    public function edit_promotion_save(Request $request)
    {
        $data = $request->all();
        $date = Carbon::parse($data['date']);
        $startTime = Carbon::parse($data['start_time']);
        $endTime = Carbon::parse($data['end_time']);
        $combinedStartTime = $date->copy()->setTime($startTime->hour, $startTime->minute, $startTime->second);
        $combinedEndTime = $date->copy()->setTime($endTime->hour, $endTime->minute, $endTime->second);

        // Assuming Promotion model exists
        $promotion = Promotion::findOrFail($data['promotion_id']);
        $promotion->date = $date->toDateString();
        $promotion->start_time = $combinedStartTime->format('Y-m-d H:i:s');
        $promotion->end_time = $combinedEndTime->format('Y-m-d H:i:s');
        $promotion->menu_id = $data['product']; // Product is a single item
        $promotion->percentage = $data['percentage'];
        // Update other fields as needed

        $promotion->save();

        return redirect()->back()->with('success', 'Promotion updated successfully');
    }








    public function  view_resturant(Request $request){




     return view('hotel.view_resturant_details');
 }





    public function resturent(Request $request)
    {
        $selected_date_sale = $request->input('selected_date_resturent');
        $d_m_obj_start = new Carbon($selected_date_sale);
        $d_m_obj_end = new Carbon($selected_date_sale);

        $start_month = $d_m_obj_start->startOfMonth();
        $end_month = $d_m_obj_end->endOfMonth();

        $year = \Illuminate\Support\Carbon::now()->year;
        $month = Carbon::now()->month;
        $daysCount = $start_month->daysInMonth;



        $Sale_Total = Order_list::whereMonth('finalize_date', '=', date('m', strtotime($selected_date_sale)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($selected_date_sale)))
            ->where('hotel_id', auth()->user()->hotel_id)
            ->selectRaw('payment_method')
            ->selectRaw('DAYOFMONTH(finalize_date) as monthDay, SUM(total) as total_sale')
            ->groupBy('payment_method', 'monthDay')
            ->get();

        $sale_cost_Toal = Order_list::with('Order_list_detail')
            ->whereMonth('finalize_date', '=', date('m', strtotime($selected_date_sale)))
            ->whereYear('finalize_date', '=', date('Y', strtotime($selected_date_sale)))
            ->get();


        Log::info('Sale_Total_Day' . $Sale_Total);
        $totalMonthOverallSum = 0.00;
        foreach ($sale_cost_Toal as $orders) {
            foreach ($orders->order_list_detail as $orderDetail) {
                $orderMenus = json_decode($orderDetail->como_items_list, true);
                $menuIds = [];

                foreach ($orderMenus as $orderMenu) {
                    $menuIds[] = $orderMenu['menu_id'];

                }

                $menus =Menu::with('combo.combo_item.menu.recipe')
                    ->where('hotel_id', auth()->user()->hotel_id)
                    ->whereIn('id', $menuIds)
                    ->get();
                Log::info('$momth_menus: '.  $menus);

                $mtotalMenuItemCost = 0.00;

                foreach ($menus as $menu) {
                    $mrecipeItemTotalCost = 0.00;
                    $mrecipeItemTotalCost0= 0.00;
                    $mrecipeItemTotalCost1=0.00;

                    foreach ($menu->combo as $combo) {
                        if ($combo->item == 1) {

                            if ($combo->combo_item[0]->recipe_id != null) {
                                $recipe_items = Recipe_item::with('item')
                                    ->where('recipe_id', $combo->combo_item[0]->recipe_id)
                                    ->get();

                                foreach ($recipe_items as $recipe_item) {
                                    $tt = $recipe_item->quantity * $combo->combo_item[0]->quantity * $recipe_item->item->unit_price;
                                    $mrecipeItemTotalCost0 += $tt;

                                }
                            } else {
                                // Handle the case when recipe_id is null
                            }
                        } else {
                            foreach ($combo->combo_item as $combo_item) {
                                $menu_2 = Menu::with('combo.combo_item.menu')
                                    ->find($combo_item->menu->id);

                                foreach ($menu_2->combo as $combo_2) {
                                    foreach ($combo_2->combo_item as $combo_item_2) {
                                        $recipe_items = Recipe_item::with('item')
                                            ->where('recipe_id', $combo_item_2->recipe_id)
                                            ->get();

                                        foreach ($recipe_items as $recipe_item) {
                                            $tt = $recipe_item->quantity * $combo_2->combo_item[0]->quantity * $recipe_item->item->unit_price;
                                            $mrecipeItemTotalCost1 += $tt;

                                        }
                                    }
                                }
                            }
                        }
                        $mrecipeItemTotalCost=  $mrecipeItemTotalCost0+$mrecipeItemTotalCost1;
                    }


                    $mtotalMenuItemCost += $mrecipeItemTotalCost;

                }
                $totalOrder =


                $mtotalOrderCost = $mtotalMenuItemCost * $orderDetail->quantity;
                $totalMonthOverallSum += $mtotalOrderCost;

                Log::info('Overall Sum of Order Detail ID ' . $orderDetail->id . ': ' . $totalMonthOverallSum );
            }
        }
















        $Sale_Total_Day = Order_list::with('Order_list_detail')
            ->where('finalize_date', $selected_date_sale)

            ->where('hotel_id', auth()->user()->hotel_id)
            ->get();


        $totalOverallSum = 0.00;


        foreach ($Sale_Total_Day as $order) {
            foreach ($order->order_list_detail as $orderDetail) {
                $orderMenus = json_decode($orderDetail->como_items_list, true);
                $menuIds = [];

                foreach ($orderMenus as $orderMenu) {
                    $menuIds[] = $orderMenu['menu_id'];

                }

                $menus =Menu::with('combo.combo_item.menu.recipe')
                    ->where('hotel_id', auth()->user()->hotel_id)
                    ->whereIn('id', $menuIds)
                    ->get();
                Log::info('$menus: '.  $menus);

                $totalMenuItemCost = 0.00;

                foreach ($menus as $menu) {
                    $recipeItemTotalCost = 0.00;
                    $recipeItemTotalCost0= 0.00;
                    $recipeItemTotalCost1=0.00;

                    foreach ($menu->combo as $combo) {
                        if ($combo->item == 1) {

                            if ($combo->combo_item[0]->recipe_id != null) {
                                $recipe_items = Recipe_item::with('item')
                                    ->where('recipe_id', $combo->combo_item[0]->recipe_id)
                                    ->get();

                                foreach ($recipe_items as $recipe_item) {
                                    $tt = $recipe_item->quantity * $combo->combo_item[0]->quantity * $recipe_item->item->unit_price;
                                    $recipeItemTotalCost0 += $tt;

                                }
                            } else {
                                // Handle the case when recipe_id is null
                            }
                        } else {
                            foreach ($combo->combo_item as $combo_item) {
                                $menu_2 = Menu::with('combo.combo_item.menu')
                                    ->find($combo_item->menu->id);

                                foreach ($menu_2->combo as $combo_2) {
                                    foreach ($combo_2->combo_item as $combo_item_2) {
                                        $recipe_items = Recipe_item::with('item')
                                            ->where('recipe_id', $combo_item_2->recipe_id)
                                            ->get();

                                        foreach ($recipe_items as $recipe_item) {
                                            $tt = $recipe_item->quantity * $combo_2->combo_item[0]->quantity * $recipe_item->item->unit_price;
                                            $recipeItemTotalCost1 += $tt;

                                        }
                                    }
                                }
                            }
                        }
                        $recipeItemTotalCost=  $recipeItemTotalCost0+$recipeItemTotalCost1;
                    }


                    $totalMenuItemCost += $recipeItemTotalCost;

                }
                $totalOrder =


                $totalOrderCost = $totalMenuItemCost * $orderDetail->quantity;
                $totalOverallSum += $totalOrderCost;

                Log::info('Overall Sum of Order Detail ID ' . $orderDetail->id . ': ' . $totalOrderCost);
            }
        }



// Log the grand total overall sum
        Log::info('Grand Total Overall Sum: ' . $totalOverallSum);











// $overallSums now contains the overall cost for each $orderDetail->id separately.

// $overallSum now contains the overall cost for all orders and menu items.








        $total_sale_count = $Sale_Total->where('payment_method', '!=', 'Free')->sum('total_sale');
        $total_sale_today = $Sale_Total_Day->where('payment_method', '!=', 'Free')->sum('total');






        $readable = [];

        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($selected_date_sale)), date('Y', strtotime($selected_date_sale))); $i++) {
            $flag = 'Not found';
            $t_sale = 0;

            foreach ($Sale_Total as $total_cost_data) {
                if ($total_cost_data->monthDay == $i) {
                    $t_sale = $total_cost_data->total_sale;
                    $flag = 'Found';
                    break;
                }
            }

            if ($flag == 'Found') {
                array_push($readable, [
                    'date' => \Illuminate\Support\Carbon::createFromDate(date('Y', strtotime($selected_date_sale)), date('m', strtotime($selected_date_sale)), $i),
                    'value1' => $t_sale,
                ]);
            } elseif ($flag == 'Not found') {
                array_push($readable, [
                    'date' => \Illuminate\Support\Carbon::createFromDate(date('Y', strtotime($selected_date_sale)), date('m', strtotime($selected_date_sale)), $i),
                    'value1' => 0,
                ]);
            }
        }

        return response()->json([
            'total_sale_count' => $total_sale_count,
            'total_sale_today' => $total_sale_today,
            'Sale_Total_Day' => $Sale_Total_Day,
              'total_cost_count' => $totalOverallSum,
            'totalMonthOverallSum' => $totalMonthOverallSum,
            'Sale_Total_Day'     => $Sale_Total_Day,

            'readable' => $readable,
        ]);
    }













}


