<?php

namespace App\Http\Controllers;

use App\AgencyOrGuide;
use App\Booking_room;
use App\Combo;
use App\Combo_item;
use App\Goods_received_note;
use App\Goods_received_note_detail;
use App\Hotel;
use App\Item;
use App\Item_category;
use App\Item_category_detail;
use App\LogActivity;
use App\Mail\AgencyGuide_login_mail;
use App\Menu;
use App\Menu_category_detail;
use App\Recipe;
use App\Recipe_category;
use App\Recipe_category_detail;
use App\Recipe_item;
use App\Recipe_note;
use App\Recipe_note_detail;
use App\Room;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('isHotel');
    }
    public function index(){
        return redirect()->route('management/add_hotel_view');
    }
    public function view_items(){
         $get_items = Item::with('item_category')->where('hotel_id',auth()->user()->hotel_id)->get();
        return view('hotel.stock',['get_items'=>$get_items, 'section' => 'All']);
    }
    public function view_items_category($id){

//        $item_category = Item_category::select('item_category_name')->where('id',$id)->first();
        $item_ids = Item_category_detail::select('item_id')->where('item_category_id' , $id)->get()->pluck('item_id');
        $get_items = Item::where('hotel_id',auth()->user()->hotel_id)->whereIn('id' , $item_ids)->get();
        return view('hotel.stock',['get_items'=>$get_items,'category'=>$id, 'section' => 'notAll']);
    }
    public function save_item(Request $request){
        $unit =  $request->input('unit');
        $item =  $request->input('item');
        $item_save = new Item();
        $item_save->unit = $unit;
        $item_save->hotel_id = auth()->user()->hotel_id;
        $item_save->item =$item;
        $item_save->quantity = 0;
        $item_save->unit_price = $request->input('unit_price') != null ? $request->input('unit_price') : 0;
        $item_save->unit_price = number_format((float)$item_save->unit_price, 2, '.', '');
        $item_save->save();


        $categories_ids = $request->input('categories');
        $category_item = Item::find($item_save->id);
        $category_item->item_category()->sync($categories_ids);

        $category =Item_category_detail::with('item_category')->where('item_id',$item_save->id)->get();

        return response()->json(['item_save'=>$item_save,'category' => $category]);

    }
    public function item_history(Request $request){
        $item_id= $request->input('item_id');
        $get_item = Item::find($item_id);
        $log_details = LogActivity::with('user')->where('item_id',$item_id)->get();
        $output = view('hotel.render_for_ajax.stock_history_list', ['log_details' => $log_details,'item'=>$get_item])->render();
        return response()->json(['txt'=>$output,'item'=>$get_item]);
    }
    public function get_item_deatils(Request $request){
        $item_id= $request->input('item_id');
        $get_item_details = Item::find($item_id);
        $category =Item_category_detail::where('item_id',$get_item_details->id)->get();

        return response()->json(['get_item_details'=>$get_item_details,'category'=>$category]);
    }
    public function edit_item_save(Request $request){
        $item_id= $request->input('item_id');
        $item= $request->input('item');
        $unit= $request->input('unit');

        $get_item_details = Item::find($item_id);
        $get_item_details->unit=$unit;
        $get_item_details->item=$item;
        $get_item_details->unit_price = $request->input('unit_price') != null ? $request->input('unit_price') : 0;
        $get_item_details->unit_price = number_format((float)$get_item_details->unit_price, 2, '.', '');
        $get_item_details->save();

        $categories_ids = $request->input('categories_edit');
        $category_item = Item::find($get_item_details->id);
        $category_item->item_category()->sync($categories_ids);

        $category =Item_category_detail::with('item_category')->where('item_id',$get_item_details->id)->get();

        return response()->json(['get_item_details'=>$get_item_details,'category' => $category] );
    }
    public function stock_item_delete(Request $request){
        $item_id= $request->input('item_id');
        $stock_items = Item::find($item_id);
        $check_avalability = Goods_received_note_detail::where('item_id',$item_id)->count();
        if($check_avalability>0){
            return response()->json(['error'=>'This Stock Item Used GRN']);
        }else{
            $stock_items->delete();
            $item_category = Item_category_detail::where('item_id',$item_id)->delete();
            return response()->json(['success'=>'success']);
        }
    }
    public function view_recipe_details(){
        $recipes  = Recipe::where('hotel_id',auth()->user()->hotel_id)->get();
        $items =Item::where('hotel_id',auth()->user()->hotel_id)->get();
        return view('hotel.recipe',['recipes'=>$recipes,'items'=>$items]);
    }
    public function get_recipe_details(Request $request){
        $recipe_id= $request->input('recipe_id');
        $recipe = Recipe::with('recipe_item.item')->where('id',$recipe_id)->first();
        $categories = Recipe_category_detail::with('recipe_category')->where('recipe_note_id',$recipe_id)->get();
        $items =Item::where('hotel_id',auth()->user()->hotel_id)->get();
        return response()->json(['recipe'=>$recipe,'items'=>$items,'categories'=>$categories]);
    }
    public function recipe_note_delete(Request $request){
        $recipe_id= $request->input('recipe_id');
        $menu_id = Menu::where('recipe_id',$recipe_id)->first();
        $another_menu = Combo_item::where('menu_id',$menu_id->id)->count();
        if ($another_menu != 0) {
            return response()->json(['error'=>$another_menu]);
        }
        $delete_recipe = Recipe::find($recipe_id);
        $delete_recipe->delete();
        $menu_id->delete();
        return response()->json(['success'=>'success']);
    }
    public function edit_recipe_save(Request $request){
//        return $request;
        $recipe_id= $request->input('recipe-id');
        $recipe_name= $request->input('recipe_name');

        $recipe = Recipe::where('id',$recipe_id)->first();
        $recipe->name = $recipe_name;

        if ($image = $request->file('recipe_image')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/recipe_image/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $recipe->image = $path;
            $change_menu_table = Menu::where('recipe_id',$recipe->id)->update(['image' => $path]);
        }
        $recipe->save();

        $ingredient_ids =array();

        $count = $request->input('count');
            for ($i = 1;$i<=$count;$i++) {
                if($request->has('item-' . $i) && $request->has('quantity-' . $i)){
                    $item = $request->input('item-' . $i);
                    $quantity = $request->input('quantity-' . $i);
                    if($item != "" && $quantity != ""){
                    $recipe_detail_id= $request->input('recipe-details-id-'.$i);
                    if($recipe_detail_id == 'new'){
                        $recipe_details = new Recipe_item();
                    }else{
                        $recipe_details = Recipe_item::find($recipe_detail_id);
                    }
                    $recipe_details->item_id =$item;
                    $recipe_details->quantity =$quantity;
                    $recipe_details->recipe_id =$recipe_id;
                    $recipe_details->save();
                    array_push($ingredient_ids,$recipe_details->id);
                        }
            }
            }
        $recipe_note_details_remove = Recipe_item::where('recipe_id',$recipe_id)->whereNotIn('id', $ingredient_ids)->delete();

        $recipe_detailss = Recipe::with('recipe_item.item')->where('id',$recipe_id)->first();
        return response()->json(['success'=>'success','recipe_detailss'=>$recipe_detailss]);
    }
    public function add_recipe(){
        $items =Item::where('hotel_id',auth()->user()->hotel_id)->get();
        return view('hotel.add_recipe',['items'=>$items]);
    }
    public function save_recipe(Request $request){
//        return $request;
        $recipe = new Recipe();
        $recipe->name = $request->input('recipe_name');
        $recipe->hotel_id = auth()->user()->hotel_id;
        if ($image = $request->file('recipe_image')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/recipe_image/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $recipe->image = $path;
        }
        $recipe->save();

        $count = $request->input('count');
        for ($i = 1;$i<=$count;$i++) {
            if($request->has('item-' . $i) && $request->has('Quantity-' . $i)){
                $item = $request->input('item-' . $i);
                $quantity = $request->input('Quantity-' . $i);
                if($item != "" && $quantity != ""){
                    $recipe_items = new Recipe_item();
                    $recipe_items->item_id = $item;
                    $recipe_items->recipe_id = $recipe->id;
                    $recipe_items->quantity = $quantity;
                    $recipe_items->save();
                }
            }
        }

        $menu = new Menu();
        $menu->name = $recipe->name;
        $menu->image = $recipe->image;
        $menu->hotel_id = $recipe->hotel_id;
        $menu->status = 'Active';
        $menu->combo_level = 0;
        $menu->recipe_id = $recipe->id;
        $menu->price = 0;
        $menu->type = 'Hide';

        $menu->save();


        $combo = new Combo();
        $combo->menu_id = $menu->id;
        $combo->maximum_count = 1;
        $combo->item = 1;
        $combo->save();

        $combo_item = new Combo_item();
        $combo_item->recipe_id = $recipe->id;
        $combo_item->combo_id = $combo->id;
        $combo_item->quantity = 1;
        $combo_item->type = 'Recipe';
        $combo_item->save();

        if($request->has('set_menu_item')) {
            $menu2 = new Menu();
            $menu2->name = $recipe->name;
            $menu2->image = $recipe->image;
            $menu2->hotel_id = $recipe->hotel_id;
            $menu2->status = 'Active';
            $menu2->combo_level = 1;
//            $menu->recipe_id = $recipe->id;
            $menu2->price = $request->input('recipe_price');
            $menu2->type = 'Visible';

            $menu2->save();


            $combo2 = new Combo();
            $combo2->menu_id = $menu2->id;
            $combo2->maximum_count = 1;
            $combo2->item = 1;
            $combo2->save();

            $combo_item2 = new Combo_item();
            $combo_item2->menu_id = $menu->id;
            $combo_item2->combo_id = $combo2->id;
            $combo_item2->quantity = 1;
            $combo_item2->type = 'Combo';
            $combo_item2->save();

            $restaurant_ids = $request->input('restaurant');
            $menu2->restaurant()->sync($restaurant_ids);
        }
//            $recipe_note->price = $request->input('recipe_price');

//            $categories = $request->input('categories');
//            $recipe_category = Recipe_category::find($categories);
//            $recipe_note->recipe_category_s()->attach($recipe_category);
//        }

        return redirect()->back()->with('success');
    }
    public function save_recipe_category(Request $request){
        $recipe_category_name = $request->input('category_name');
        $recipe_category = new Recipe_category();
        $recipe_category->category_name = $recipe_category_name;
        $recipe_category->hotel_id = auth()->user()->hotel_id;
        $recipe_category->save();
        return response()->json(['success'=>'success']);
    }
    public function get_category_detils_edit(Request $request){
        $recipe_category_id = $request->input('category_id');
        $recipe_category = Recipe_category::where('id',$recipe_category_id)->first();
        return response()->json(['recipe_category'=>$recipe_category]);
    }
    public function category_detils_edit_save(Request $request){
        $recipe_category_id = $request->input('category_id');
        $recipe_category_name = $request->input('category_name');
        $category = Recipe_category::find($recipe_category_id);
        $category->category_name=$recipe_category_name;
        $category->save();
        return redirect()->back()->with('success');
    }
    public function add_menu(){
        $recipe =Menu::where('hotel_id',auth()->user()->hotel_id)->get();
        return view('hotel.add_menu',['recipe'=>$recipe]);
    }
    public function view_menu(){
        $menu =Menu::with('combo.combo_item.menu.recipe')->where('hotel_id',auth()->user()->hotel_id)->whereNull('recipe_id')->get();
        $recipe =Menu::where('hotel_id',auth()->user()->hotel_id)->where('combo_level','!=',2)->get();
        return view('hotel.view_menu',['menu'=>$menu,'recipe'=>$recipe]);
    }
    public function get_menu_details(Request $request){
        $menu_id= $request->input('menu_id');
          $menu = Menu::with('combo.combo_item.menu.recipe')->find($menu_id);
        $output = view('hotel.render_for_ajax.view_combo', ['menu' => $menu])->render();

        return response()->json(['output'=>$output,'menu'=>$menu]);
    }
    public function edit_menu(Request $request){
        $menu_id= $request->input('menu_id');
        $menu = Menu::with('combo.combo_item.menu.recipe','restaurant')->find($menu_id);
        $recipe =Menu::where('hotel_id',auth()->user()->hotel_id)->get();
        $category =Menu_category_detail::with('recipe_category')->where('menu_id',$menu->id)->get();
//        return $category;
        $output = view('hotel.render_for_ajax.edit_combo', ['menu' => $menu,'recipe' => $recipe, 'menu_category' => $category])->render();
        return response()->json(['output'=>$output,'menu'=>$menu]);
    }
    public function save_menu(Request $request){
//        return $request;
        $menu = new Menu();
        $menu->name = $request->input('menu_name');
        $menu->item_code = $request->input('item-code');
        $menu->special_note = $request->input('special-note');
        $menu->hotel_id = auth()->user()->hotel_id;
        if ($image = $request->file('recipe_image')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/menu_image/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $menu->image = $path;
        }
        $menu->status = 'Active';
        $menu->combo_level = 1;
        $menu->price = $request->input('recipe_price');
        if($request->input('hide_pos')){
            $menu->type = 'Hide';
        }else{
            $menu->type = 'Visible';
        }
        $menu->save();

        $count = $request->input('count');
        for ($i = 1;$i<=$count;$i++) {
            if($request->has('item-' . $i) && $request->has('Quantity-' . $i)){
                $item = $request->input('item-' . $i);
                $quantity = $request->input('Quantity-' . $i);
                if($item != "" && $quantity != ""){

                    $combo = new Combo();
                    $combo->menu_id = $menu->id;
                    $combo->maximum_count = 1;
                    $combo->item = 1;
                    $combo->save();

                    $combo_item = new Combo_item();
                    $combo_item->menu_id = $item;
                    $combo_item->combo_id = $combo->id;
                    $combo_item->quantity = $quantity;
                    $combo_item->type = 'Combo';
                    $combo_item->save();

                    //combo level check
                    $combo_level = Menu::find($item)->combo_level;
                    if($combo_level >= 1){
                        $menu->combo_level = 2;
                        $menu->save();
                    }
                }
            }
        }


        $recipe_group_count = $request->input('recipe_group_count');
        for ($group_id = 1;$group_id<=$recipe_group_count;$group_id++) {
            if($request->has('recipe_group_row_count_'.$group_id)){

                $combo = new Combo();
                $combo->menu_id = $menu->id;
                $combo->maximum_count = $request->input('recipe_group_'.$group_id.'_max');;
                $combo->save();

                $count = $request->input('recipe_group_row_count_'.$group_id);
                for ($i = 1;$i<=$count;$i++) {
                    if($request->has('recipe_group_'.$group_id.'_recipe-'. $i) && $request->has('recipe_group_'.$group_id.'_quantity-'. $i)){
                        $recipe = $request->input('recipe_group_'.$group_id.'_recipe-'. $i);
                        $quantity = $request->input('recipe_group_'.$group_id.'_quantity-'. $i);
                        if($recipe != "" && $quantity != ""){

                            $combo_item = new Combo_item();
                            $combo_item->menu_id = $recipe;
                            $combo_item->combo_id = $combo->id;
                            $combo_item->quantity = $quantity;
                            $combo_item->type = 'Combo';
                            $combo_item->save();

                            $combo_level = Menu::find($recipe)->combo_level;
                            if($combo_level >= 1){
                                $menu->combo_level = 2;
                                $menu->save();
                            }
                        }
                    }
                }
            }
        }
        $restaurant_ids = $request->input('restaurant');
        $menu->restaurant()->sync($restaurant_ids);

//        $categorys = $request->input('categories');
//        foreach ($categorys as $category) {
//            $menu_category_detail = new Menu_category_detail();
//            $menu_category_detail->menu_id = $menu->id;
//            $menu_category_detail->recipe_category_id = $category;
//            $menu_category_detail->save();
//        }

        $categories_ids = $request->input('categories');
        $category = Menu::find($menu->id);
        $category->recipe_category()->sync($categories_ids);

        return redirect()->back()->with('success');

    }
    public function edit_menu_save(Request $request){

        $combo_ids =array();


        $menu  = Menu::find($request->input('menu-id'));
        $menu->price = $request->input('menu_price');
        $menu->name = $request->input('menu_name');
        $menu->item_code = $request->input('item-code');
        $menu->special_note = $request->input('special-note');
        if ($image = $request->file('recipe_image')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $image->getClientMimeType();
            $path = Storage::putFile( '/menu_image/thumbnail', $image, 'public');
            $file = Image::make($image)
                ->orientate()
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            Storage::put($path, (string)$file->encode());
            $menu->image = $path;
        }
        if($request->has('hide_pos')){
            $menu->type = 'Visible';
        }else{
            $menu->type = 'Hide';
        }
        $count = $request->input('count');
        for ($i = 1;$i<=$count;$i++) {
            if($request->has('item-' . $i) && $request->has('quantity-' . $i)){
                $item = $request->input('item-' . $i);
                $quantity = $request->input('quantity-' . $i);
                $como_id = $request->input('combo-id-' . $i);
                $como_item_id = $request->input('combo-item-id-' . $i);
                if($item != "" && $quantity != ""){
//Log::info($como_id.' '.$como_item_id.' '.$item.' '.$quantity);
                    if ($como_id =="new") {
                        $combo = new Combo();
                        $combo->menu_id = $menu->id;
                        $combo->maximum_count = 1;
                        $combo->item = 1;
                        $combo->save();
                        array_push($combo_ids,$combo->id);


                        $combo_item = new Combo_item();
                        $combo_item->menu_id = $item;
                        $combo_item->combo_id = $combo->id;
                        $combo_item->type = 'Combo';

                        //combo level check
                        $combo_level = Menu::find($item)->combo_level;
                        if($combo_level >= 1){
                            $menu->combo_level = 2;
                            $menu->save();
                        }
                    }else{
                        $combo_item = Combo_item::find($como_item_id);
                        array_push($combo_ids,$como_id);

                    }


                    $combo_item->quantity = $quantity;
                    $combo_item->save();


                }
            }
        }
        $group_count = $request->input('recipe_group_count');
        for ($group_id = 1;$group_id<=$group_count;$group_id++) {
            if($request->has('recipe_group_'.$group_id.'_row_count')){
                $combo_id = $request->input('recipe-group-'.$group_id.'-combo-id');
                if($combo_id == "new") {
                    $combo = new Combo();
                    $combo->menu_id = $menu->id;
                }else{
                    $combo = Combo::find($combo_id);
                }
                $combo->maximum_count = $request->input('recipe_group_'.$group_id.'_max');;
                $combo->save();
                array_push($combo_ids,$combo->id);

                $count = $request->input('recipe_group_'.$group_id.'_row_count');
                $combo_item_ids =array();
                for ($i = 1;$i<=$count;$i++) {
                    if($request->has('recipe_group_'.$group_id.'_recipe-'. $i) && $request->has('recipe_group_'.$group_id.'_quantity-'. $i)){
                        $recipe = $request->input('recipe_group_'.$group_id.'_recipe-'. $i);
                        $quantity = $request->input('recipe_group_'.$group_id.'_quantity-'. $i);
                        if($recipe != "" && $quantity != ""){
                            $combo_item_id = $request->input('recipe-group-'.$group_id.'-comboitem-id-'. $i);
                            if($combo_item_id == "new"){
//                                Log::info($combo->id.' '.$combo_item_id.' '.$recipe.' '.$quantity);
                                $combo_item = new Combo_item();
                                $combo_item->menu_id = $recipe;
                                $combo_item->combo_id = $combo->id;
                                $combo_item->type = 'Combo';
                            }else{
                            $combo_item = Combo_item::find($combo_item_id);
                            }

                            $combo_item->quantity = $quantity;
                            $combo_item->save();
                            array_push($combo_item_ids,$combo_item->id);


                            $combo_level = Menu::find($recipe)->combo_level;
                            if($combo_level >= 1){
                                $menu->combo_level = 2;
                                $menu->save();
                            }
                        }
                    }
                }
                $combo_items_d = Combo_item::where('combo_id',$combo->id)->whereNotIn('id',$combo_item_ids)->delete();

            }
        }
        $menu->save();
        $restaurant_ids = $request->input('restaurant');
        $menu->restaurant()->sync($restaurant_ids);

        $combo_d = Combo::select('id')->where('menu_id',$menu->id)->whereNotIn('id',$combo_ids)->get()->pluck('id');
        $combo_items_d = Combo_item::whereIn('combo_id',$combo_d)->delete();
        $combo_d = Combo::whereIn('id',$combo_d)->delete();

        $categories_ids = $request->input('categories');
        $category = Menu::find($menu->id);
        $category->recipe_category()->sync($categories_ids);

return response()->json(['menu'=>$menu]);
    }
    public function agencyAndGuideInfoView(Request $request){
        $AgencyOrGuides=AgencyOrGuide::with('user')->get();

//        return $AgencyOrGuides;
        return view('hotel.agencyAndGuideInfoView',['AgencyOrGuides'=>$AgencyOrGuides]);
//        return view('hotel.agencyAndGuideInfoView');
    }
    public function update_agency_guide(Request $request)
    {
        // Validate the request data as needed
//        return $request;

        $id= $request->input('recordId');
        $AgencyOrGuide = AgencyOrGuide::find($id);

//        if (!$AgencyOrGuide) {
//            return response()->json(['error' => 'AgencyOrGuide not found!'], 404);
//        }

        // Update the job application details
        $AgencyOrGuide->AgencyOrGuide = $request->input('AgencyOrGuide');
        $AgencyOrGuide->agencyName = $request->input('agencyName');
        $AgencyOrGuide->agencyAddress = $request->input('agencyAddress');
        $AgencyOrGuide->city = $request->input('city');
        $AgencyOrGuide->stateProvince = $request->input('stateProvince');
        $AgencyOrGuide->zipCode = $request->input('zipCode');
        $AgencyOrGuide->country = $request->input('country');
        $AgencyOrGuide->phoneNumber = $request->input('phoneNumber');
        $AgencyOrGuide->emailAddress = $request->input('emailAddress');
        $AgencyOrGuide->website = $request->input('website');
        $AgencyOrGuide->travelAgencyLicenseNumber = $request->input('travelAgencyLicenseNumber');
        $AgencyOrGuide->iataNumber = $request->input('iataNumber');
        $AgencyOrGuide->emergencyContactNameAgency = $request->input('emergencyContactNameAgency');
        $AgencyOrGuide->emergencyContactPhoneAgency = $request->input('emergencyContactPhoneAgency');
        $AgencyOrGuide->agentName = $request->input('agentName');
        $AgencyOrGuide->agentPhone = $request->input('agentPhone');
        $AgencyOrGuide->agentEmail = $request->input('agentEmail');
        $AgencyOrGuide->agentRole = $request->input('agentRole');
        $AgencyOrGuide->agentCommissionRate = $request->input('agentCommissionRate');
        $AgencyOrGuide->agentPaymentTerms = $request->input('agentPaymentTerms');
        $AgencyOrGuide->preferredBookingMethod = $request->input('preferredBookingMethod');
        $AgencyOrGuide->preferredPaymentMethod = $request->input('preferredPaymentMethod');
        $AgencyOrGuide->creditLimit = $request->input('creditLimit');
        $AgencyOrGuide->specialRequests = $request->input('specialRequests');

        $AgencyOrGuide->guideName = $request->input('guideName');
        $AgencyOrGuide->guideEmail = $request->input('guideEmail');
        $AgencyOrGuide->guidePhone = $request->input('guidePhone');
        $AgencyOrGuide->guideLisenceNumber = $request->input('guideLisenceNumber');
        $AgencyOrGuide->guideCertifications = $request->input('guideCertifications');
        $AgencyOrGuide->travelerlanguages = $request->input('travelerlanguages');
        $AgencyOrGuide->guideExperience = $request->input('guideExperience');
        $AgencyOrGuide->guideAvailability = $request->input('guideAvailability');
        $AgencyOrGuide->guideRates = $request->input('guideRates');
        $AgencyOrGuide->emergencyContactName = $request->input('emergencyContactName');
        $AgencyOrGuide->emergencyContactPhone = $request->input('emergencyContactPhone');
        $AgencyOrGuide->preferredTourTypes = $request->input('preferredTourTypes');
        $AgencyOrGuide->areasOfExpertise = $request->input('areasOfExpertise');
        $AgencyOrGuide->specialSkillsInterests = $request->input('specialSkillsInterests');


        // Save the updated job application
        $AgencyOrGuide->save();


//        $AgencyOrGuide = AgencyOrGuide::find($id);

//        return response()->json(['success' => 'application has been updated successfully!', 'AgencyOrGuide' => $AgencyOrGuide]);
        return redirect()->back();
    }
    public function getData_agency_guide(Request $request){
        $id = $request->input('id');

        $data = AgencyOrGuide::find($id);

        return response()->json($data);
    }
    public function view_detail_agency_guide_complete($id)
    {
//        return $id;
        // Assuming 'AgencyOrGuide' is your model class
        $AgencyOrGuide = AgencyOrGuide::where('id',$id)
            ->first(); // Using 'first()' to get a single record

        // Check if the record exists
        if ($AgencyOrGuide) {
            // If the record exists, pass it to the view
            return view('hotel.view_agencyGuide_details', compact('AgencyOrGuide'));
        } else {
            // If the record does not exist, you might want to handle this case (redirect, show an error, etc.)
            return redirect()->back()->with('error', 'Record not found');
        }
    }
    public function delete_agency_guide(Request $request)
    {
        $id=$request->input('id');
        $status=$request->input('status');
        $AgencyOrGuide = AgencyOrGuide::find($id);

        $id=$AgencyOrGuide->user_id;
        $user = User::find($id);


        if ($status == "Blocked") {
            $user->status = "Active";
            $user->save();
        }
        else{
            $user->status = "Blocked";
            $user->save();
        }


//        return $AgencyOrGuide;
//        $AgencyOrGuide->delete();
        return redirect()->back();

    }
    public function stock_adjustment(Request $request)
    {
        return view('hotel.stock_adjustment');
    }
    public function stock_adjustment_download(Request $request)
    {
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $filename = 'stock_' . $timestamp . '.xlsx';

        return Excel::download(new StockExport, $filename);
    }

    public function stock_adjustment_upload(Request $request)
    {
        $jsonString = $request->input('customJSON');
        $jsonData = json_decode($jsonString, true);

        $changes = [];
        foreach ($jsonData as $data) {
            if ($data[0] == 'ID') {
                continue; // Skip the header row
            }
            $id = $data[0];
            $quantity = $data[3];
            $stock = Item::find($id);
            if ($stock && $stock->quantity != $quantity) {
                // Update the stock with the new quantity
                $oldQuantity = $stock->quantity;
                $stock->quantity = $quantity;
                $stock->save();

                // Detect changes and add them to the $changes array
                $changes[] = [
                    'id' => $id,
                    'item' => $stock->item,
                    'unit' => $stock->unit,
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $quantity,
                    'unit_price' => $stock->unit_price,
                ];
            }
        }
        return response()->json(['changes' => $changes]);
    }




}





