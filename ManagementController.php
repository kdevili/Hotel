<?php

namespace App\Http\Controllers;

use App\Assign_expenses_cashbook;
use App\Assigned_hotel;
use App\Booking;
use App\Booking_room;
use App\Cashbook;
use App\Check_list_layout;
use App\Combo;
use App\Combo_item;
use App\Expense_category;
use App\Expense_sub_category;
use App\Goods_received_note;
use App\Hotel;
use App\Hotel_chain;
use App\Housekeeping;
use App\Hotel_reservation_setting;
use App\Item;
use App\Item_category;
use App\Item_category_detail;
use App\Janitorial_item;
use App\Job_application_detail;
use App\Job_position_category;
use App\Menu;
use App\Other_income_category_list;
use App\Other_income_payment_cash_book;
use App\Other_location;
use App\Maintenance;
use App\Price_category;
use App\Privilege;
use App\Recipe;
use App\Recipe_item;
use App\Refilling_item;
use App\Repair_category;
use App\Repair_status;
use App\Reservation;
use App\Restaurant;
use App\Restaurant_menu;
use App\Room;
use App\Room_category;
use App\Room_rapair;
use App\Supplier;
use App\Supplier_payment;
use App\Table;
use App\User;
use App\Utility;
use App\Utility_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class ManagementController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(){

     return redirect()->route('management/view_hotels');
    }
    public function view_hotels($id){
        $hotels = Hotel::where('hotel_chain_id',$id)->where('status','Active')->get();
//        return $hotels;
        $hotel_chains = Assigned_hotel::where('user_id',auth()->user()->id)->get();
        return view('management.view_hotels',['hotels'=>$hotels,'hotel_chains'=>$hotel_chains]);
    }
    public function add_hotel_view(){
        $hotel_chains = Assigned_hotel::select('hotel_chain_id','user_id')->with('hotel_chain.hotels')->where('user_id',auth()->user()->id)
            ->groupBy('hotel_chain_id','user_id')->get();
//return $hotel_chains;
        return view('management.add_hotels',['hotel_chains'=>$hotel_chains]);
    }
    public function save_hotel_chain(Request $request){
        $chain_name = $request->input('chain_name');
        $hotel_chain = new Hotel_chain();
        $hotel_chain->name = $chain_name;
        $hotel_chain->save();

        $assigned_hotel = new Assigned_hotel();
        $assigned_hotel->hotel_chain_id = $hotel_chain->id;
        $assigned_hotel->user_id = auth()->user()->id;
        $assigned_hotel->save();
        return redirect()->back()->with('success');
    }
    public function edit_hotel_chain_get_details(Request $request){
        $hotel_chain_id = $request->input('hotel_chain_id');
        $hotel_chain= Hotel_chain::find($hotel_chain_id);
        return response()->json(['success'=>'success','hotel_chain'=>$hotel_chain]);
    }
    public function edit_hotel_chain_save(Request $request){
        $hotel_chain_id = $request->input('hotel_chain_id');
        $chain_edit_name = $request->input('chain_edit_name');
        $hotel_chain= Hotel_chain::find($hotel_chain_id);
        $hotel_chain->name = $chain_edit_name;
        $hotel_chain->save();
        return redirect()->back()->with('success');
    }
    public function save_hotel(Request $request){
        $hotel_name = $request->input('hotel_name');
        $hotel_chain_ids = $request->input('hotel_chain_ids');
        $country = $request->input('country');
        $city = $request->input('city');
        $address = $request->input('address');
        $email = $request->input('email');
        $mobile_number = $request->input('mobile_number');

        $hotel = new Hotel();
        $hotel->hotel_name = $hotel_name;
        $hotel->country = $country;
        $hotel->city = $city;
        $hotel->address = $address;
        $hotel->email = $email;
        $hotel->number = $mobile_number;
        $hotel->status = 'Active';
        $hotel->hotel_chain_id = $hotel_chain_ids;
        $hotel->save();

        $assigned_hotel = new Assigned_hotel();
        $assigned_hotel->hotel_chain_id = $hotel_chain_ids;
        $assigned_hotel->user_id = auth()->user()->id;
        $assigned_hotel->save();

        return redirect()->back()->with('success');
    }
    public function get_hotel_details_edit(Request $request){
        $hotel_id = $request->input('hotel_id');
        $hotel = Hotel::where('id',$hotel_id)->first();
        return response()->json(['success'=>'success','hotel'=>$hotel]);
    }
    public function edit_hotel_save(Request $request){
        $hotel_id = $request->input('hotel_id');
        $hotel_name = $request->input('e_hotel_name');
        $hotel_chain_ids = $request->input('hotel_chain_ids');
        $country = $request->input('e_country');
        $city = $request->input('e_city');
        $address = $request->input('e_address');
        $email = $request->input('e_email');
        $mobile_number = $request->input('e_mobile_number');

        $hotel = Hotel::find($hotel_id);
        $hotel->hotel_name = $hotel_name;
        $hotel->hotel_chain_id = $hotel_chain_ids;
        $hotel->country = $country;
        $hotel->city = $city;
        $hotel->address = $address;
        $hotel->email = $email;
        $hotel->number = $mobile_number;
        $hotel->save();

        $get_hotel = Hotel::where('id',$hotel->id)->first();
        return response()->json(['success'=>'success','get_hotel'=>$get_hotel]);
    }
    public function delete_hotel(Request $request){
        $hotel_id = $request->input('hotel_id');
        $hotel_delete = Hotel::find($hotel_id);
        $hotel_delete->status = 'Block';
        $hotel_delete->save();
        return response()->json(['success'=>'success']);
    }
    public function add_user_view(){
        $hotels = Hotel::where('status','Active')->get();
        return view('management.add_user',['hotels'=>$hotels]);
    }
    public function view_users($id){

    $hotel = Hotel::with('hotel_chain' , 'privilege.user')->where('id',$id)->first();
    return view('management.view_users',['hotel'=>$hotel]);
    }
    public function add_user_save(Request $request){
        $f_name = $request->input('fname');
        $l_name = $request->input('lname');
        $email = $request->input('email');
        $hotel_id = $request->input('hotel_id_a');
        $hotel_chain_id = $request->input('hotel_chain_id_a');
        $password = $request->input('password');
        $pass = Hash::make($password);

        $save_user = new User();
        $save_user->name =$f_name;
        $save_user->lname =$l_name;
        $save_user->email =$email;
        $save_user->hotel_id =$hotel_id;
        $save_user->hotel_chain_id =$hotel_chain_id;
        $save_user->password =$pass;
        $save_user->status ='Active';
        $save_user->role ='Staff';
        $save_user->save();

        $privilege = new Privilege();
        $privilege->user_id = $save_user->id;
        $privilege->hotel_id = $save_user->hotel_id;
        $privilege->hotel_chain_id = $save_user->hotel_chain_id;
        if( $request->has('recipe_v')){
            $privilege->recipe_view = 'Allow';
        }else{
            $privilege->recipe_view = 'Deny';
        }
        if( $request->has('recipe_a')){
            $privilege->recipe_add = 'Allow';
        } else{
            $privilege->recipe_add = 'Deny';
        }
        if( $request->has('recipe_e')){
            $privilege->recipe_edit = 'Allow';
        } else{
            $privilege->recipe_edit = 'Deny';
        }
        if( $request->has('recipe_d')){
            $privilege->recipe_delete = 'Allow';
        } else{
            $privilege->recipe_delete = 'Deny';
        }
        if( $request->has('stock_v')){
            $privilege->stock_view = 'Allow';
        } else{
            $privilege->stock_view = 'Deny';
        }
        if( $request->has('stock_a')){
            $privilege->stock_add = 'Allow';
        } else{
            $privilege->stock_add = 'Deny';
        }
        if( $request->has('stock_e')){
            $privilege->stock_edit = 'Allow';
        }else{
            $privilege->stock_edit = 'Deny';
        }if( $request->has('stock_d')){
            $privilege->stock_delete = 'Allow';
        }else{
            $privilege->stock_delete = 'Deny';
        }
        if( $request->has('grn_v')){
            $privilege->grn_view = 'Allow';
        }else{
            $privilege->grn_view = 'Deny';
        }
        if( $request->has('grn_a')){
            $privilege->grn_add = 'Allow';
        }else{
            $privilege->grn_add = 'Deny';
        }
        if( $request->has('grn_e')){
            $privilege->grn_edit = 'Allow';
        }else{
            $privilege->grn_edit = 'Deny';
        }
        if( $request->has('grn_d')){
            $privilege->grn_delete = 'Allow';
        }else{
            $privilege->grn_delete = 'Deny';
        }
        if( $request->has('grn_w')){
            $privilege->grn_widget = 'Allow';
        }else{
            $privilege->grn_widget = 'Deny';
        }

        if( $request->has('pos_v')){
            $privilege->pos_view = 'Allow';
        }else{
            $privilege->pos_view = 'Deny';
        }
        if( $request->has('pos_w')){
            $privilege->pos_widget = 'Allow';
        }else{
            $privilege->pos_widget = 'Deny';
        }

        if( $request->has('waste_v')){
            $privilege->waste_view = 'Allow';
        }else{
            $privilege->waste_view = 'Deny';
        }
        if( $request->has('waste_a')){
            $privilege->waste_add = 'Allow';
        }else{
            $privilege->waste_add = 'Deny';
        }
        if( $request->has('waste_e')){
            $privilege->waste_edit = 'Allow';
        }else{
            $privilege->waste_edit = 'Deny';
        }
        if( $request->has('waste_d')){
            $privilege->waste_delete = 'Allow';
        }else{
            $privilege->waste_delete = 'Deny';
        }
        if( $request->has('past_v')){
            $privilege->past_view = 'Allow';
        }else{
            $privilege->past_view = 'Deny';
        }
        if( $request->has('inventory_v')){
            $privilege->inventory_view = 'Allow';
        }else{
            $privilege->inventory_view = 'Deny';
        }
        if( $request->has('inventory_a')){
            $privilege->inventory_add = 'Allow';
        }else{
            $privilege->inventory_add = 'Deny';
        }
        if( $request->has('inventory_e')){
            $privilege->inventory_edit = 'Allow';
        }else{
            $privilege->inventory_edit = 'Deny';
        }
        if( $request->has('inventory_damage_v')){
            $privilege->inventory_damage_view = 'Allow';
        }else{
            $privilege->inventory_damage_view = 'Deny';
        }
        if( $request->has('inventory_damage_a')){
            $privilege->inventory_damage_add= 'Allow';
        }else{
            $privilege->inventory_damage_add = 'Deny';
        }
        if( $request->has('inventory_damage_e')){
            $privilege->inventory_damage_edit = 'Allow';
        }else{
            $privilege->inventory_damage_edit = 'Deny';
        }
        if( $request->has('inventory_damage_d')){
            $privilege->inventory_damage_delete = 'Allow';
        }else{
            $privilege->inventory_damage_delete = 'Deny';
        }
        if( $request->has('kot_v')){
            $privilege->kot_view = 'Allow';
        }else{
            $privilege->kot_view = 'Deny';
        }
        if( $request->has('reservation_v')){
            $privilege->reservation_view = 'Allow';
        }else{
            $privilege->reservation_view = 'Deny';
        }
        if( $request->has('reservation_a')){
            $privilege->reservation_add = 'Allow';
        }else{
            $privilege->reservation_add = 'Deny';
        }
        if( $request->has('reservation_e')){
            $privilege->reservation_edit = 'Allow';
        }else{
            $privilege->reservation_edit = 'Deny';
        }
        if( $request->has('reservation_d')){
            $privilege->reservation_delete = 'Allow';
        }else{
            $privilege->reservation_delete = 'Deny';
        }
        if( $request->has('reservation_w')){
            $privilege->reservation_widget = 'Allow';
        }else{
            $privilege->reservation_widget = 'Deny';
        }

        if( $request->has('maintenance_v')){
            $privilege->maintenance_view = 'Allow';
        }else{
            $privilege->maintenance_view = 'Deny';
        }
        if( $request->has('maintenance_a')){
            $privilege->maintenance_add = 'Allow';
        }else{
            $privilege->maintenance_add = 'Deny';
        }
        if( $request->has('maintenance_e')){
            $privilege->maintenance_edit = 'Allow';
        }else{
            $privilege->maintenance_edit = 'Deny';
        }
        if( $request->has('maintenance_d')){
            $privilege->maintenance_delete = 'Allow';
        }else{
            $privilege->maintenance_delete = 'Deny';
        }
        if( $request->has('maintenance_w')){
            $privilege->maintenance_widget = 'Allow';
        }else{
            $privilege->maintenance_widget = 'Deny';
        }

        if( $request->has('housekeeping_v')){
            $privilege->housekeeping_view = 'Allow';
        }else{
            $privilege->housekeeping_view = 'Deny';
        }
        if( $request->has('housekeeping_a')){
            $privilege->housekeeping_add = 'Allow';
        }else{
            $privilege->housekeeping_add = 'Deny';
        }
        if( $request->has('housekeeping_e')){
            $privilege->housekeeping_edit = 'Allow';
        }else{
            $privilege->housekeeping_edit = 'Deny';
        }
        if( $request->has('housekeeping_w')){
            $privilege->housekeeping_widget = 'Allow';
        }else{
            $privilege->housekeeping_widget = 'Deny';
        }

        if( $request->has('expenses_v')){
            $privilege->expenses_view = 'Allow';
        }else{
            $privilege->expenses_view = 'Deny';
        }
        if( $request->has('expenses_a')){
            $privilege->expenses_add = 'Allow';
        }else{
            $privilege->expenses_add = 'Deny';
        }
        if( $request->has('expenses_e')){
            $privilege->expenses_edit = 'Allow';
        }else{
            $privilege->expenses_edit = 'Deny';
        }
        if( $request->has('cashbook_v')){
            $privilege->cashbook_view = 'Allow';
        }else{
            $privilege->cashbook_view = 'Deny';
        }
        if( $request->has('cashbook_a')){
            $privilege->cashbook_add = 'Allow';
        }else{
            $privilege->cashbook_add = 'Deny';
        }
        if( $request->has('cashbook_e')){
            $privilege->cashbook_edit = 'Allow';
        }else{
            $privilege->cashbook_edit = 'Deny';
        }
        if( $request->has('cashbook_d')){
            $privilege->cashbook_delete = 'Allow';
        }else{
            $privilege->cashbook_delete = 'Deny';
        }

        if( $request->has('utility_v')){
            $privilege->utility_view = 'Allow';
        }else{
            $privilege->utility_view = 'Deny';
        }
        if( $request->has('utility_a')){
            $privilege->utility_add = 'Allow';
        }else{
            $privilege->utility_add = 'Deny';
        }
        if( $request->has('utility_e')){
            $privilege->utility_edit = 'Allow';
        }else{
            $privilege->utility_edit = 'Deny';
        }
        if( $request->has('utility_d')){
            $privilege->utility_delete = 'Allow';
        }else{
            $privilege->utility_delete = 'Deny';
        }
        if( $request->has('utility_w')){
            $privilege->utility_widget = 'Allow';
        }else{
            $privilege->utility_widget = 'Deny';
        }


        if( $request->has('booking_v')){
            $privilege->booking_view = 'Allow';
        }else{
            $privilege->booking_view = 'Deny';
        }
        if( $request->has('booking_a')){
            $privilege->booking_add = 'Allow';
        }else{
            $privilege->booking_add = 'Deny';
        }
        if( $request->has('booking_e')){
            $privilege->booking_edit = 'Allow';
        }else{
            $privilege->booking_edit = 'Deny';
        }
        if( $request->has('booking_d')){
            $privilege->booking_delete = 'Allow';
        }else{
            $privilege->booking_delete = 'Deny';
        }
        if( $request->has('booking_w')){
            $privilege->booking_widget = 'Allow';
        }else{
            $privilege->booking_widget = 'Deny';
        }


        if( $request->has('invoice_v')){
            $privilege->invoice_view = 'Allow';
        }else{
            $privilege->invoice_view = 'Deny';
        }
        if( $request->has('invoice_a')){
            $privilege->invoice_add = 'Allow';
        }else{
            $privilege->invoice_add = 'Deny';
        }
        if( $request->has('invoice_d')){
            $privilege->invoice_delete = 'Allow';
        }else{
            $privilege->invoice_delete = 'Deny';
        }

        if( $request->has('supplier_v')){
            $privilege->supplier_view = 'Allow';
        }else{
            $privilege->supplier_view = 'Deny';
        }
        if( $request->has('supplier_a')){
            $privilege->supplier_add = 'Allow';
        } else{
            $privilege->supplier_add = 'Deny';
        }
        if( $request->has('supplier_e')){
            $privilege->supplier_edit = 'Allow';
        } else{
            $privilege->supplier_edit = 'Deny';
        }
        if( $request->has('supplier_d')){
            $privilege->supplier_delete = 'Allow';
        } else{
            $privilege->supplier_delete = 'Deny';
        }
        if( $request->has('customer_v')){
            $privilege->customer_view = 'Allow';
        } else{
            $privilege->customer_view = 'Deny';
        }
        if( $request->has('customer_e')){
            $privilege->customer_edit = 'Allow';
        } else{
            $privilege->customer_edit = 'Deny';
        }
        if($request->has('other_income_v')){
            $privilege->other_income_view = 'Allow';
        }else{
            $privilege->other_income_view = 'Deny';
        }
        if($request->has('other_income_a')){
            $privilege->other_income_add = 'Allow';
        }else{
            $privilege->other_income_add = 'Deny';
        }
        if($request->has('other_income_e')){
            $privilege->other_income_edit = 'Allow';
        }else{
            $privilege->other_income_edit = 'Deny';
        }
        if($request->has('other_income_d')){
            $privilege->other_income_delete = 'Allow';
        }else{
            $privilege->other_income_delete = 'Deny';
        }

        //agency and guide//
        if( $request->has('agencyGuide_v')){
            $privilege->agencyGuide_view = 'Allow';
        }else{
            $privilege->agencyGuide_view = 'Deny';
        }

        if( $request->has('agencyGuide_e')){
            $privilege->agencyGuide_edit = 'Allow';
        } else{
            $privilege->agencyGuide_edit = 'Deny';
        }
        if( $request->has('agencyGuide_d')){
            $privilege->agencyGuide_delete = 'Allow';
        } else{
            $privilege->agencyGuide_delete = 'Deny';
        }
        if($request->has('resturent_v')){
            $privilege->resturant_view = 'Allow';
        } else {
            $privilege->resturant_view = 'Deny';
        }

        $privilege->save();

        return response()->json(['success'=>'success','save_user'=>$save_user,'privilege'=>$privilege]);
    }
    public function assign_user_save(Request $request)
    {

        $user_id = $request->input('assign_user_id');
        $hotel_id = $request->input('a_hotel_id_a');
        $hotel_chain_id = $request->input('a_hotel_chain_id_a');

        $privilege = new Privilege();
        $privilege->user_id = $user_id;
        $privilege->hotel_id = $hotel_id;
        $privilege->hotel_chain_id = $hotel_chain_id;
        if ($request->has('a_recipe_v')) {
            $privilege->recipe_view = 'Allow';
        } else {
            $privilege->recipe_view = 'Deny';
        }
        if ($request->has('a_recipe_a')) {
            $privilege->recipe_add = 'Allow';
        } else {
            $privilege->recipe_add = 'Deny';
        }
        if ($request->has('a_recipe_e')) {
            $privilege->recipe_edit = 'Allow';
        } else {
            $privilege->recipe_edit = 'Deny';
        }
        if ($request->has('a_recipe_d')) {
            $privilege->recipe_delete = 'Allow';
        } else {
            $privilege->recipe_delete = 'Deny';
        }
        if ($request->has('a_stock_v')) {
            $privilege->stock_view = 'Allow';
        } else {
            $privilege->stock_view = 'Deny';
        }
        if ($request->has('a_stock_a')) {
            $privilege->stock_add = 'Allow';
        } else {
            $privilege->stock_add = 'Deny';
        }
        if ($request->has('a_stock_e')) {
            $privilege->stock_edit = 'Allow';
        } else {
            $privilege->stock_edit = 'Deny';
        }
        if ($request->has('a_stock_d')) {
            $privilege->stock_delete = 'Allow';
        } else {
            $privilege->stock_delete = 'Deny';
        }
        if ($request->has('a_grn_v')) {
            $privilege->grn_view = 'Allow';
        } else {
            $privilege->grn_view = 'Deny';
        }
        if ($request->has('a_grn_a')) {
            $privilege->grn_add = 'Allow';
        } else {
            $privilege->grn_add = 'Deny';
        }
        if ($request->has('a_grn_e')) {
            $privilege->grn_edit = 'Allow';
        } else {
            $privilege->grn_edit = 'Deny';
        }
        if ($request->has('a_grn_d')) {
            $privilege->grn_delete = 'Allow';
        } else {
            $privilege->grn_delete = 'Deny';
        }
        if ($request->has('a_grn_w')) {
            $privilege->grn_widget = 'Allow';
        } else {
            $privilege->grn_widget = 'Deny';
        }

        if ($request->has('a_pos_v')) {
            $privilege->pos_view = 'Allow';
        } else {
            $privilege->pos_view = 'Deny';
        }
        if ($request->has('a_pos_w')) {
            $privilege->pos_widget = 'Allow';
        } else {
            $privilege->pos_widget = 'Deny';
        }
        if ($request->has('a_waste_v')) {
            $privilege->waste_view = 'Allow';
        } else {
            $privilege->waste_view = 'Deny';
        }
        if ($request->has('a_waste_a')) {
            $privilege->waste_add = 'Allow';
        } else {
            $privilege->waste_add = 'Deny';
        }
        if ($request->has('a_waste_e')) {
            $privilege->waste_edit = 'Allow';
        } else {
            $privilege->waste_edit = 'Deny';
        }
        if ($request->has('a_waste_d')) {
            $privilege->waste_delete = 'Allow';
        } else {
            $privilege->waste_delete = 'Deny';
        }
        if ($request->has('a_past_v')) {
            $privilege->past_view = 'Allow';
        } else {
            $privilege->past_view = 'Deny';
        }
        if ($request->has('a_inventory_v')) {
            $privilege->inventory_view = 'Allow';
        } else {
            $privilege->inventory_view = 'Deny';
        }
        if ($request->has('a_inventory_a')) {
            $privilege->inventory_add = 'Allow';
        } else {
            $privilege->inventory_add = 'Deny';
        }
        if ($request->has('a_inventory_e')) {
            $privilege->inventory_edit = 'Allow';
        } else {
            $privilege->inventory_edit = 'Deny';
        }
        if ($request->has('a_inventory_damage_v')) {
            $privilege->inventory_damage_view = 'Allow';
        } else {
            $privilege->inventory_damage_view = 'Deny';
        }
        if ($request->has('a_inventory_damage_a')) {
            $privilege->inventory_damage_add = 'Allow';
        } else {
            $privilege->inventory_damage_add = 'Deny';
        }
        if ($request->has('a_inventory_damage_e')) {
            $privilege->inventory_damage_edit = 'Allow';
        } else {
            $privilege->inventory_damage_edit = 'Deny';
        }
        if ($request->has('a_inventory_damage_d')) {
            $privilege->inventory_damage_delete = 'Allow';
        } else {
            $privilege->inventory_damage_delete = 'Deny';
        }
        if ($request->has('a_kot_v')) {
            $privilege->kot_view = 'Allow';
        } else {
            $privilege->kot_view = 'Deny';
        }
        if ($request->has('a_reservation_v')) {
            $privilege->reservation_view = 'Allow';
        } else {
            $privilege->reservation_view = 'Deny';
        }
        if ($request->has('a_reservation_a')) {
            $privilege->reservation_add = 'Allow';
        } else {
            $privilege->reservation_add = 'Deny';
        }
        if ($request->has('a_reservation_e')) {
            $privilege->reservation_edit = 'Allow';
        } else {
            $privilege->reservation_edit = 'Deny';
        }
        if ($request->has('a_reservation_d')) {
            $privilege->reservation_delete = 'Allow';
        } else {
            $privilege->reservation_delete = 'Deny';
        }
        if ($request->has('a_reservation_w')) {
            $privilege->reservation_widget = 'Allow';
        } else {
            $privilege->reservation_widget = 'Deny';
        }


        if ($request->has('a_maintenance_v')) {
            $privilege->maintenance_view = 'Allow';
        } else {
            $privilege->maintenance_view = 'Deny';
        }
        if ($request->has('a_maintenance_a')) {
            $privilege->maintenance_add = 'Allow';
        } else {
            $privilege->maintenance_add = 'Deny';
        }
        if ($request->has('a_maintenance_e')) {
            $privilege->maintenance_edit = 'Allow';
        } else {
            $privilege->maintenance_edit = 'Deny';
        }
        if ($request->has('a_maintenance_d')) {
            $privilege->maintenance_delete = 'Allow';
        } else {
            $privilege->maintenance_delete = 'Deny';
        }
        if ($request->has('a_maintenance_w')) {
            $privilege->maintenance_widget = 'Allow';
        } else {
            $privilege->maintenance_widget = 'Deny';
        }

        if ($request->has('a_housekeeping_v')) {
            $privilege->housekeeping_view = 'Allow';
        } else {
            $privilege->housekeeping_view = 'Deny';
        }
        if ($request->has('a_housekeeping_a')) {
            $privilege->housekeeping_add = 'Allow';
        } else {
            $privilege->housekeeping_add = 'Deny';
        }
        if ($request->has('a_maintenance_e')) {
            $privilege->housekeeping_edit = 'Allow';
        } else {
            $privilege->housekeeping_edit = 'Deny';
        }
        if ($request->has('a_maintenance_w')) {
            $privilege->housekeeping_widget = 'Allow';
        } else {
            $privilege->housekeeping_widget = 'Deny';
        }

        if ($request->has('a_expenses_v')) {
            $privilege->expenses_view = 'Allow';
        } else {
            $privilege->expenses_view = 'Deny';
        }
        if ($request->has('a_expenses_a')) {
            $privilege->expenses_add = 'Allow';
        } else {
            $privilege->expenses_add = 'Deny';
        }
        if ($request->has('a_expenses_e')) {
            $privilege->expenses_edit = 'Allow';
        } else {
            $privilege->expenses_edit = 'Deny';
        }
        if ($request->has('a_cashbook_v')) {
            $privilege->cashbook_view = 'Allow';
        } else {
            $privilege->cashbook_view = 'Deny';
        }
        if ($request->has('a_cashbook_a')) {
            $privilege->cashbook_add = 'Allow';
        } else {
            $privilege->cashbook_add = 'Deny';
        }
        if ($request->has('a_cashbook_e')) {
            $privilege->cashbook_edit = 'Allow';
        } else {
            $privilege->cashbook_edit = 'Deny';
        }
        if ($request->has('a_cashbook_d')) {
            $privilege->cashbook_delete = 'Allow';
        } else {
            $privilege->cashbook_delete = 'Deny';
        }

        if ($request->has('a_utility_v')) {
            $privilege->utility_view = 'Allow';
        } else {
            $privilege->utility_view = 'Deny';
        }
        if ($request->has('a_utility_a')) {
            $privilege->utility_add = 'Allow';
        } else {
            $privilege->utility_add = 'Deny';
        }
        if ($request->has('a_utility_e')) {
            $privilege->utility_edit = 'Allow';
        } else {
            $privilege->utility_edit = 'Deny';
        }
        if ($request->has('a_utility_d')) {
            $privilege->utility_delete = 'Allow';
        } else {
            $privilege->utility_delete = 'Deny';
        }
        if ($request->has('a_utility_w')) {
            $privilege->utility_widget = 'Allow';
        } else {
            $privilege->utility_widget = 'Deny';
        }


        if ($request->has('a_booking_v')) {
            $privilege->booking_view = 'Allow';
        } else {
            $privilege->booking_view = 'Deny';
        }
        if ($request->has('a_booking_a')) {
            $privilege->booking_add = 'Allow';
        } else {
            $privilege->booking_add = 'Deny';
        }
        if ($request->has('a_booking_e')) {
            $privilege->booking_edit = 'Allow';
        } else {
            $privilege->booking_edit = 'Deny';
        }
        if ($request->has('a_booking_d')) {
            $privilege->booking_delete = 'Allow';
        } else {
            $privilege->booking_delete = 'Deny';
        }
        if ($request->has('a_booking_w')) {
            $privilege->booking_widget = 'Allow';
        } else {
            $privilege->booking_widget = 'Deny';
        }


        if ($request->has('a_invoice_v')) {
            $privilege->invoice_view = 'Allow';
        } else {
            $privilege->invoice_view = 'Deny';
        }
        if ($request->has('a_invoice_a')) {
            $privilege->invoice_add = 'Allow';
        } else {
            $privilege->invoice_add = 'Deny';
        }
        if ($request->has('a_invoice_d')) {
            $privilege->invoice_delete = 'Allow';
        } else {
            $privilege->invoice_delete = 'Deny';
        }

        if ($request->has('a_supplier_v')) {
            $privilege->supplier_view = 'Allow';
        } else {
            $privilege->supplier_view = 'Deny';
        }
        if ($request->has('a_supplier_a')) {
            $privilege->supplier_add = 'Allow';
        } else {
            $privilege->supplier_add = 'Deny';
        }
        if ($request->has('a_supplier_e')) {
            $privilege->supplier_edit = 'Allow';
        } else {
            $privilege->supplier_edit = 'Deny';
        }
        if ($request->has('a_supplier_d')) {
            $privilege->supplier_delete = 'Allow';
        } else {
            $privilege->supplier_delete = 'Deny';
        }
        if ($request->has('a_customer_v')) {
            $privilege->customer_view = 'Allow';
        } else {
            $privilege->customer_view = 'Deny';
        }

        if ($request->has('a_customer_e')) {
            $privilege->customer_edit = 'Allow';
        } else {
            $privilege->customer_edit = 'Deny';
        }

        //agency and guide//
        if ($request->has('a_agencyGuide_v')) {
            $privilege->agencyGuide_view = 'Allow';
        } else {
            $privilege->agencyGuide_view = 'Deny';
        }
        if ($request->has('a_agencyGuide_e')) {
            $privilege->agencyGuide_edit = 'Allow';
        } else {
            $privilege->agencyGuide_edit = 'Deny';
        }
        if ($request->has('a_agencyGuide_d')) {
            $privilege->agencyGuide_delete = 'Allow';
        } else {
            $privilege->agencyGuide_delete = 'Deny';
        }

        if ($request->has('a_other_income_v')) {
            $privilege->other_income_view = 'Allow';
        } else {
            $privilege->other_income_view = 'Deny';
        }

        if ($request->has('a_other_income_a')) {
            $privilege->other_income_add = 'Allow';
        } else {
            $privilege->other_income_add = 'Deny';
        }
        if ($request->has('a_other_income_e')) {
            $privilege->other_income_edit = 'Allow';
        } else {
            $privilege->other_income_edit = 'Deny';
        }
        if ($request->has('a_other_income_d')) {
            $privilege->other_income_delete = 'Allow';
        } else {
            $privilege->other_income_delete = 'Deny';
        }

        if ($request->has('a_resturant_v')) {
            $privilege->resturant_view = 'Allow';
        } else {
            $privilege->resturant_view = 'Deny';
        }


        $privilege->save();
        $save_user = User::find($privilege->user_id);
        return response()->json(['success'=>'success','save_user'=>$save_user,'privilege'=>$privilege]);
    }
    public function view_user_privilege(Request $request){
        $user_id =  $request->input('user_id');
        $hotel_id =  $request->input('hotel_id');
        $privileges = Privilege::where('user_id',$user_id)->where('hotel_id',$hotel_id)->first();
        return response()->json(['success'=>'success','privileges'=>$privileges]);
    }
    public function delete_user_from_hotel(Request $request){
        $privilege_id =  $request->input('privilege_id');
        $delete_user_privilege = Privilege::find($privilege_id);
        $delete_user_privilege->delete();
        return response()->json(['success'=>'success']);
    }
    public function edit_user_details_get(Request $request){
        $user_id =  $request->input('user_id');
        $privilege_id =  $request->input('privilege_id');
        $edit_user = User::find($user_id);
        $edit_privilege = Privilege::find($privilege_id);
        return response()->json(['success'=>'success','edit_user'=>$edit_user,'edit_privilege'=>$edit_privilege]);
    }
    public function edit_user_save(Request $request){

        $f_name = $request->input('e_fname');
        $l_name = $request->input('e_lname');
        $email = $request->input('e_email');
        $edit_user_id = $request->input('edit_user_id');
        $edit_user_privilege_id = $request->input('edit_user_privilege_id');

        $save_user = User::find($edit_user_id);
        $save_user->name =$f_name;
        $save_user->lname =$l_name;
        $save_user->email =$email;
        $save_user->save();

        $edit_privilege = Privilege::find($edit_user_privilege_id);

        if( $request->has('e_recipe_v')){
            $edit_privilege->recipe_view = 'Allow';
        }else{
            $edit_privilege->recipe_view = 'Deny';
        }
        if( $request->has('e_recipe_a')){
            $edit_privilege->recipe_add = 'Allow';
        } else{
            $edit_privilege->recipe_add = 'Deny';
        }
        if( $request->has('e_recipe_e')){
            $edit_privilege->recipe_edit = 'Allow';
        } else{
            $edit_privilege->recipe_edit = 'Deny';
        }
        if( $request->has('e_recipe_d')){
            $edit_privilege->recipe_delete = 'Allow';
        } else{
            $edit_privilege->recipe_delete = 'Deny';
        }
        if( $request->has('e_stock_v')){
            $edit_privilege->stock_view = 'Allow';
        } else{
            $edit_privilege->stock_view = 'Deny';
        }
        if( $request->has('e_stock_a')){
            $edit_privilege->stock_add = 'Allow';
        } else{
            $edit_privilege->stock_add = 'Deny';
        }
        if( $request->has('e_stock_e')){
            $edit_privilege->stock_edit = 'Allow';
        }else{
            $edit_privilege->stock_edit = 'Deny';
        }if( $request->has('e_stock_d')){
            $edit_privilege->stock_delete = 'Allow';
        }else{
            $edit_privilege->stock_delete = 'Deny';
        }
        if( $request->has('e_grn_v')){
            $edit_privilege->grn_view = 'Allow';
        }else{
            $edit_privilege->grn_view = 'Deny';
        }
        if( $request->has('e_grn_a')){
            $edit_privilege->grn_add = 'Allow';
        }else{
            $edit_privilege->grn_add = 'Deny';
        }
        if( $request->has('e_grn_e')){
            $edit_privilege->grn_edit = 'Allow';
        }else{
            $edit_privilege->grn_edit = 'Deny';
        }
        if( $request->has('e_grn_d')){
            $edit_privilege->grn_delete = 'Allow';
        }else{
            $edit_privilege->grn_delete = 'Deny';
        }
        if( $request->has('e_grn_w')){
            $edit_privilege->grn_widget = 'Allow';
        }else{
            $edit_privilege->grn_widget = 'Deny';
        }

        if( $request->has('e_pos_v')){
            $edit_privilege->pos_view = 'Allow';
        }else{
            $edit_privilege->pos_view = 'Deny';
        }
        if( $request->has('e_pos_w')){
            $edit_privilege->pos_widget = 'Allow';
        }else{
            $edit_privilege->pos_widget = 'Deny';
        }

        if( $request->has('e_waste_v')){
            $edit_privilege->waste_view = 'Allow';
        }else{
            $edit_privilege->waste_view = 'Deny';
        }
        if( $request->has('e_waste_a')){
            $edit_privilege->waste_add = 'Allow';
        }else{
            $edit_privilege->waste_add = 'Deny';
        }
        if( $request->has('e_waste_e')){
            $edit_privilege->waste_edit = 'Allow';
        }else{
            $edit_privilege->waste_edit = 'Deny';
        }
        if( $request->has('e_waste_d')){
            $edit_privilege->waste_delete = 'Allow';
        }else{
            $edit_privilege->waste_delete = 'Deny';
        }
        if( $request->has('e_past_v')){
            $edit_privilege->past_view = 'Allow';
        }else{
            $edit_privilege->past_view = 'Deny';
        }
        if( $request->has('e_inventory_v')){
            $edit_privilege->inventory_view = 'Allow';
        }else{
            $edit_privilege->inventory_view = 'Deny';
        }
        if( $request->has('e_inventory_a')){
            $edit_privilege->inventory_add = 'Allow';
        }else{
            $edit_privilege->inventory_add = 'Deny';
        }
        if( $request->has('e_inventory_e')){
            $edit_privilege->inventory_edit = 'Allow';
        }else{
            $edit_privilege->inventory_edit = 'Deny';
        }
        if( $request->has('e_inventory_damage_v')){
            $edit_privilege->inventory_damage_view = 'Allow';
        }else{
            $edit_privilege->inventory_damage_view = 'Deny';
        }
        if( $request->has('e_inventory_damage_a')){
            $edit_privilege->inventory_damage_add= 'Allow';
        }else{
            $edit_privilege->inventory_damage_add = 'Deny';
        }
        if( $request->has('e_inventory_damage_e')){
            $edit_privilege->inventory_damage_edit = 'Allow';
        }else{
            $edit_privilege->inventory_damage_edit = 'Deny';
        }
        if( $request->has('e_inventory_damage_d')){
            $edit_privilege->inventory_damage_delete = 'Allow';
        }else{
            $edit_privilege->inventory_damage_delete = 'Deny';
        }
        if( $request->has('e_kot_v')){
            $edit_privilege->kot_view = 'Allow';
        }else{
            $edit_privilege->kot_view = 'Deny';
        }
        if( $request->has('e_reservation_v')){
            $edit_privilege->reservation_view = 'Allow';
        }else{
            $edit_privilege->reservation_view = 'Deny';
        }
        if( $request->has('e_reservation_a')){
            $edit_privilege->reservation_add = 'Allow';
        }else{
            $edit_privilege->reservation_add = 'Deny';
        }
        if( $request->has('e_reservation_e')){
            $edit_privilege->reservation_edit = 'Allow';
        }else{
            $edit_privilege->reservation_edit = 'Deny';
        }
        if( $request->has('e_reservation_d')){
            $edit_privilege->reservation_delete = 'Allow';
        }else{
            $edit_privilege->reservation_delete = 'Deny';
        }
        if( $request->has('e_reservation_w')){
            $edit_privilege->reservation_widget = 'Allow';
        }else{
            $edit_privilege->reservation_widget = 'Deny';
        }


        if( $request->has('e_maintenance_v')){
            $edit_privilege->maintenance_view = 'Allow';
        }else{
            $edit_privilege->maintenance_view = 'Deny';
        }
        if( $request->has('e_maintenance_a')){
            $edit_privilege->maintenance_add = 'Allow';
        }else{
            $edit_privilege->maintenance_add = 'Deny';
        }
        if( $request->has('e_maintenance_e')){
            $edit_privilege->maintenance_edit = 'Allow';
        }else{
            $edit_privilege->maintenance_edit = 'Deny';
        }
        if( $request->has('e_maintenance_d')){
            $edit_privilege->maintenance_delete = 'Allow';
        }else{
            $edit_privilege->maintenance_delete = 'Deny';
        }
        if( $request->has('e_maintenance_w')){
            $edit_privilege->maintenance_widget = 'Allow';
        }else{
            $edit_privilege->maintenance_widget = 'Deny';
        }


        if( $request->has('e_housekeeping_v')){
            $edit_privilege->housekeeping_view = 'Allow';
        }else{
            $edit_privilege->housekeeping_view = 'Deny';
        }
        if( $request->has('e_housekeeping_a')){
            $edit_privilege->housekeeping_add = 'Allow';
        }else{
            $edit_privilege->housekeeping_add = 'Deny';
        }
        if( $request->has('e_housekeeping_e')){
            $edit_privilege->housekeeping_edit = 'Allow';
        }else{
            $edit_privilege->housekeeping_edit = 'Deny';
        }
        if( $request->has('e_housekeeping_w')){
            $edit_privilege->housekeeping_widget = 'Allow';
        }else{
            $edit_privilege->housekeeping_widget = 'Deny';
        }

        if( $request->has('e_expenses_v')){
            $edit_privilege->expenses_view = 'Allow';
        }else{
            $edit_privilege->expenses_view = 'Deny';
        }
        if( $request->has('e_expenses_a')){
            $edit_privilege->expenses_add = 'Allow';
        }else{
            $edit_privilege->expenses_add = 'Deny';
        }
        if( $request->has('e_expenses_e')){
            $edit_privilege->expenses_edit = 'Allow';
        }else{
            $edit_privilege->expenses_edit = 'Deny';
        }
        if( $request->has('e_cashbook_v')){
            $edit_privilege->cashbook_view = 'Allow';
        }else{
            $edit_privilege->cashbook_view = 'Deny';
        }
        if( $request->has('e_cashbook_a')){
            $edit_privilege->cashbook_add = 'Allow';
        }else{
            $edit_privilege->cashbook_add = 'Deny';
        }
        if( $request->has('e_cashbook_e')){
            $edit_privilege->cashbook_edit = 'Allow';
        }else{
            $edit_privilege->cashbook_edit = 'Deny';
        }
        if( $request->has('e_cashbook_d')){
            $edit_privilege->cashbook_delete = 'Allow';
        }else{
            $edit_privilege->cashbook_delete = 'Deny';
        }

        if( $request->has('e_utility_v')){
            $edit_privilege->utility_view = 'Allow';
        }else{
            $edit_privilege->utility_view = 'Deny';
        }
        if( $request->has('e_utility_a')){
            $edit_privilege->utility_add = 'Allow';
        }else{
            $edit_privilege->utility_add = 'Deny';
        }
        if( $request->has('e_utility_e')){
            $edit_privilege->utility_edit = 'Allow';
        }else{
            $edit_privilege->utility_edit = 'Deny';
        }
        if( $request->has('e_utility_d')){
            $edit_privilege->utility_delete = 'Allow';
        }else{
            $edit_privilege->utility_delete = 'Deny';
        }
        if( $request->has('e_utility_w')){
            $edit_privilege->utility_widget = 'Allow';
        }else{
            $edit_privilege->utility_widget = 'Deny';
        }

        if( $request->has('e_booking_v')){
            $edit_privilege->booking_view = 'Allow';
        }else{
            $edit_privilege->booking_view = 'Deny';
        }
        if( $request->has('e_booking_a')){
            $edit_privilege->booking_add = 'Allow';
        }else{
            $edit_privilege->booking_add = 'Deny';
        }
        if( $request->has('e_booking_e')){
            $edit_privilege->booking_edit = 'Allow';
        }else{
            $edit_privilege->booking_edit = 'Deny';
        }
        if( $request->has('e_booking_d')){
            $edit_privilege->booking_delete = 'Allow';
        }else{
            $edit_privilege->booking_delete = 'Deny';
        }
        if( $request->has('e_booking_w')){
            $edit_privilege->booking_widget = 'Allow';
        }else{
            $edit_privilege->booking_widget = 'Deny';
        }


        if( $request->has('e_invoice_v')){
            $edit_privilege->invoice_view = 'Allow';
        }else{
            $edit_privilege->invoice_view = 'Deny';
        }
        if( $request->has('e_invoice_a')){
            $edit_privilege->invoice_add = 'Allow';
        }else{
            $edit_privilege->invoice_add = 'Deny';
        }
        if( $request->has('e_invoice_d')){
            $edit_privilege->invoice_delete = 'Allow';
        }else{
            $edit_privilege->invoice_delete = 'Deny';
        }

        if( $request->has('e_supplier_v')){
            $edit_privilege->supplier_view = 'Allow';
        }else{
            $edit_privilege->supplier_view = 'Deny';
        }
        if( $request->has('e_supplier_a')){
            $edit_privilege->supplier_add = 'Allow';
        } else{
            $edit_privilege->supplier_add = 'Deny';
        }
        if( $request->has('e_supplier_e')){
            $edit_privilege->supplier_edit = 'Allow';
        } else{
            $edit_privilege->supplier_edit = 'Deny';
        }
        if( $request->has('e_supplier_d')){
            $edit_privilege->supplier_delete = 'Allow';
        } else{
            $edit_privilege->supplier_delete = 'Deny';
        }
        if( $request->has('e_customer_v')){
            $edit_privilege->customer_view = 'Allow';
        } else{
            $edit_privilege->customer_view = 'Deny';
        }

        if( $request->has('e_customer_e')){
            $edit_privilege->customer_edit = 'Allow';
        } else{
            $edit_privilege->customer_edit= 'Deny';
        }
        if( $request->has('e_other_income_v')){
            $edit_privilege->other_income_view = 'Allow';
        } else{
            $edit_privilege->other_income_view= 'Deny';
        }
        if( $request->has('e_other_income_v')){
            $edit_privilege->other_income_view = 'Allow';
        } else{
            $edit_privilege->other_income_view= 'Deny';
        }
        if( $request->has('e_other_income_a')){
            $edit_privilege->other_income_add = 'Allow';
        } else{
            $edit_privilege->other_income_add= 'Deny';
        }

        if( $request->has('e_other_income_a')){
            $edit_privilege->other_income_add = 'Allow';
        } else{
            $edit_privilege->other_income_add= 'Deny';
        }

        if( $request->has('e_other_income_e')){
            $edit_privilege->other_income_edit = 'Allow';
        } else{
            $edit_privilege->other_income_edit= 'Deny';
        }
        if( $request->has('e_other_income_d')){
            $edit_privilege->other_income_delete = 'Allow';
        } else{
            $edit_privilege->other_income_delete= 'Deny';
        }



        //agency and guide//
        if( $request->has('e_agencyGuide_v')){
            $edit_privilege->agencyGuide_view = 'Allow';
        }else{
            $edit_privilege->agencyGuide_view = 'Deny';
        }
        if( $request->has('e_agencyGuide_e')){
            $edit_privilege->agencyGuide_edit = 'Allow';
        } else{
            $edit_privilege->agencyGuide_edit = 'Deny';
        }
        if( $request->has('e_agencyGuide_d')){
            $edit_privilege->agencyGuide_delete = 'Allow';
        } else{
            $edit_privilege->agencyGuide_delete = 'Deny';
        }
        if($request->has('e_resturant_v')){
            $edit_privilege->resturant_view = 'Allow';
        }else{
            $edit_privilege->resturant_view = 'Deny';
        }

        $edit_privilege->save();
        $privilege_id =$edit_privilege->id;
        $hotel_id = $edit_privilege->hotel_id;
        $edit_user = User::where('id',$save_user->id)->first();
        return response()->json(['success'=>'success','edit_user'=>$edit_user,'privilege_id'=>$privilege_id,'hotel_id'=>$hotel_id]);
    }
    public function view_restaurants($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $restaurants = Restaurant::with('hotel.hotel_chain')->where('hotel_id',$id)->where('status','Active')->get();
        $cash_books = Cashbook::where('hotel_id',auth()->user()->hotel_id)->get();
        return view('management.view_restaurants',['restaurants'=>$restaurants,'hotel'=>$hotel,'cash_books'=>$cash_books]);
    }
    public function assign_menu_save(Request $request){

        $menu_ids = $request->input('select');
        $restaurant = Restaurant::find($request->input('restaurant_id'));
        $restaurant->menu()->sync($menu_ids);
        return $request;
    }
    public function assign_menus_get(Request $request){
        $restaurant_id = $request->input('restaurant_id');
        $menus = Restaurant_menu::select('menu_id')->where('restaurant_id',$restaurant_id)->get();
        return response()->json(['menus'=>$menus]);
    }
    public function save_restaurants(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $hotel_chain_id = $request->input('hotel_chain_id_a');
        $restaurant_name = $request->input('restaurant_name');
        $cash_cashbook_id = $request->input('cash-cashbook-id');
        $card_cashbook_id = $request->input('card-cashbook-id');

        $restaurant = new Restaurant();
        $restaurant->name = $restaurant_name;
        $restaurant->hotel_id = $hotel_id;
        $restaurant->hotel_chain_id = $hotel_chain_id;
        $restaurant->status = 'Active';
        $restaurant->card_payment = $card_cashbook_id;
        $restaurant->cash_payment = $cash_cashbook_id;
        $restaurant->save();
        return response()->json(['success'=>'success','restaurant'=>$restaurant]);
    }
    public function delete_restaurants(Request $request){
        $restaurant_id = $request->input('restaurant_id');
        $delete_restaurant = Restaurant::find($restaurant_id);
        $delete_restaurant->status = 'Block';
        $delete_restaurant->save();
        return response()->json(['success'=>'success']);
    }
    public function get_restaurants_edit_details(Request $request){
        $restaurant_id = $request->input('restaurant_id');
        $restaurant = Restaurant::find($restaurant_id);
        return response()->json(['success'=>'success','restaurant'=>$restaurant]);
    }
    public function edit_restaurant_save(Request $request){
        $restaurant_id = $request->input('e_restaurant_id');
        $restaurant_name = $request->input('e_restaurant_name');
        $e_cash_cashbook_id = $request->input('e_cash-cashbook-id');
        $e_card_cashbook_id = $request->input('e_card-cashbook-id');
        $restaurant = Restaurant::find($restaurant_id);
        $restaurant->name = $restaurant_name;
        $restaurant->cash_payment = $e_cash_cashbook_id;
        $restaurant->card_payment = $e_card_cashbook_id;
        $restaurant->save();
        return response()->json(['success'=>'success','restaurant'=>$restaurant]);
    }
    public function view_reservation($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $cash_books = Cashbook::where('hotel_id',auth()->user()->hotel_id)->get();
        $setting = Hotel_reservation_setting::where('hotel_id',auth()->user()->hotel_id)->first();
        return view('management.reservation_setting',['hotel'=>$hotel,'cash_books'=>$cash_books,'setting'=>$setting]);
    }
    public function save_reservation_setting(Request $request){
        $cash_cashbook_id = $request->input('cash-cashbook-id');
        $card_cashbook_id = $request->input('card-cashbook-id');
        $advance_cashbook_id = $request->input('advance-cashbook-id');

        $setting = new Hotel_reservation_setting();
        $setting->hotel_id = auth()->user()->hotel_id;
        $setting->cash_payment  = $cash_cashbook_id;
        $setting->card_payment = $card_cashbook_id;
        $setting->advance_payment = $advance_cashbook_id;
        if ($image = $request->file('logo')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/Hotel/logo/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $setting->image = $path;
        }
        $setting->save();
        return redirect()->back()->with('success', 'Successfully Save Setting!');
    }
    public function get_reservation_setting(Request $request){
        $setting_id = $request->input('setting_id');
        $setting = Hotel_reservation_setting::find($setting_id);
        return response()->json(['success'=>'success','setting'=>$setting]);
    }
    public function edit_reservation_setting_save(Request $request){
        //return $request;
        $e_cash_cashbook_id = $request->input('e_cash-cashbook-id');
        $e_card_cashbook_id = $request->input('e_card-cashbook-id');
        $e_advance_cashbook_id = $request->input('e_advance-cashbook-id');
        $e_setting_id = $request->input('e_setting_id');

        $save_setting = Hotel_reservation_setting::find($e_setting_id);
        $save_setting->cash_payment = $e_cash_cashbook_id;
        $save_setting->card_payment = $e_card_cashbook_id;
        $save_setting->advance_payment = $e_advance_cashbook_id;

        if ($image = $request->file('e_image')) {
            Storage::delete($save_setting->image);
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/Hotel/logo/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $save_setting->image = $path;
        }
        $save_setting->save();
        return redirect()->back()->with('success', 'Successfully Edit Setting!');
    }
    public function view_expenses($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $cash_books = Cashbook::where('hotel_id',$hotel->id)->get();
        $expense_categories = Expense_category::with('expense_sub_category')->where('hotel_id',$hotel->id)->get();
        $assign_expense_cashbooks = Assign_expenses_cashbook::where('hotel_id',$hotel->id)->get();
        return view('management.expenses_setting',['hotel'=>$hotel,'cash_books'=>$cash_books,'expense_categories'=>$expense_categories,'assign_expense_cashbooks'=>$assign_expense_cashbooks]);
    }
    public function save_expenses_category(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $category_name = $request->input('category_name');

        $category = new Expense_category();
        $category->hotel_id = $hotel_id;
        $category->name = $category_name;
        $category->save();

        return response()->json(['success'=>'success','category'=>$category]);
    }
    public function save_expenses_sub_category(Request $request){
        $category_id = $request->input('v_category_id');
        $sub_category_name = $request->input('sub_category_name');

        $sub_category = new Expense_sub_category();
        $sub_category->name = $sub_category_name;
        $sub_category->expense_category_id = $category_id;
        $sub_category->save();
        return response()->json(['success'=>'success','sub_category'=>$sub_category]);
    }
    public function save_expenses_cashbooks(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $cash_book_ids = $request->input('cash_book_id');

        $hotel = Hotel::find($hotel_id);
        $hotel->cash_book()->sync($cash_book_ids);
        return response()->json(['success'=>'success']);
    }
    public function get_edit_category_details(Request $request){
        $category_id = $request->input('category_id');
        $category = Expense_category::find($category_id);
        return response()->json(['success'=>'success','category'=>$category]);
    }
    public function edit_category_save(Request $request){
        $category_id = $request->input('e_category_id');
        $category_name = $request->input('e_category_name');
        $category = Expense_category::find($category_id);
        $category->name = $category_name;
        $category->save();
        return response()->json(['success'=>'success','category'=>$category]);
    }
    public function add_sub_category_view(Request $request){
        $category_id = $request->input('category_id');
        $category = Expense_category::with('expense_sub_category')->where('id',$category_id)->first();
        return response()->json(['success'=>'success','category'=>$category]);
    }
    public function edit_sub_category_get_detail(Request $request){
        $sub_category_id = $request->input('sub_category_id');
        $sub_category = Expense_sub_category::find($sub_category_id);
        return response()->json(['success'=>'success','sub_category'=>$sub_category]);
    }
    public function edit_sub_category_save(Request $request){
        $sub_category_id = $request->input('e_sub_category_id');
        $sub_category_name= $request->input('e_sub_category_name');
        $sub_category = Expense_sub_category::find($sub_category_id);
        $sub_category->name = $sub_category_name;
        $sub_category->save();
        return response()->json(['success'=>'success','sub_category'=>$sub_category]);
    }


    public function view_housekeeping($id,Request $request){
        $layout_id= $request->input('layout_id');
//        return $layout_id.'-'.$id;
        $hotel = Hotel::with('hotel_chain')->find($id);
        $check_list_layout=Check_list_layout::find($layout_id);
        $item = Housekeeping::where('status',null)->where('check_list_layout_id',$layout_id)->get();

        return view('management.housekeeping',['hotel'=>$hotel,'item'=>$item , 'layout'=>$check_list_layout]);
    }

    public function view_housekeeping_layout($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
//        $item = Housekeeping::where('status',null)->where('hotel_id',$hotel->id)->get();
        $layout = Check_list_layout::where('hotel_id',$hotel->id)->get();

        $room = Room::with('room_category','check_list_layout')->where('status',null)->where('hotel_id',$hotel->id)->get();
        $other_location = Other_location::with('check_list_layout')->where('status',null)->where('hotel_id',$hotel->id)->get();

        return view('management.chechlist_layout',['hotel'=>$hotel,'layout'=>$layout, 'rooms'=>$room, 'other_locations'=>$other_location]);
    }

    public function assign_item_get(Request $request){
        $item_id = $request->input('item');
        $items = Housekeeping::select('id')->where('id',$item_id)->get();
        return response()->json(['menus'=>$items]);
    }

    public function housekeeping_save(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $layout_id = $request->input('layout_id_a');
        $item_name = $request->input('item_name');

        $housekeeping = new Housekeeping();
        $housekeeping->hotel_id = $hotel_id;
        $housekeeping->item_name = $item_name;
        $housekeeping->check_list_layout_id = $layout_id;

        $housekeeping->save();
        return response()->json(['success'=>'success','housekeeping'=>$housekeeping]);
    }

    public function housekeeping_layout_save(Request $request){
        $hotel_id = $request->input('hotel_id');
        $layout_name = $request->input('layout_name');

        $housekeeping_layout = new Check_list_layout();
        $housekeeping_layout->hotel_id = $hotel_id;
        $housekeeping_layout->name = $layout_name;
        $housekeeping_layout->save();

        $count = $request->input('count');
        for ($i = 1; $i <= $count; $i++) {

            if ($request->has('item_name-' . $i) && $request->input('item_name-' . $i) != '') {
                $item_name = $request->input('item_name-' . $i);

                $housekeeping_item = new Housekeeping();
                $housekeeping_item->hotel_id = $hotel_id;
                $housekeeping_item->check_list_layout_id = $housekeeping_layout->id;
                $housekeeping_item->item_name = $item_name;
                $housekeeping_item->save();
            }
        }

        return response()->json(['success'=>'success','housekeeping_layout'=>$housekeeping_layout]);
    }

    public function get_edit_checklist_details(Request $request){
        $item_id =  $request->input('item_id');

        $edit_item = Housekeeping::where('id',$item_id)->first();

        return response()->json(['success'=>'success','edit_item'=>$edit_item]);
    }

    public function edit_checklist_save(Request $request){
        $id = $request->input('e_item_id');
        $item_name = $request->input('e_item_name');

        $checklist = Housekeeping::find($id);
        $checklist->item_name = $item_name;
        $checklist->save();

        $get_item = Housekeeping::where('id',$checklist->id)->first();
        return response()->json(['success'=>'success','get_item'=>$get_item]);
    }

    public function edit_layout_name_save(Request $request){
        $id = $request->input('e_layout_id');
        $layout_name = $request->input('e_layout_name');

        $layout = Check_list_layout::find($id);
        $layout->name = $layout_name;
        $layout->save();

        return response()->json(['success'=>'success','get_layout'=>$layout]);
    }

    public function delete_item(Request $request){
        $item_id = $request->input('item_id');
        $delete_item = Housekeeping::find($item_id);
        $delete_item->status = 'Block';
        $delete_item->save();
        return response()->json(['success'=>'success']);
    }

    public function get_edit_location(Request $request){
        $location_id =  $request->input('location_id');
        $location_type =  $request->input('location_type');

        if ($location_type == 'room'){
            $edit_location = Room::where('id',$location_id)->first();
        }
        else{
            $edit_location = Other_location::where('id',$location_id)->first();
        }

        return response()->json(['success'=>'success','edit_location'=>$edit_location]);
    }

    public function location_edit_save(Request $request){
        $id = $request->input('e_location_id');
        $location_type = $request->input('e_location_type');
        $checkList_layout = $request->input('e_checkList_layout');

        if ($location_type == 'room'){
            $room = Room::find($id);
            $room->check_list_layout_id = $checkList_layout;
            $room->save();
            $get_location = Room::with('room_category','check_list_layout')->where('id',$room->id)->first();
            $location = 'room';
        }
        else{
            $location = Other_location::find($id);
            $location->check_list_layout_id = $checkList_layout;
            $location->save();
            $get_location = Other_location::with('check_list_layout')->where('id',$location->id)->first();
            $location = 'other';
        }

        return response()->json(['success'=>'success','get_location'=>$get_location,'location'=>$location]);
    }

    public function view_rooms($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $room = Room::with('room_category','check_list_layout','room_repairs')->where('status',null)->where('hotel_id',$hotel->id)->get();
        $room_category = Room_category::with(['room'=>function ($query){$query->where('status',null);}])->where('status','Active')->where('hotel_id',$hotel->id)->get();
        $checkList_layout = Check_list_layout::get();
//        return $room_category;
        return view('management.room',['hotel'=>$hotel,'rooms'=>$room,'room_categories'=>$room_category,'checkList_layout'=>$checkList_layout]);
    }

    public function view_rooms_prices($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $room_category = Room_category::where('hotel_id',$hotel->id)->get();
        $price_categories = Price_category::with('Room_category', 'Hotel')->where('hotel_id', $id)->get()->groupBy('room_category.category');

        $checkList_layout = Check_list_layout::get();
//        return $price_categories;
        return view('management.room_price',['hotel'=>$hotel,'room_categories'=>$room_category,'checkList_layout'=>$checkList_layout,'price_categories'=>$price_categories]);
    }

    public function other_location($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $other_location = Other_location::with('check_list_layout')->where('status',null)->where('hotel_id',$hotel->id)->get();
        $checkList_layout = Check_list_layout::get();
//        return $other_location;
        return view('management.other_location',['hotel'=>$hotel,'other_location'=>$other_location,'checkList_layout'=>$checkList_layout]);
    }

    public function room_save(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $room_number = $request->input('room_number');
        $room_type = $request->input('room_type');
        $room_category = $request->input('room_category');
        $checkList_layout = $request->input('checkList_layout');
        $reapair = $request->input('repair_status');

        $start = $request->input('a_start_date');
        $end = $request->input('a_end_date');
        $start_date = Carbon::parse($start)->format('Y-m-d');
        $end_date = Carbon::parse($end)->format('Y-m-d');
        \Illuminate\Support\Facades\Log::info('w1'. $reapair);
        $room = new Room();
        $room->hotel_id = $hotel_id;
        $room->room_number = $room_number;
        $room->room_type = $room_type;
        $room->room_category_id = $room_category;
        $room->check_list_layout_id = $checkList_layout;




        $room->reapair = $reapair;

        $room->save();
      if( $reapair=='repair'){
        $roomRepair = new Room_rapair;
        $roomRepair->room_id = $room->id;
        $roomRepair->status = $reapair;
        $roomRepair->start_date = $start_date;
        $roomRepair->end_date = $end_date;
        $roomRepair->save();

      }
        $room1 = Room::with('room_category','check_list_layout')->find($room->id);
        return response()->json(['success'=>'success','rooms'=>$room1]);
    }


    public function add_price_category_save(Request $request){

//        return $request;

        $category_id = $request->input('e_category_id');
        $start = $request->input('check_in_date');
        $end = $request->input('check_out_date');
        $price = $request->input('e_b_rooms_count');

        $price_category = new Price_category();
        $price_category->room_category_id = $category_id;
        $price_category->hotel_id = auth()->user()->hotel_id;
        $price_category->start_date = $start;
        $price_category->end_date = $end;
        $price_category->price = $price;

//        return $price_category;

        $price_category->save();
        return redirect()->back()->with('success', 'Successfully saving!');

    }


    public function getEditPriceCategoryDetails(Request $request){
        $price_category_Id = $request->input('room_id');
        $edit_price_category = Price_category::find($price_category_Id);
        return response()->json(['edit_price_category' => $edit_price_category]);
    }


    public function edit_price_category_save(Request $request){

//        return $request;

        $category_id = $request->input('p_category_id');
        $start = $request->input('check_in_date');
        $end = $request->input('check_out_date');
        $price = $request->input('e_b_rooms_count');

        $price_category = Price_category::find($category_id);
        $price_category->start_date = $start;
        $price_category->end_date = $end;
        $price_category->price = $price;

//        return $price_category;

        $price_category->save();
        return redirect()->back()->with('success', 'Successfully saving!');

    }


    public function deletePriceCategoryDetails(Request $request){

//        return $request;

        $category_id = $request->input('room_id');

        $price_category = Price_category::find($category_id);

//        return $price_category;

        $price_category->delete();
        return response()->json(['success', 'Successfully saving!']);

    }




    public function other_location_save(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $location_name = $request->input('location_name');
        $category = $request->input('category');
        $checkList_layout = $request->input('a_checkList_layout');
        $duration = $request->input('duration');
        $frequency = $request->input('frequency');

        $other_location = new Other_location();
        $other_location->hotel_id = $hotel_id;
        $other_location->name = $location_name;
        $other_location->category = $category;
        $other_location->check_list_layout_id = $checkList_layout;
        $other_location->duration = $duration;
        $other_location->frequency = $frequency;

        $other_location->save();
        $location = Other_location::with('check_list_layout')->find($other_location->id);
        return response()->json(['success'=>'success','location'=>$location]);
    }

    public function get_edit_room_details(Request $request){
        $room_id =  $request->input('room_id');

        $edit_room = Room::where('id',$room_id)->first();

        return response()->json(['success'=>'success','edit_room'=>$edit_room]);
    }

    public function other_location_get_edit_details(Request $request){
        $location_id =  $request->input('location_id');

        $edit_location = Other_location::where('id',$location_id)->first();

        return response()->json(['success'=>'success','edit_location'=>$edit_location]);
    }

    public function edit_room_save(Request $request){
        $id = $request->input('e_room_id');
        $room_number = $request->input('e_room_number');
        $room_type = $request->input('e_room_type');
        $room_category = $request->input('e_room_category');
        $checkList_layout = $request->input('e_checkList_layout');
        $room_rapeir = $request->input('e_repair_status');

        $room = Room::find($id);
        $room->room_number = $room_number;
        $room->room_type = $room_type;
        $room->room_category_id = $room_category;
        $room->check_list_layout_id = $checkList_layout;
        $room->reapair = $room_rapeir;
        $room->save();



        $get_room = Room::with('room_category','check_list_layout')->where('id',$room->id)->first();
        return response()->json(['success'=>'success','get_room'=>$get_room]);
    }

    public function other_location_edit_save(Request $request){
        $id = $request->input('e_location_id');
        $name = $request->input('e_name');
        $category = $request->input('e_category');
        $checkList_layout = $request->input('e_checkList_layout');
        $duration = $request->input('e_duration');
        $frequency = $request->input('e_frequency');

        $location = Other_location::find($id);
        $location->name = $name;
        $location->category = $category;
        $location->check_list_layout_id = $checkList_layout;
        $location->duration = $duration;
        $location->frequency = $frequency;
        $location->save();

        $get_location = Other_location::with('check_list_layout')->where('id',$location->id)->first();
        return response()->json(['success'=>'success','get_location'=>$get_location]);
    }

    public function delete_room(Request $request){
        $room_id = $request->input('room_id');
        $delete_room = Room::find($room_id);
        $delete_room->status = 'Block';
        $delete_room->save();
        return response()->json(['success'=>'success']);
    }

    public function other_location_delete(Request $request){
        $location_id = $request->input('location_id');
        $delete_location = Other_location::find($location_id);
        $delete_location->status = 'Block';
        $delete_location->save();
        return response()->json(['success'=>'success']);
    }

    public function save_room_category(Request $request){

        $hotel_id = $request->input('room_hotel_id');
        $category_type = $request->input('room_type');
        $category_name = $request->input('room_name');
        $custom_name = $request->input('custom_name');
        $smoke = $request->input('smoke');
        $room_count = $request->input('room_count');
        $bed_room_count = $request->input('bed_count');
        $living_room_count = $request->input('living_count');
        $bathroom_count = $request->input('b_rooms_count');
        $price = $request->input('price');
        $note = $request->input('note');

        $room_category = new Room_category();
        $room_category->hotel_id = $hotel_id;
        $room_category->category = $category_name;
        $room_category->status = 'Active';
        $room_category->room_count = $room_count;
        $room_category->num_of_bed = $bed_room_count;
        $room_category->num_of_living_rooms = $living_room_count;
        $room_category->num_of_bathroom = $bathroom_count;
        $room_category->smoking_policy = $smoke;
        $room_category->custome_name = $custom_name;
        $room_category->room_type = $category_type;
        $room_category->price = $price;
        $room_category->note = $note;

        if ($image = $request->file('image')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/Hotel/Rooms/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $room_category->image = $path;
        }
        $room_category->save();

        return response()->json(['success'=>'success','room_category'=>$room_category]);

//        return redirect()->back()->with('success');
    }

    public function get_room_category_edit_details(Request $request){
        $room_id = $request->input('room_id');
        $room_category = Room_category::find($room_id);
        return response()->json(['success'=>'success','room_category'=>$room_category]);
    }

    public function edit_room_category_save(Request $request){
        //return $request;
        $category_id = $request->input('e_category_id');
        $category_type = $request->input('ec_room_type');
        $category_name = $request->input('e_room_name');
        $custom_name = $request->input('e_custom_name');
        $smoke = $request->input('e_smoke');
        $room_count = $request->input('e_room_count');
        $bed_room_count = $request->input('e_bed_count');
        $living_room_count = $request->input('e_living_count');
        $bathroom_count = $request->input('e_b_rooms_count');
        $price = $request->input('e_price');
        $note = $request->input('e_note');

        $room_category= Room_category::find($category_id);
        $room_category->category = $category_name;
        $room_category->room_count = $room_count;
        $room_category->num_of_bed = $bed_room_count;
        $room_category->num_of_living_rooms = $living_room_count;
        $room_category->num_of_bathroom = $bathroom_count;
        $room_category->smoking_policy = $smoke;
        $room_category->custome_name = $custom_name;
        $room_category->room_type = $category_type;
        $room_category->price = $price;
        $room_category->note = $note;

        if ($image = $request->file('e_image')) {
            Storage::delete($room_category->image);
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/Hotel/Rooms/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $room_category->image = $path;
        }
        $room_category->save();

        return redirect()->back()->with('success');
    }


















//    public function checkRoomAvailable(Request $request){
//        $startDate = $request->input('start_date');
//        $endDate = $request->input('end_date');





//        $roomsWithBookings = Room::whereHas('booking', function ($query) use ($startDate, $endDate) {
//            $query->whereBetween('checking_date', [$startDate, $endDate])
//                ->orWhereBetween('checkout_date', [$startDate, $endDate])
//                ->orWhere(function ($innerQuery) use ($startDate, $endDate) {
//                    $innerQuery->where('checking_date', '<', $startDate)
//                        ->where('checkout_date', '>', $endDate);
//                });
//        })->get();
//        return response()->json(['success'=>'success','has_bookings'=> $roomsWithBookings]);
//
//
//
//    }

    public function checkRoomAvailable(Request $request)
    {
        $roomId = $request->input('room_id');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $startDate = Carbon::parse($start)->format('Y-m-d');
        $endDate = Carbon::parse($end)->format('Y-m-d');

        \Illuminate\Support\Facades\Log::info('Start Date: ' . $startDate);
        \Illuminate\Support\Facades\Log::info('End Date: ' . $endDate);
        \Illuminate\Support\Facades\Log::info('Room ID: ' . $roomId);

        $roomsWithBookings = Room::where('id', $roomId)
            ->whereHas('bookings', function ($query) use ($startDate, $endDate) {
                $query->where(function ($innerQuery) use ($startDate, $endDate) {
                    $innerQuery->where('checking_date', '<=', $endDate)
                        ->where('checkout_date', '>=', $startDate);
                })->orWhere(function ($innerQuery) use ($startDate, $endDate) {
                    $innerQuery->where('checking_date', '>=', $startDate)
                        ->where('checking_date', '<', $endDate);
                })->orWhere(function ($innerQuery) use ($startDate, $endDate) {
                    $innerQuery->where('checkout_date', '>', $startDate)
                        ->where('checkout_date', '<=', $endDate);
                });
            })
            ->get();

        if ($roomsWithBookings->isEmpty()) {
            $room_repair = new Room_rapair();
            $room_repair->room_id = $roomId;
            $room_repair->start_date = $startDate;
            $room_repair->end_date = $endDate;
            $room_repair->status = 'repair';
            $room_repair->save();
            $room = Room::findOrFail($roomId); // Find the room by ID
            $room->reapair = 'repair'; // Adjust status as needed
            $room->save();
        }


        \Illuminate\Support\Facades\Log::info('Rooms with Bookings: ' . json_encode($roomsWithBookings));
        return response()->json(['success' => 'success', 'has_bookings' => !$roomsWithBookings->isEmpty()]);
    }

    public function room_rapair_complete(Request $request){
        $roomId = $request->input('edit-r-id-input');
        $end_date = $request->input('edit-r-date-input');
        $roomRepair = Room_rapair::find($roomId);

        \Illuminate\Support\Facades\Log::info('Rooms with repair : ' . ($end_date));

        $roomRepair->end_date = $end_date;
        $roomRepair->save();


    }











    public function view_maintenance($id){
        $hotel = Hotel::with('hotel_chain')->find($id);

        $maintenance = Maintenance::with('user')->where('hotel_id', auth()->user()->hotel_id)->get();
        $repair_location = Other_location::where('hotel_id',$hotel->id)->get();
        $repair_category = Repair_category::where('hotel_id',$hotel->id)->where('status', null)->get();
        $repair_status = Repair_status::where('hotel_id',$hotel->id)->where('status', null)->get();
        $room = Room::where('hotel_id',$hotel->id)->get();
//        return $room_category;
        return view('management.maintenance',['hotel'=>$hotel , 'repair_category'=>$repair_category , 'maintenance'=>$maintenance , 'repair_location'=>$repair_location , 'repair_status'=>$repair_status , 'rooms'=>$room]);
    }



    public function save_repair_category(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $repair_category_name = $request->input('repair_category_name');

        $repair_category = new Repair_category();
        $repair_category->hotel_id = $hotel_id;
        $repair_category->repair_category_name = $repair_category_name;

        $repair_category->save();
        return response()->json(['success'=>'success','repair_category'=>$repair_category]);

    }

    public function get_edit_repair_category_details(Request $request){
        $item_id =  $request->input('item_id');

        $edit_item = Repair_category::where('id',$item_id)->first();

        return response()->json(['success'=>'success','edit_item'=>$edit_item]);
    }

    public function edit_repair_category_save(Request $request){
        $id = $request->input('e_item_id');
        $repair_category_name = $request->input('repair_category_name');

        $repair_category = Repair_category::find($id);
        $repair_category->repair_category_name = $repair_category_name;
        $repair_category->save();

        $get_item = Repair_category::where('id',$repair_category->id)->first();
        return response()->json(['success'=>'success','get_item'=>$get_item]);
    }

    public function delete_repair_category(Request $request){
        $item_id = $request->input('item_id');
        $delete_item = Repair_category::find($item_id);


        $delete_item->status = 'Block';
        $delete_item->save();

        return response()->json(['success'=>'success']);
    }





    public function save_repair_status(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $repair_status_name = $request->input('repair_status_name');

        $repair_status = new Repair_status();
        $repair_status->hotel_id = $hotel_id;
        $repair_status->repair_status_name = $repair_status_name;

        $repair_status->save();
        return response()->json(['success'=>'success','repair_status'=>$repair_status]);

    }

    public function get_edit_repair_status_details(Request $request){
        $item_id3 =  $request->input('item_id3');

        $edit_item_s = Repair_status::where('id',$item_id3)->first();

        return response()->json(['success'=>'success','edit_item_s'=>$edit_item_s]);
    }

    public function edit_repair_status_save(Request $request){
        $id = $request->input('e_item_id3');
        $repair_status_name = $request->input('repair_status_name');

        $repair_status = Repair_status::find($id);
        $repair_status->repair_status_name = $repair_status_name;
        $repair_status->save();

        $get_item_s = Repair_status::where('id',$repair_status->id)->first();
        return response()->json(['success'=>'success','get_item_s'=>$get_item_s]);
    }

    public function delete_repair_status(Request $request){
        $item_id3 = $request->input('item_id3');
        $delete_item_s = Repair_status::find($item_id3);
        $delete_item_s->status = 'Block';
        $delete_item_s->save();
        return response()->json(['success'=>'success']);
    }


    public function view_utility($id){
        $hotel = Hotel::with('hotel_chain')->find($id);

        $utility = Utility::with('user')->where('hotel_id', auth()->user()->hotel_id)->get();

        $utility_category = Utility_category::where('hotel_id',$hotel->id)->where('status', 'Active')->get();

//        return $room_category;
        return view('management.utility',['hotel'=>$hotel , 'utility_category'=>$utility_category , 'utility'=>$utility ]);
    }

    public function save_utility_category(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $utility_category_name = $request->input('a_utility_category_name');
        $difference = $request->input('difference');
        $average = $request->input('average');
        $decimal_point = $request->input('decimal_point');
        $guests = $request->input('guests');
        $unit_price = $request->input('a_utility_category_unit_price');
        $range_date = $request->input('range_date');
        $monthly_charj= $request->input('a_utility_category_monthly_charj');


        $utility_category = new Utility_category();
        $utility_category->hotel_id = $hotel_id;
        $utility_category->utility_category_name = $utility_category_name;
        $utility_category->status ='Active';
        $utility_category->unit_price =$unit_price;
        $utility_category->range_date =$range_date;
        $utility_category->monthly_charj=$monthly_charj;

        if ($difference=="yes") {
            $utility_category->difference = 'Yes';
        }
        else{
            $utility_category->difference = 'No';
            $utility_category->average = 'No';
        }

        if ($difference=="yes") {
            if ($average=="yes") {
                $utility_category->average = 'Yes';
            }
            else{
                $utility_category->average = 'No';
            }
        }

        $utility_category->point = $decimal_point;
        $utility_category->guest = $guests;
        $utility_category->save();
        return response()->json(['success'=>'success','utility_category'=>$utility_category]);

    }

    public function get_edit_utility_category_details(Request $request){
        $item_id =  $request->input('item_id');

        $edit_item = Utility_category::where('id',$item_id)->first();

        return response()->json(['success'=>'success','edit_item'=>$edit_item]);
    }

    public function edit_utility_category_save(Request $request){
        $id = $request->input('e_item_id');
        $utility_category_name = $request->input('edit_utility_category_name');
        $difference = $request->input('e_difference');
        $average = $request->input('e_average');
        $decimal_point = $request->input('e_decimal_point');
        $guests = $request->input('e_guests');
        $unit_price = $request->input('e_utility_category_unit_price');
        $range_date = $request->input('edit_range_date');
        $monthly_charj= $request->input('e_utility_category_monthly_charj');

        $utility_category = Utility_category::find($id);
        $utility_category->utility_category_name = $utility_category_name;
        $utility_category->unit_price =$unit_price;
        $utility_category->range_date =$range_date;
        $utility_category->monthly_charj = $monthly_charj;
        if ($difference=="yes") {
            $utility_category->difference = 'Yes';
        }
        else{
            $utility_category->difference = 'No';
            $utility_category->average = 'No';
        }

        if ($difference=="yes") {
            if ($average=="yes") {
                $utility_category->average = 'Yes';
            }
            else{
                $utility_category->average = 'No';
            }
        }

        $utility_category->point = $decimal_point;
        $utility_category->guest = $guests;
        $utility_category->save();

        $get_item = Utility_category::where('id',$utility_category->id)->first();
        return response()->json(['success'=>'success','get_item'=>$get_item]);
    }

    public function delete_utility_category(Request $request){
        $item_id = $request->input('item_id');
        $delete_item = Utility_category::find($item_id);

        $utility = Utility::where('u_category_id',$item_id)->count();
        if ($utility != 0) {
            return response()->json(['error'=>$utility]);
        }
        else{
            $delete_item->status = 'Block';
            $delete_item->save();

            return response()->json(['success'=>'success']);
        }

    }



//    public function view_job_position($id){
//        $hotel = Hotel::with('hotel_chain')->find($id);
//
//        $jobapplications = Job_application_detail::where('hotel_id', auth()->user()->hotel_id)->get()->find($id);
//
//
////        return $room_category;
//        return view('management.add_job_position',['hotel'=>$hotel , 'jobapplications'=>$jobapplications]);
//    }

    public function view_job_position($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $jobapplication = Job_application_detail::where('hotel_id', auth()->user()->hotel_id)->get()->find($id);
        $job_position_category = Job_position_category::where('hotel_id',$hotel->id)->where('status', null)->get();
//        return $room_category;
        return view('management.add_job_position',['hotel'=>$hotel , 'jobapplication' => $jobapplication , 'job_position_category' => $job_position_category]);
  }


    public function save_job_position_category(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $job_position_category_name = $request->input('job_position_category_name');

        $job_position_category = new Job_position_category();
        $job_position_category->hotel_id = $hotel_id;
        $job_position_category->job_position_category_name = $job_position_category_name;

        $job_position_category->save();
        return response()->json(['success'=>'success','job_position_category'=>$job_position_category]);

    }

    public function get_edit_job_position_category_details(Request $request){
        $item_id =  $request->input('item_id');

        $edit_item = Job_position_category::where('id',$item_id)->first();

        return response()->json(['success'=>'success','edit_item'=>$edit_item]);
    }

    public function edit_job_position_category_save(Request $request) {
        $id = $request->input('e_item_id');
        $job_position_category_name = $request->input('edit_job_position_category_name');

        $job_position_category = Job_position_category::find($id);
        if (!$job_position_category) {
            return response()->json(['error' => 'Category not found.']);
        }

        $job_position_category->job_position_category_name = $job_position_category_name;
        $job_position_category->save();

        return response()->json(['success' => 'success', 'get_item' => $job_position_category]);
    }


    public function delete_job_position_category(Request $request){
        $item_id = $request->input('item_id');
        $delete_item = Job_position_category::find($item_id);


        $delete_item->status = 'Block';
        $delete_item->save();

        return response()->json(['success'=>'success']);
    }

    public function view_stock($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $item_categories = Item_category::where('hotel_id',$hotel->id)->get();
        return view('management.stock',['hotel'=>$hotel,'item_categories'=>$item_categories]);
    }

    public function stock_category_save(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $category = $request->input('category');

        $item_categories = new Item_category();
        $item_categories->hotel_id = $hotel_id;
        $item_categories->item_category_name = $category;
        $item_categories->status = 'active';

        $item_categories->save();
        //$categories = Item_category::with('check_list_layout')->find($other_location->id);
        return response()->json(['success'=>'success','item_categories'=>$item_categories]);
    }

    public function stock_category_get_edit_details(Request $request){
        $categoryid =  $request->input('categoryid');

        $edit_category = Item_category::where('id',$categoryid)->first();

        return response()->json(['success'=>'success','edit_category'=>$edit_category]);
    }

    public function stock_category_edit_save(Request $request){
        $id = $request->input('e_category_id');
        $category = $request->input('e_category');

        $item_categories = Item_category::find($id);
        $item_categories->item_category_name = $category;
        $item_categories->save();
        return response()->json(['success'=>'success','item_categories'=>$item_categories]);
    }

    public function stock_category_delete(Request $request){
        $categoryid =  $request->input('categoryid');
        $item_category = Item_category::find($categoryid);
        $check_avalability = Item_category_detail::where('item_category_id',$categoryid)->count();
        if($check_avalability>0){
            return response()->json(['error'=>'This Stock Category Item Used Stock']);
        }else{
            $item_category->delete();
            return response()->json(['success'=>'success']);
        }
    }

    public function view_table($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $tables = Table::where('hotel_id',$hotel->id)->where('status', null)->get();
        return view('management.table',['hotel'=>$hotel,'tables'=>$tables]);
    }

    public function table_save(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $table_name = $request->input('table_name');
        $nu_of_chairs = $request->input('nu_of_chairs');
        $area = $request->input('area');

        $table = new Table();
        $table->hotel_id = $hotel_id;
        $table->table_name = $table_name;
        $table->nu_of_chairs = $nu_of_chairs;
        $table->area = $area;

        $table->save();
        return response()->json(['success'=>'success','table'=>$table]);
    }

    public function table_get_edit_details(Request $request){
        $table_id =  $request->input('table_id');

        $table = Table::where('id',$table_id)->first();

        return response()->json(['success'=>'success','edit_table'=>$table]);
    }

    public function table_edit_save(Request $request){
        $id = $request->input('e_table_id');
        $table_name = $request->input('e_table_name');
        $nu_of_chairs = $request->input('e_nu_of_chairs');
        $area = $request->input('e_area');

        $table = Table::find($id);
        $table->table_name = $table_name;
        $table->nu_of_chairs = $nu_of_chairs;
        $table->area = $area;
        $table->save();

        return response()->json(['success'=>'success','table'=>$table]);
    }

    public function view_Janitorial($id,Request $request){
        $layout_id= $request->input('layout_id');
//        return $layout_id.'-'.$id;
        $hotel = Hotel::with('hotel_chain')->find($id);
        $check_list_layout=Check_list_layout::find($layout_id);
        $item_category_details =Item_category_detail::with('item','item_category')->where('item_category_id',11)->get();
        $janitorial_items = Janitorial_item::with('item','check_list_layouts')->where('status', null)->where('check_list_layout_id', $layout_id)->get();

        return view('management.view_Janitorial',['hotel'=>$hotel,'item_category_details'=>$item_category_details , 'layout'=>$check_list_layout , 'janitorial_items'=>$janitorial_items]);
    }

    public function save_janitorial_items(Request $request){

        $check_list_layout_id = $request->input('layout_id_a');

        $item_ids = [];

        $count = $request->input('count');
        for ($i = 1;$i<=$count;$i++) {
            if($request->has('item-' . $i) && $request->has('Quantity-' . $i)){
                $item = $request->input('item-' . $i);
                $quantity = $request->input('Quantity-' . $i);
                if($item != "" && $quantity != ""){
                    $janitorial_items = new Janitorial_item();
                    $janitorial_items->check_list_layout_id	 = $check_list_layout_id;
                    $janitorial_items->item_id = $item;
                    $janitorial_items->quantity = $quantity;
                    $janitorial_items->save();

                    array_push($item_ids,[$janitorial_items->id]) ;

                }
            }
        }
//return $item_ids;

        $item_category_details =Item_category_detail::with('item','item_category')->where('item_category_id',11)->get();
        $janitorial_items_all = Janitorial_item::with('item','check_list_layouts')->whereIn('id',$item_ids)->get();

        return response()->json(['success'=>'success','item_category_details'=>$item_category_details, 'janitorial_items'=>$janitorial_items_all]);
//        return redirect()->back()->with('success');
    }

    public function get_edit_janitorial_item_details(Request $request){
        $item_id =  $request->input('item_id');

//        return $item_id;

        $edit_item = Janitorial_item::with('item','check_list_layouts')->where('id',$item_id)->first();

        return response()->json(['success'=>'success','edit_item'=>$edit_item]);
    }

    public function edit_janitorial_item(Request $request){
        $id = $request->input('e_item_id');
        $quantity = $request->input('e_quantity');

        $janitorial_item = Janitorial_item::find($id);
        $janitorial_item->quantity = $quantity;
        $janitorial_item->save();

        $edit_item = Janitorial_item::with('item','check_list_layouts')->where('id',$id)->first();

        return response()->json(['success'=>'success','get_item'=>$edit_item]);
    }

    public function delete_janitorial_item(Request $request){
        $item_id = $request->input('item_id');
        $janitorial_item = Janitorial_item::find($item_id);
        $janitorial_item->status = 'Block';
        $janitorial_item->save();
        return response()->json(['success'=>'success']);
    }

    public function view_refilling($id,Request $request){
        $layout_id= $request->input('layout_id');
//        return $layout_id.'-'.$id;
        $hotel = Hotel::with('hotel_chain')->find($id);
        $check_list_layout=Check_list_layout::find($layout_id);
        $item_category_details =Item_category_detail::with('item','item_category')->where('item_category_id',11)->get();
        $refilling_items = Refilling_item::with('item','check_list_layouts')->where('status', null)->where('check_list_layout_id', $layout_id)->get();

        return view('management.refilling',['hotel'=>$hotel,'item_category_details'=>$item_category_details , 'layout'=>$check_list_layout , 'refilling_items'=>$refilling_items]);
    }

    public function refilling_save(Request $request){
        $hotel_id = $request->input('hotel_id_a');
        $layout_id = $request->input('layout_id_a');
        $item_id = $request->input('item_name');

        $refilling_items = new Refilling_item();
        $refilling_items->check_list_layout_id	 = $layout_id;
        $refilling_items->item_id = $item_id;
        $refilling_items->save();

        $refilling_items_get = Refilling_item::with('item','check_list_layouts')->where('id', $refilling_items->id)->first();
        return response()->json(['success'=>'success','refilling_items'=>$refilling_items_get]);
    }

    public function delete_refilling_item(Request $request){
        $item_id = $request->input('item_id');
        $refilling_items = Refilling_item::find($item_id);
        $refilling_items->status = 'Block';
        $refilling_items->save();
        return response()->json(['success'=>'success']);
    }

    public function other_income($id){
        $hotel = Hotel::with('hotel_chain')->find($id);
        $other_income_category_lists=Other_income_category_list::where('status',null)->get();
        //$item_category_details =Item_category_detail::with('item','item_category')->where('item_category_id',11)->get();
        //$janitorial_items = Janitorial_item::with('item','check_list_layouts')->where('status', null)->where('check_list_layout_id', $layout_id)->get();

        return view('management.other_income',['hotel'=>$hotel,'other_income_category_lists'=>$other_income_category_lists]);
    }

    public function save_other_income_category(Request $request){

        $other_income_name = $request->input('other_income_name');

        $other_income_category_list = new Other_income_category_list();
        $other_income_category_list->category_name = $other_income_name;
        $other_income_category_list->hotel_id = auth()->user()->hotel_id;
        $other_income_category_list->save();

        return response()->json(['success'=>'success','other_income_category_list'=>$other_income_category_list]);
//        return redirect()->back()->with('success');
    }

    public function get_edit_other_income_details(Request $request){
        $other_income_id =  $request->input('otherIncomeid');

        $other_income_category_list = Other_income_category_list::where('id',$other_income_id)->first();

        return response()->json(['success'=>'success','other_income_category_list'=>$other_income_category_list]);
    }

    public function edit_other_income_category(Request $request){
        $id = $request->input('e_other_income_id');
        $other_income_name = $request->input('edit_other_income_name');

        $other_income_category_list = Other_income_category_list::find($id);
        $other_income_category_list->category_name = $other_income_name;
        $other_income_category_list->save();


        return response()->json(['success'=>'success','other_income_category_list'=>$other_income_category_list]);
    }

    public function delete_other_income(Request $request){
        $other_income_id =  $request->input('otherIncomeid');

        $other_income_category_list = Other_income_category_list::find($other_income_id);
        $other_income_category_list->status = 'Block';
        $other_income_category_list->save();
        return response()->json(['success'=>'success']);
    }

    public function customer_view($id){
        $hotel = Hotel::with('hotel_chain')->find($id);


        return view('hotel.customer',['hotel'=>$hotel]);
    }




    public function assign_cash_update(Request $request){

        $other_income_cash_book_id =  $request->input('assign_cash_book_id');
        $other_income_cheque_book_id =  $request->input('assign_cheque_book_id');
        $other_income_card_book_id =  $request->input('assign_card_book_id');

        $chequeCashBook = Other_income_payment_cash_book::where('type','cheque')->first();
        $cashCashsBook = Other_income_payment_cash_book::where('type','cash')->first();
        $cardCashBook = Other_income_payment_cash_book::where('type','card')->first();

        if ($chequeCashBook) {
            $chequeCashBook->cash_book_id = $other_income_cheque_book_id;
            $chequeCashBook->save();
        }

        if ($cashCashsBook) {
            $cashCashsBook->cash_book_id = $other_income_cash_book_id;
            $cashCashsBook->save();
        }

        if ($cardCashBook) {
            $cardCashBook->cash_book_id = $other_income_card_book_id;
            $cardCashBook->save();
        }
    }

    public function  other_income_cashbook (Request $request){
        $cashBookId = $request->input('add_cash_book_id');
        $cashBookName = $request->input('add_cash_book_name');

        $other_income_cash = new Other_income_payment_cash_book();
        $other_income_cash->cash_book_id = $cashBookId;
        $other_income_cash->type = $cashBookName;
        $other_income_cash->save();


    }







}


