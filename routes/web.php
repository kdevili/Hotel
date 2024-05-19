<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('login');
});
Route::get('/hotel', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/staff', 'StaffController@index')->name('staff');
Route::get('/staff', function () {
    return redirect()->route('hotel/dashboard/view');
})->name('staff');

//POS Routs
Route::group(['middleware' => 'posView'], function () {
    Route::get('/hotel/pos/view', 'StaffController@pos_view')->name('hotel/pos/view');
    Route::post('/hotel/pos/place_order', 'StaffController@place_order')->name('hotel/pos/place_order');
    Route::post('/hotel/pos/open_order', 'StaffController@open_order')->name('hotel/pos/open_order');
    Route::post('/hotel/pos/finalize_order', 'StaffController@finalize_order')->name('hotel/pos/finalize_order');
    Route::post('/hotel/pos/cancel_order', 'StaffController@cancel_order')->name('hotel/pos/cancel_order');

    Route::post('/hotel/pos/try_add_to_cart', 'StaffController@try_add_to_cart')->name('hotel/pos/try_add_to_cart');
    Route::post('/hotel/pos/gte/customer/room', 'StaffController@pos_customer_get_room')->name('hotel/pos/gte/customer/room');
});

//promotion Routs
Route::group(['middleware' => 'promotionView'], function () {
    Route::get('/hotel/promotion/view', 'StaffController@promotion_view')->name('hotel/promotion/view');

});
Route::group(['middleware' => 'promotionAdd'], function () {
    Route::get('/hotel/add_promotion/get_products', 'StaffController@promotion_get_products')->name('hotel/add_promotion/get_products');
    Route::post('/hotel/add_promotion/save', 'StaffController@add_promotion_save')->name('hotel/add_promotion/save');
});
Route::group(['middleware' => 'promotionEdit'], function () {
    Route::post('hotel/edit_promotion/save', 'StaffController@edit_promotion_save')->name('hotel/edit_promotion/save');
    Route::get('/hotel/add_promotion/get_products', 'StaffController@promotion_get_products')->name('hotel/add_promotion/get_products');
});
Route::group(['middleware' => 'promotionDelete'], function () {
    Route::post('/hotel/promotion/delete_promotion', 'StaffController@delete_promotion')->name('hotel/promotion/delete_promotion');
});


//Past Orders Routs
Route::group(['middleware' => 'pastView'], function () {
    Route::get('/hotel/invoice', 'StaffController@invoice_all')->name('hotel/invoice');
});
Route::post('/hotel/invoice/void_sale', 'StaffController@invoice_void_sale')->name('hotel/invoice/void_sale');
Route::get('/hotel/invoice/void_sale/confirm', 'StaffController@invoice_void_sale_confirm')->name('hotel/invoice/void_sale/confirm');
Route::post('/hotel/invoice/complete_payment', 'StaffController@invoice_complete_payment')->name('hotel/invoice/complete_payment');

Route::get('/hotel/other_income/payment', 'StaffController@test1')->name('/hotel/other_income/payment');
Route::post('hotel/other_income_payment_amount_edit/save','StaffController@other_income_edit_payment_amount_save' )->name('hotel/other_income_payment_amount_edit/save');

Route::get('/hotel/kot', 'StaffController@kot_view')->name('hotel/kot');
Route::get('/hotel/getkot', 'StaffController@getkot')->name('hotel/getkot');
Route::post('/hotel/kot_view_order', 'StaffController@kot_view_order')->name('hotel/kot_view_order');

//GRN Routs
Route::group(['middleware' => 'grnView'], function () {
    Route::get('/hotel/grn/view', 'StaffController@grn_view')->name('hotel/grn/view');
    Route::post('/hotel/grn/get_grn_details', 'StaffController@get_grn_details')->name('hotel/grn/get_grn_details');
});
Route::group(['middleware' => 'grnAdd'], function () {
    Route::get('/hotel/grn/add', 'StaffController@grn_add')->name('hotel/grn/add');
    Route::post('/hotel/grn/save', 'StaffController@grn_save')->name('hotel/grn/save');
    Route::get('/hotel/grn/save_supplier_payment', 'StaffController@save_supplier_payment')->name('hotel/grn/save_supplier_payment');
});
Route::group(['middleware' => 'grnEdit'], function () {
    Route::post('/hotel/grn/update', 'StaffController@grn_update')->name('hotel/grn/update');
});
Route::group(['middleware' => 'grnDelete'], function () {
});

//Stock Routs
Route::group(['middleware' => 'stockView'], function () {
    Route::get('/hotel/view_item', 'AdminController@view_items')->name('hotel/view_item');
    Route::get('/hotel/view_item_category/{id}', 'AdminController@view_items_category')->name('hotel/view_item_category');
    Route::post('/hotel/item/item_history', 'AdminController@item_history')->name('hotel/item/item_history');
});
Route::group(['middleware' => 'stockEdit'], function () {
    Route::post('/hotel/item/get_item_details', 'AdminController@get_item_deatils')->name('hotel/item/get_item_details');
    Route::post('/hotel/edit-item', 'AdminController@edit_item_save')->name('hotel/edit-item');
    Route::get('/hotel/stock/adjustment', 'AdminController@stock_adjustment')->name('hotel/stock/adjustment');
    Route::get('/hotel/stock/adjustment/download', 'AdminController@stock_adjustment_download')->name('hotel/stock/adjustment/download');
    Route::post('/hotel/stock/adjustment/save', 'AdminController@stock_adjustment_upload')->name('hotel/stock/adjustment/save');

});
Route::group(['middleware' => 'stockAdd'], function () {
    Route::post('/hotel/save-item', 'AdminController@save_item')->name('hotel/save-item');
});
Route::group(['middleware' => 'stockDelete'], function () {
    Route::post('/hotel/item/stock_item_delete', 'AdminController@stock_item_delete')->name('hotel/item/stock_item_delete');
});

//Waste Routs
Route::group(['middleware' => 'wasteView'], function () {
    Route::get('/hotel/waste/view', 'StaffController@view_waste_list')->name('hotel/waste/view');
});
Route::group(['middleware' => 'wasteAdd'], function () {
    Route::get('/hotel/waste/add', 'StaffController@view_waste')->name('hotel/waste/add');
    Route::post('/hotel/waste/save', 'StaffController@save_waste')->name('hotel/waste/save');
});
Route::group(['middleware' => 'wasteEdit'], function () {
    Route::post('/hotel/waste/get_waste_details', 'StaffController@waste_detail_get')->name('hotel/waste/get_waste_details');
    Route::post('/hotel/waste/update', 'StaffController@update_waste')->name('hotel/waste/update');
});
Route::group(['middleware' => 'wasteDelete'], function () {
    Route::post('/hotel/waste/delete_record', 'StaffController@waste_delete')->name('hotel/waste/delete_record');
});




//Repair Routs
Route::group(['middleware' => 'maintenanceView'], function () {
    Route::get('/hotel/repair/view', 'StaffController@view_repair_list')->name('hotel/repair/view');
    Route::get('/hotel/repair/repair_detail/{id}', 'StaffController@view_detail_repair')->name('hotel/repair/repair_detail');
    Route::get('/hotel/repair/repair_detail_complete/{id}', 'StaffController@view_detail_repair_complete')->name('hotel/repair/repair_detail_complete');
    Route::get('/hotel/repair/view_list', 'StaffController@view_repair_list_history')->name('hotel/repair/view_list');
});
Route::group(['middleware' => 'maintenanceAdd'], function () {
    Route::get('/hotel/repair/add', 'StaffController@view_repair')->name('hotel/repair/add');
    Route::post('/hotel/repair/save', 'StaffController@save_repair')->name('hotel/repair/save');
});
Route::group(['middleware' => 'maintenanceEdit'], function () {
    Route::post('/hotel/repair/get_repair_details', 'StaffController@repair_detail_get')->name('hotel/repair/get_repair_details');
    Route::post('/hotel/repair/update', 'StaffController@update_repair')->name('hotel/repair/update');
});
Route::group(['middleware' => 'maintenanceDelete'], function () {
    Route::post('/hotel/repair/delete_record', 'StaffController@repair_delete')->name('hotel/repair/delete_record');
});

Route::post('/hotel/repair_complete/save', 'StaffController@save_repair_complete')->name('hotel/repair_complete/save');


Route::get('/management/view_maintenance/{id}', 'ManagementController@view_maintenance')->name('management/view_maintenance');
Route::post('/management/repair_category/save', 'ManagementController@save_repair_category')->name('management/repair_category/save');
Route::post('/management/repair_category/get_edit_repair_category_details', 'ManagementController@get_edit_repair_category_details')->name('management/repair_category/get_edit_repair_category_details');
Route::post('/management/edit_repair_category/save', 'ManagementController@edit_repair_category_save')->name('management/edit_repair_category/save');
Route::post('/management/repair_category/delete', 'ManagementController@delete_repair_category')->name('management/repair_category/delete');


Route::post('/management/repair_location/save', 'ManagementController@save_repair_location')->name('management/repair_location/save');
Route::post('/management/repair_location/get_edit_repair_location_details', 'ManagementController@get_edit_repair_location_details')->name('management/repair_location/get_edit_repair_location_details');
Route::post('/management/edit_repair_location/save', 'ManagementController@edit_repair_location_save')->name('management/edit_repair_location/save');
Route::post('/management/repair_location/delete', 'ManagementController@delete_repair_location')->name('management/repair_location/delete');


Route::post('/management/repair_status/save', 'ManagementController@save_repair_status')->name('management/repair_status/save');
Route::post('/management/repair_status/get_edit_repair_status_details', 'ManagementController@get_edit_repair_status_details')->name('management/repair_status/get_edit_repair_status_details');
Route::post('/management/edit_repair_status/save', 'ManagementController@edit_repair_status_save')->name('management/edit_repair_status/save');
Route::post('/management/repair_status/delete', 'ManagementController@delete_repair_status')->name('management/repair_status/delete');
Route::post('/management/room/check_room_availble', 'ManagementController@checkRoomAvailable')->name('management/room/check_room_availble');
Route::post('/management/room/rapair/complete', 'ManagementController@room_rapair_complete')->name('management/room/rapair/complete');












Route::get('/management/view_utility/{id}', 'ManagementController@view_utility')->name('management/view_utility');
Route::post('/management/utility_category/save', 'ManagementController@save_utility_category')->name('management/utility_category/save');
Route::post('/management/utility_category/get_edit_utility_category_details', 'ManagementController@get_edit_utility_category_details')->name('management/utility_category/get_edit_utility_category_details');
Route::post('/management/edit_utility_category/save', 'ManagementController@edit_utility_category_save')->name('management/edit_utility_category/save');
Route::post('/management/utility_category/delete', 'ManagementController@delete_utility_category')->name('management/utility_category/delete');

//Route::get('/hotel/dashboard/chart_render_reservation', 'StaffController@dashboard_reservation_chart_render')->name('hotel/dashboard/chart_render_reservation');





//Recipe Routs
Route::group(['middleware' => 'recipeView'], function () {
    Route::get('/hotel/view_recipe_details', 'AdminController@view_recipe_details')->name('hotel/view_recipe_details');
    Route::get('/hotel/view_menu', 'AdminController@view_menu')->name('hotel/view_menu');
    Route::post('hotel/menu/get_menu_details', 'AdminController@get_menu_details')->name('hotel/menu/get_menu_details');
});
Route::group(['middleware' => 'recipeAdd'], function () {
    Route::get('/hotel/add_recipe', 'AdminController@add_recipe')->name('hotel/add_recipe');
    Route::post('/hotel/recipe/save', 'AdminController@save_recipe')->name('hotel/recipe/save');
    Route::post('/hotel/save-recipe-category', 'AdminController@save_recipe_category')->name('hotel/save-recipe-category');
    Route::post('/hotel/category/get_category_details', 'AdminController@get_category_detils_edit')->name('hotel/category/get_category_details');
    Route::post('/hotel/edit-recipe-category_save', 'AdminController@category_detils_edit_save')->name('hotel/edit-recipe-category_save');
    Route::get('/hotel/add_menu', 'AdminController@add_menu')->name('hotel/add_menu');
    Route::post('/hotel/menu/save', 'AdminController@save_menu')->name('hotel/menu/save');
});
Route::group(['middleware' => 'recipeEdit'], function () {
    Route::post('/hotel/recipe/get_recipe_details', 'AdminController@get_recipe_details')->name('hotel/recipe/get_recipe_details');
    Route::post('/hotel/edit-recipe', 'AdminController@edit_recipe_save')->name('hotel/edit-recipe');
    Route::post('/hotel/edit_menu', 'AdminController@edit_menu')->name('hotel/edit_menu');
    Route::post('/hotel/edit_menu/save', 'AdminController@edit_menu_save')->name('hotel/edit_menu/save');
});
Route::group(['middleware' => 'recipeDelete'], function () {
    Route::post('/hotel/recipe/recipe_note_delete', 'AdminController@recipe_note_delete')->name('hotel/recipe/recipe_note_delete');
});

Route::group(['middleware' => 'inventoryView'], function () {
    Route::get('/hotel/inventory/view_inventory', 'StaffController@view_over_roll_inventory')->name('hotel/inventory/view_inventory');
    Route::post('/hotel/inventory/inventory_item_history', 'StaffController@inventory_item_history')->name('hotel/inventory/inventory_item_history');
    Route::get('/hotel/inventory/view_inventory_item_bill_list', 'StaffController@view_inventory_item_bill_list')->name('hotel/inventory/view_inventory_item_bill_list');
    Route::post('/hotel/inventory_bills/get_bill_details', 'StaffController@get_inventory_item_bill_details')->name('hotel/inventory_bills/get_bill_details');
});
Route::group(['middleware' => 'inventoryAdd'], function () {
    Route::get('/hotel/inventory/add_main_categories', 'StaffController@add_main_categories')->name('hotel/inventory/add_main_categories');
    Route::post('/hotel/save-inventory-category', 'StaffController@save_main_categories')->name('hotel/save-inventory-category');
    Route::post('/hotel/edit-inventory-category_save', 'StaffController@edit_category_save')->name('hotel/edit-inventory-category_save');
    Route::post('/hotel/save-inventory-sub-category', 'StaffController@save_sub_categories')->name('hotel/save-inventory-sub-category');
    Route::post('/hotel/edit-inventory-sub_category_save', 'StaffController@edit_sub_category_save')->name('hotel/edit-inventory-sub_category_save');
    Route::post('/hotel/inventory_sub_category/get_category_details', 'StaffController@get_sub_categories_details')->name('hotel/inventory_sub_category/get_category_details');
    Route::post('/hotel/inventory_category/get_category_details', 'StaffController@edit_category_get_details')->name('hotel/inventory_category/get_category_details');
    Route::post('/hotel/inventory_category/add_category_item_view', 'StaffController@add_category_item_view')->name('hotel/inventory_category/add_category_item_view');
    Route::post('/hotel/add_inventory_item_save', 'StaffController@add_inventory_item_save')->name('hotel/add_inventory_item_save');
    Route::post('/hotel/inventory_category_item/get_details', 'StaffController@inventory_item_get_details')->name('hotel/inventory_category_item/get_details');
    Route::post('/hotel/edit_inventory_item_save', 'StaffController@edit_inventory_item_save')->name('hotel/edit_inventory_item_save');
    Route::get('/hotel/inventory/add_inventory_item_bill_view', 'StaffController@add_inventory_item_bill_view')->name('hotel/inventory/add_inventory_item_bill_view');
    Route::post('/hotel/inventory/inventory_item_bill_save', 'StaffController@inventory_item_bill_save')->name('hotel/inventory/inventory_item_bill_save');
});
Route::group(['middleware' => 'inventoryEdit'], function () {
    Route::post('/hotel/inventory/get_edit_inventory_bill_details', 'StaffController@get_edit_inventory_bill_details')->name('hotel/inventory/get_edit_inventory_bill_details');
    Route::post('/hotel/inventory/edit_inventory_item_bill_save', 'StaffController@edit_inventory_item_bill_save')->name('hotel/inventory/edit_inventory_item_bill_save');
    Route::post('/hotel/inventory_bill/inventory_bill_detail/remove', 'StaffController@remove_inventory_bill_details')->name('hotel/inventory_bill/inventory_bill_detail/remove');
    Route::post('/hotel/inventory/get_inventory_item_details', 'StaffController@get_inventory_item_details')->name('hotel/inventory/get_inventory_item_details');
    Route::post('/hotel/inventory/edit_inventory_item_save', 'StaffController@get_inventory_edit_item_save')->name('hotel/inventory/edit_inventory_item_save');
    Route::post('/hotel/inventory/inventory_item/remove', 'StaffController@inventory_item_remove')->name('hotel/inventory/inventory_item/remove');
});
Route::group(['middleware' => 'inventoryDamageView'], function () {
    Route::get('/hotel/inventory/waste_management_view', 'StaffController@waste_manage_view')->name('hotel/inventory/waste_management_view');
});
Route::group(['middleware' => 'inventoryDamageAdd'], function () {
    Route::post('/hotel/inventory/inventory_uncountable_item_waste_save', 'StaffController@inventory_uncountable_item_waste_save')->name('hotel/inventory/inventory_uncountable_item_waste_save');
    Route::post('/hotel/inventory/inventory_item_waste_save', 'StaffController@inventory_waste_save')->name('hotel/inventory/inventory_item_waste_save');
    Route::post('/hotel/inventory/get_inventory_item_details/for_waste_add', 'StaffController@add_waste_item_pop')->name('hotel/inventory/get_inventory_item_details/for_waste_add');
});
Route::group(['middleware' => 'inventoryDamageEdit'], function () {
    Route::post('/hotel/inventory/edit_inventory_item_waste_save', 'StaffController@edit_inventory_item_waste_save')->name('hotel/inventory/edit_inventory_item_waste_save');
    Route::post('/hotel/inventory/edit_inventory_uncountable_item_waste_save', 'StaffController@edit_inventory_uncountable_item_waste_save')->name('hotel/inventory/edit_inventory_uncountable_item_waste_save');
    Route::post('/hotel/inventory/edit_damage_record/get_details', 'StaffController@get_inventory_damage_record_detail')->name('hotel/inventory/edit_damage_record/get_details');
});
Route::group(['middleware' => 'inventoryDamageDelete'], function () {
    Route::post('/hotel/inventory/damage/remove', 'StaffController@remove_inventory_damage_record')->name('hotel/inventory/damage/remove');
});

Route::group(['middleware' => 'reservationView'], function () {
    Route::get('/hotel/reservation/view', 'StaffController@reservation_view')->name('hotel/reservation/view');
    Route::get('/hotel/getresvertion', 'StaffController@getresvertion')->name('hotel/getresvertion');
});
Route::group(['middleware' => 'reservationAdd'], function () {
    Route::post('/hotel/reservation/save_full', 'StaffController@reservation_save_full')->name('hotel/reservation/save_full');
});
Route::group(['middleware' => 'reservationEdit'], function () {
    Route::post('/hotel/reservation/get', 'StaffController@reservation_get')->name('hotel/reservation/get');
    Route::post('/hotel/reservation/save', 'StaffController@reservation_save')->name('hotel/reservation/save');
    Route::post('/hotel/reservation/checkutdate/save', 'StaffController@reservation_checkutdate_save')->name('hotel/reservation/checkutdate/save');
    Route::post('/hotel/reservation/whatsapp_number/save', 'StaffController@reservation_whatsapp_number_save')->name('hotel/reservation/whatsapp_number/save');
    Route::get('/hotel/reservation/sync_booking', 'StaffController@reservation_sync_booking')->name('hotel/reservation/sync_booking');
});
Route::group(['middleware' => 'reservationDelete'], function () {
    Route::post('/hotel/reservation/view/delete', 'StaffController@reservation_delete')->name('hotel/reservation/view/delete');
});
Route::get('/hotel/reservation/invoice', 'StaffController@room_invoice')->name('hotel/reservation/invoice');
Route::get('/hotel/reservation/invoice/pdf', 'StaffController@room_invoice_pdf')->name('hotel/reservation/invoice/pdf');
Route::post('/hotel/reservation/invoice/send', 'StaffController@room_invoice_send')->name('hotel/reservation/invoice/send');
Route::post('/hotel/reservation/invoice/send_another', 'StaffController@room_invoice_send_another')->name('hotel/reservation/invoice/send_another');

Route::post('/hotel/reservation/aditionalwifi/send', 'StaffController@aditionalwifi_send')->name('hotel/reservation/aditionalwifi/send');


Route::group(['middleware' => 'expensesView'], function () {
    Route::get('/hotel/expenses/view_expenses', 'StaffController@expenses_view')->name('hotel/expenses/view_expenses');
    Route::post('/hotel/expense/get_all_expense_details', 'StaffController@get_all_expense_details')->name('hotel/expense/get_all_expense_details');
    Route::post('/hotel/expense/get_all_expense_history', 'StaffController@get_all_expense_history')->name('hotel/expense/get_all_expense_history');
});
Route::group(['middleware' => 'expensesAdd'], function () {
    Route::get('/hotel/expenses/view', 'StaffController@add_expenses_view')->name('hotel/expenses/view');
    Route::post('/hotel/expenses/first/save', 'StaffController@expenses_save_first')->name('hotel/expenses/first/save');
    Route::post('/hotel/expenses/second/save', 'StaffController@expenses_save_second')->name('hotel/expenses/second/save');
    Route::post('/hotel/expenses/get_second_payment_details', 'StaffController@get_second_payment_details')->name('hotel/expenses/get_second_payment_details');
    Route::post('/hotel/expenses/second_in_table/save', 'StaffController@save_second_payment')->name('hotel/expenses/second_in_table/save');
});
Route::group(['middleware' => 'expensesEdit'], function () {
    Route::post('/hotel/expenses/get_expenses_details_first', 'StaffController@get_expenses_details_first')->name('hotel/expenses/get_expenses_details_first');
    Route::post('/hotel/expenses/edit_first/save', 'StaffController@expenses_edit_first_save')->name('hotel/expenses/edit_first/save');
    Route::post('/hotel/expense/payment/get_payment_detail', 'StaffController@get_edit_second_payment_detail')->name('hotel/expense/payment/get_payment_detail');
    Route::post('/hotel/expenses/second_in_table/save_edit', 'StaffController@edit_second_payment_detail_save')->name('hotel/expenses/second_in_table/save_edit');
});

Route::group(['middleware' => 'cashbookView'], function () {
    Route::get('/hotel/cashbook/show_cash_book/{id}', 'StaffController@show_cash_book')->name('hotel/cashbook/show_cash_book');
    Route::post('/hotel/cashbook/get_cash_book_record_details', 'StaffController@cash_book_get_record_details')->name('hotel/cashbook/get_cash_book_record_details');
});
Route::group(['middleware' => 'cashbookAdd'], function () {
    Route::get('/hotel/cashbook/cashbook_setting', 'StaffController@cashbook_setting_view')->name('hotel/cashbook/cashbook_setting');
    Route::post('/hotel/cash_book/save', 'StaffController@cashbook_save')->name('hotel/cash_book/save');
    Route::post('/hotel/cash_book/debit/money_add', 'StaffController@cash_book_add_debit')->name('hotel/cash_book/debit/money_add');
    Route::post('/hotel/cash_book/credit/money_withdraw', 'StaffController@cash_book_withdarw_money')->name('hotel/cash_book/credit/money_withdraw');
});
Route::group(['middleware' => 'cashbookEdit'], function () {
    Route::post('/hotel/cashbook/get_cash_book_details', 'StaffController@get_cashbook_details')->name('hotel/cashbook/get_cash_book_details');
    Route::post('/hotel/edit_cash_book/save', 'StaffController@edit_cash_book_save')->name('hotel/edit_cash_book/save');
    Route::post('/hotel/cashbook/get_cash_book_log_details', 'StaffController@get_cashbook_log_details')->name('hotel/cashbook/get_cash_book_log_details');
    Route::post('/hotel/cash_book/debit/money_edit', 'StaffController@cash_book_edit_debit')->name('hotel/cash_book/debit/money_edit');
});
Route::group(['middleware' => 'cashbookDelete'], function () {
    Route::post('/hotel/cashbook/delete_record', 'StaffController@cash_book_record_delete')->name('hotel/cashbook/delete_record');
});
Route::group(['middleware' => 'bookingView'], function () {
    Route::get('/hotel/booking/view_booking', 'StaffController@view_booking')->name('hotel/booking/view_booking');
    Route::get('/hotel/booking/over_roll_booking', 'StaffController@over_roll_booking')->name('hotel/booking/over_roll_booking');
    Route::post('hotel/booking/over_roll_booking/assign_rooms', 'StaffController@over_roll_booking_assign_rooms')->name('hotel/booking/over_roll_booking/assign_rooms');
    Route::post('/hotel/booking/get_booking_details_for_overall', 'StaffController@get_booking_details_for_overall')->name('hotel/booking/get_booking_details_for_overall');
    Route::post('/hotel/booking/get_pending_booking_details', 'StaffController@get_pending_booking_details')->name('hotel/booking/get_pending_booking_details');
    Route::get('/hotel/booking/upload_xls', 'StaffController@upload_xls')->name('hotel/booking/upload_xls');
    Route::post('/hotel/booking/upload_xls/save', 'StaffController@upload_xls_save')->name('hotel/booking/upload_xls/save');
    Route::post('/hotel/booking/upload_xls/get_available_rooms', 'StaffController@get_available_rooms_for_assign_xls')->name('hotel/booking/upload_xls/get_available_rooms');
    Route::post('/hotel/booking/spliit/get_available_rooms', 'StaffController@get_available_rooms_for_assign_spliit')->name('hotel/booking/spliit/get_available_rooms');
    Route::post('/hotel/booking/spliit/assign room', 'StaffController@assign_spliit_booking')->name('hotel/booking/spliit/assign room');
    Route::post('/hotel/booking/upload_xls/assign_rooms', 'StaffController@upload_xls_assign_rooms')->name('hotel/booking/upload_xls/assign_rooms');
    Route::get('/hotel/booking/view_booking_archive', 'StaffController@view_booking_archive')->name('hotel/booking/view_booking_archive');
    Route::post('/hotel/booking/archive_booking/restore', 'StaffController@archive_booking_restore')->name('hotel/booking/archive_booking/restore');

});
Route::group(['middleware' => 'bookingAdd'], function () {
    Route::get('/hotel/booking/add_booking_view', 'StaffController@add_booking_view')->name('hotel/booking/add_booking_view');
    Route::post('/hotel/booking/add_booking_save', 'StaffController@add_booking_save')->name('hotel/booking/add_booking_save');
});
Route::group(['middleware' => 'bookingEdit'], function () {
    Route::post('/hotel/booking/edit_pending_booking_save', 'StaffController@edit_pending_booking_save')->name('hotel/booking/edit_pending_booking_save');
    Route::post('/hotel/booking/get_pending_booking_details_for_assign', 'StaffController@get_pending_booking_details_for_assign')->name('hotel/booking/get_pending_booking_details_for_assign');
    Route::post('/hotel/booking/assign_pending_booking_save', 'StaffController@assign_pending_booking_save')->name('hotel/booking/assign_pending_booking_save');
    Route::post('/hotel/booking/total_booking_value_save', 'StaffController@total_booking_value_save')->name('hotel/booking/total_booking_value_save');
    Route::post('/hotel/booking/get_available_rooms_details_for_edit_pending_booking', 'StaffController@get_available_rooms_details_for_edit_pending_booking')->name('hotel/booking/get_available_rooms_details_for_edit_pending_booking');
    Route::post('/hotel/Booking/change_booking_status', 'StaffController@change_booking_status_approved_booking')->name('hotel/Booking/change_booking_status');
});
Route::group(['middleware' => 'bookingDelete'], function () {
    Route::post('/hotel/booking/delete_booking', 'StaffController@delete_booking')->name('hotel/booking/delete_booking');
    Route::post('/hotel/booking/delete_pending_booking', 'StaffController@delete_pending_booking')->name('hotel/booking/delete_pending_booking');
    Route::post('/hotel/booking/delete_booking_details', 'StaffController@delete_booking_details')->name('hotel/booking/delete_booking_details');
});
Route::group(['middleware' => 'invoiceView'], function () {
    Route::get('/hotel/hotel_invoice', 'StaffController@hotel_invoice')->name('hotel/hotel_invoice');
    Route::get('/hotel/hotel_invoice/detail/{id}', 'StaffController@hotel_invoice_detail')->name('hotel/hotel_invoice/detail');
    Route::get('/hotel/hotel_invoice/detail/invoice/print', 'StaffController@hotel_invoice_detail_invoice_print')->name('hotel/hotel_invoice/detail/invoice/print');
    Route::get('/hotel/hotel_invoice/detail/invoice/view', 'StaffController@hotel_invoice_detail_invoice_view')->name('hotel/hotel_invoice/detail/invoice/view');
});
Route::group(['middleware' => 'invoiceAdd'], function () {
    Route::post('/hotel/hotel_invoice/detail/make_payment/save', 'StaffController@hotel_invoice_detail_make_payment_save')->name('hotel/hotel_invoice/detail/make_payment/save');
});
Route::group(['middleware' => 'invoiceDelete'], function () {
    Route::get('/hotel/hotel_invoice/detail/add_payment/delete', 'StaffController@hotel_invoice_detail_add_payment_delete')->name('hotel/hotel_invoice/detail/add_payment/delete');
});


//common routes in booking
Route::post('/outside_booking/booking/get_available_rooms_details/{id}', 'BookingController@get_available_rooms_count')->name('outside_booking/booking/get_available_rooms_details');
Route::get('/booking_view_new/{id}', 'BookingController@booking_view')->name('booking_view_new');
Route::post('/booking/check_availability/next/{id}', 'BookingController@check_availability')->name('booking/check_availability/next');
Route::post('/booking/add_booking/next_step/{id}', 'BookingController@add_booking_next')->name('booking/add_booking/next_step');
Route::post('/booking/add_booking/save_booking/{id}', 'BookingController@save_booking_form')->name('booking/add_booking/save_booking');

Route::get('/booking_view_new_outside/{id}', 'BookingController@booking_view_out_side')->name('booking_view_new_outside');
Route::get('/booking_form_second/{id}', 'BookingController@booking_view_second')->name('booking_form_second');
Route::get('/booking_form_thankyou/{id}', 'BookingController@booking_view_thank_you')->name('booking_form_thankyou');
Route::post('/outside_booking/save', 'BookingController@booking_save_out_side')->name('outside_booking/save');
Route::post('/hotel/booking/edit_pending_booking_save_outside', 'BookingController@edit_pending_booking_save_outside')->name('hotel/booking/edit_pending_booking_save_outside');

Route::get('/hotel/reservation/overall_reservation', 'StaffController@overall_reservation')->name('hotel/reservation/overall_reservation');
Route::post('/hotel/reservation/get_reservation_details_for_overall', 'StaffController@get_reservation_details_for_overall')->name('hotel/reservation/get_reservation_details_for_overall');








Route::post('/hotel/cashbook/get_cash_book_monthly_record/details', 'StaffController@get_cash_book_monthly_record')->name('hotel/cashbook/get_cash_book_monthly_record/details');

// common route to inventory manage
Route::post('/hotel/inventory/filter/load_sub_category', 'StaffController@load_sub_category_inventory_filter')->name('hotel/inventory/filter/load_sub_category');
Route::post('/hotel/inventory/filter/sub_category/load_item', 'StaffController@load_sub_category_items')->name('hotel/inventory/filter/sub_category/load_item');
Route::post('/hotel/inventory/filter/load_sub_category/uncountable_item', 'StaffController@inventory_filter_uncountable_item')->name('hotel/inventory/filter/load_sub_category/uncountable_item');
Route::post('/hotel/inventory/inventory_item_bill_remark_save', 'StaffController@inventory_item_bill_remark_save')->name('hotel/inventory/inventory_item_bill_remark_save');



//Hotel Management handle

Route::get('/management/view_hotels/{id}', 'ManagementController@view_hotels')->name('management/view_hotels');
Route::get('/management/add_hotel_view', 'ManagementController@add_hotel_view')->name('management/add_hotel_view');
Route::post('/management/save-hotel-chain', 'ManagementController@save_hotel_chain')->name('management/save-hotel-chain');
Route::post('/management/hotel_chain/get_edit_details', 'ManagementController@edit_hotel_chain_get_details')->name('management/hotel_chain/get_edit_details');
Route::post('/management/edit-hotel-chain-save', 'ManagementController@edit_hotel_chain_save')->name('management/edit-hotel-chain-save');
Route::post('/management/save-hotel', 'ManagementController@save_hotel')->name('management/save-hotel');
Route::post('/management/hotel/get_hotel_details', 'ManagementController@get_hotel_details_edit')->name('management/hotel/get_hotel_details');
Route::post('/management/edit-hotel', 'ManagementController@edit_hotel_save')->name('management/edit-hotel');
Route::post('/management/hotel/hotel_delete', 'ManagementController@delete_hotel')->name('management/hotel/hotel_delete');
Route::get('/management/add_user', 'ManagementController@add_user_view')->name('management/add_user');
Route::get('/management/view_users/{id}', 'ManagementController@view_users')->name('management/view_users');
Route::post('/management/user/save', 'ManagementController@add_user_save')->name('management/user/save');
Route::post('/ManagementController/privilege/get_privilege_details', 'ManagementController@view_user_privilege')->name('management/privilege/get_privilege_details');
Route::post('/management/assign_user/save', 'ManagementController@assign_user_save')->name('management/assign_user/save');
Route::post('/management/user/delete/from_hotel', 'ManagementController@delete_user_from_hotel')->name('management/user/delete/from_hotel');
Route::post('/management/edit_user/save', 'ManagementController@edit_user_save')->name('management/edit_user/save');
Route::post('/management/user/get_edit_user_details', 'ManagementController@edit_user_details_get')->name('management/user/get_edit_user_details');
Route::get('/management/view_restaurant/{id}', 'ManagementController@view_restaurants')->name('management/view_restaurant');
Route::post('/management/restaurants/save', 'ManagementController@save_restaurants')->name('management/restaurants/save');
Route::post('/management/restaurant/delete', 'ManagementController@delete_restaurants')->name('management/restaurant/delete');
Route::post('/management/restaurant/get_edit_restaurant_details', 'ManagementController@get_restaurants_edit_details')->name('management/restaurant/get_edit_restaurant_details');
Route::post('/management/edit_restaurant/save', 'ManagementController@edit_restaurant_save')->name('management/edit_restaurant/save');
Route::post('/management/restaurant/assign_menu/save', 'ManagementController@assign_menu_save')->name('management/restaurant/assign_menu/save');
Route::post('/management/restaurant/assign_menus/get', 'ManagementController@assign_menus_get')->name('management/restaurant/assign_menus/get');
Route::get('/management/view_reservation/{id}', 'ManagementController@view_reservation')->name('management/view_reservation');
Route::post('/management/reservation_setting/save', 'ManagementController@save_reservation_setting')->name('management/reservation_setting/save');
Route::post('/management/reservation_setting/get_details', 'ManagementController@get_reservation_setting')->name('management/reservation_setting/get_details');
Route::post('/management/reservation_setting_edit/save', 'ManagementController@edit_reservation_setting_save')->name('management/reservation_setting_edit/save');
Route::get('/management/view_expenses/{id}', 'ManagementController@view_expenses')->name('management/view_expenses');
Route::post('/management/expenses/add_category', 'ManagementController@save_expenses_category')->name('management/expenses/add_category');
Route::post('/management/expenses/add_sub_category', 'ManagementController@save_expenses_sub_category')->name('management/expenses/add_sub_category');
Route::post('/management/expenses/add_cashbook_expenses', 'ManagementController@save_expenses_cashbooks')->name('management/expenses/add_cashbook_expenses');
Route::post('/management/expenses/edit_category', 'ManagementController@get_edit_category_details')->name('management/expenses/edit_category');
Route::post('/management/expenses/edit_category_save', 'ManagementController@edit_category_save')->name('management/expenses/edit_category_save');
Route::post('/management/expenses/add_sub_category_view', 'ManagementController@add_sub_category_view')->name('management/expenses/add_sub_category_view');
Route::post('/management/expenses/edit_sub_category_save', 'ManagementController@edit_sub_category_save')->name('management/expenses/edit_sub_category_save');
Route::post('/management/expenses/edit_sub_category/get_detail', 'ManagementController@edit_sub_category_get_detail')->name('management/expenses/edit_sub_category/get_detail');
Route::get('/management/view_housekeeping/{id}', 'ManagementController@view_housekeeping')->name('management/view_housekeeping');
Route::post('/management/housekeeping/assign_item/get', 'ManagementController@assign_item_get')->name('management/housekeeping/assign_item/get');
Route::post('/management/housekeeping/save', 'ManagementController@housekeeping_save')->name('management/housekeeping/save');
Route::post('/management/housekeeping/get_edit_checklist_details', 'ManagementController@get_edit_checklist_details')->name('management/housekeeping/get_edit_checklist_details');
Route::post('/management/edit_checklist/save', 'ManagementController@edit_checklist_save')->name('management/edit_checklist/save');
Route::post('/management/item/delete', 'ManagementController@delete_item')->name('management/item/delete');
Route::get('/management/view_rooms/{id}', 'ManagementController@view_rooms')->name('management/view_rooms');
Route::get('/management/view_rooms_prices/{id}', 'ManagementController@view_rooms_prices')->name('management/view_rooms_prices');
Route::post('/management/room/save', 'ManagementController@room_save')->name('management/room/save');
Route::post('/management/Room/get_edit_rooms_details', 'ManagementController@get_edit_room_details')->name('management/Room/get_edit_rooms_details');
Route::post('/management/edit_room/save', 'ManagementController@edit_room_save')->name('management/edit_room/save');
Route::post('/management/add_price_category/save', 'ManagementController@add_price_category_save')->name('management/add_price_category/save');
Route::post('/management/edit_price_category/save', 'ManagementController@edit_price_category_save')->name('management/edit_price_category/save');
Route::post('/management/Room/get_edit_price_category_details', 'ManagementController@getEditPriceCategoryDetails')->name('management/Room/get_edit_price_category_details');
Route::post('/management/Room/delete_price_category_details', 'ManagementController@deletePriceCategoryDetails')->name('management/Room/delete_price_category_details');
Route::post('/management/room/delete', 'ManagementController@delete_room')->name('management/room/delete');
Route::post('/management/save-room-category', 'ManagementController@save_room_category')->name('management/save-room-category');
Route::post('/management/room/get_edit_room_category_details', 'ManagementController@get_room_category_edit_details')->name('management/room/get_edit_room_category_details');
Route::post('/management/edit_room_category/save', 'ManagementController@edit_room_category_save')->name('management/edit_room_category/save');

Route::post('/management/assign_cash/update', 'ManagementController@assign_cash_update')->name('management/assign_cash/update');



//Common Routs

Route::get('/admin', 'AdminController@index')->name('admin');
Route::post('/modechange', 'StaffController@modechange')->name('modechange');
Route::get('/switch_hotels', 'StaffController@switch_hotel_view')->name('switch_hotels');
Route::get('/hotel/switch_hotels', 'StaffController@switch_hotel_view_change')->name('hotel/switch_hotels');



Route::get('/hotel/dashboard/view', 'StaffController@dashboard_view')->name('hotel/dashboard/view');
Route::get('/hotel/widget/view', 'StaffController@widget_view')->name('hotel/widget/view');
Route::get('/hotel/dashboard/chart_render', 'StaffController@dashboard_sale_chart_render')->name('hotel/dashboard/chart_render');
Route::get('/hotel/dashboard/chart_render_cost', 'StaffController@dashboard_cost_chart_render')->name('hotel/dashboard/chart_render_cost');
Route::get('/hotel/dashboard/chart_render_reservation', 'StaffController@dashboard_reservation_chart_render')->name('hotel/dashboard/chart_render_reservation');
Route::get('/hotel/dashboard/chart_render_utility', 'WidgetController@dashboard_utility_chart_render')->name('hotel/dashboard/chart_render_utility');
Route::get('/hotel/dashboard/chart_render_booking', 'WidgetController@dashboard_booking_details')->name('hotel/dashboard/chart_render_booking');


//Apply for job
Route::get('/job_application', 'UserController@apply_for_job')->name('job_application');
Route::post('/job_application/save', 'UserController@job_application_save')->name('job_application/save');
Route::get('/job_application/thankyou', 'UserController@checkin_thankyou')->name('job_application/thankyou');
Route::post('/job_application/save-images/dropzone', 'UserController@job_application_save_images')->name('job_application/save-images/dropzone');
Route::post('/job_application/dropzone/delete', 'UserController@job_application_delete_images')->name('job_application/dropzone/delete');

Route::get('/hotel/job_application/view', 'StaffController@view_job_application_list')->name('hotel/job_application/view');
Route::post('/hotel/job_application/get_job_application_details', 'StaffController@job_application_detail_get')->name('hotel/job_application/get_job_application_details');
Route::get('/hotel/job_application/job_application_detail_complete/{id}', 'StaffController@view_detail_job_application_complete')->name('hotel/job_application/job_application_detail_complete');
Route::post('/hotel/job_application/delete_record', 'StaffController@job_application_delete')->name('hotel/job_application/delete_record');
Route::post('/hotel/job_application/update', 'StaffController@update_add_remark')->name('hotel/job_application/update');

Route::get('/management/view_job_position/{id}', 'ManagementController@view_job_position')->name('management/view_job_position');
Route::post('/management/job_position_category/save', 'ManagementController@save_job_position_category')->name('management/job_position_category/save');
Route::post('/management/job_position_category/get_edit_job_position_category_details', 'ManagementController@get_edit_job_position_category_details')->name('management/job_position_category/get_edit_job_position_category_details');
Route::post('/management/edit_job_position_category/save', 'ManagementController@edit_job_position_category_save')->name('management/edit_job_position_category/save');
Route::post('/management/job_position_category/delete', 'ManagementController@delete_job_position_category')->name('management/job_position_category/delete');



Route::get('/checkin', 'UserController@welcome_reservation')->name('welcome/reservation');
Route::post('/welcome/reservation/search_booking', 'UserController@search_booking_for_preloaded')->name('welcome/reservation/search_booking');
Route::post('/welcome/booking/link_to_reservation_save', 'UserController@link_to_reservation_save')->name('welcome/booking/link_to_reservation_save');
Route::get('/welcome/checkin/reservation', 'UserController@checkin')->name('welcome/checkin/reservation');
Route::post('/checkin/save', 'UserController@checkin_save')->name('checkin/save');
Route::get('/menu/{hotel_id}/{restaurant_id?}', 'UserController@view_hotel_menu')->name('view_hotel_menu');
//Route::get('/menu/{hotel_id}', 'UserController@view_hotel_menu1')->name('view_hotel_menu');


Route::get('/checkin/thankyou', 'UserController@checkin_thankyou')->name('checkin/thankyou');
Route::get('/feedback', 'UserController@feedback')->name('feedback');


Route::group(['middleware' => 'housekeepingView'], function () {
    Route::get('/hotel/housekeeping/view_checklist', 'StaffController@view_checklist')->name('hotel/housekeeping/view_checklist');
    Route::get('/hotel/housekeeping/check_list_detail/{id}', 'StaffController@view_detail_checklist')->name('hotel/housekeeping/check_list_detail');
//    Route::get('/hotel/housekeeping/check_list_housekeeping_detail/{id}', 'StaffController@hotel/check_list/housekeeper_edit_save')->name('hotel/housekeeping/check_list_housekeeping_detail');
    Route::get('/hotel/housekeeping/check_list_housekeeping_detail/{id}', 'StaffController@view_detail_housekeeping_checklist')->name('hotel/housekeeping/check_list_housekeeping_detail');
    Route::get('/hotel/housekeeping/room_view', 'StaffController@view_housekeeping_room')->name('hotel/housekeeping/room_view');
    Route::post('/hotel/housekeeping/room_view_get/no_item', 'StaffController@view_housekeeping_room_get_no_item')->name('hotel/housekeeping/room_view_get/no_item');
});Route::group(['middleware' => 'housekeepingAdd'], function () {
    Route::get('/hotel/housekeeping/get_image_view/{id}', 'StaffController@get_image_view')->name('hotel/housekeeping/get_image_view');
    Route::get('/hotel/housekeeping/checklist/{id}', 'StaffController@checklist_view')->name('hotel/housekeeping/checklist');
    Route::post('/hotel/check_list/save', 'StaffController@check_list_save')->name('hotel/check_list/save');
    Route::post('/hotel/check_list_image/save', 'StaffController@check_list_image_save')->name('hotel/check_list_image/save');
    Route::post('/hotel/check_list_image/delete', 'StaffController@check_list_image_delete')->name('hotel/check_list_image/delete');
});Route::group(['middleware' => 'housekeepingEdit'], function () {
    Route::post('/hotel/check_list/housekeeper_edit_save', 'StaffController@housekeeper_check_list_edit_save')->name('hotel/check_list/housekeeper_edit_save');
    Route::get('/hotel/housekeeping/get_edit_housekeeper_checklist_details/{id}', 'StaffController@housekeeper_get_edit')->name('hotel/housekeeping/get_edit_housekeeper_checklist_details');
    Route::get('/hotel/housekeeping/get_edit_checklist_details/{id}', 'StaffController@get_edit_checklist_details')->name('hotel/housekeeping/get_edit_checklist_details');
    Route::post('/hotel/check_list/supervisor_save', 'StaffController@supervisor_save')->name('hotel/check_list/supervisor_save');
});

Route::group(['middleware' => 'utilityView'], function () {
    Route::get('/hotel/utility/view', 'StaffController@view_utility_list')->name('hotel/utility/view');
    Route::get('/hotel/utility/summery', 'StaffController@utility_summery')->name('hotel/utility/summery');
    Route::post('/hotel/utility/chart_render_utility', 'StaffController@dashboard_utility_chart_render')->name('hotel/utility/chart_render_utility');
});
Route::group(['middleware' => 'utilityAdd'], function () {
    Route::get('/hotel/utility/add', 'StaffController@view_utility')->name('hotel/utility/add');
    Route::post('/hotel/utility/save', 'StaffController@save_utility')->name('hotel/utility/save');
});
Route::group(['middleware' => 'utilityEdit'], function () {
    Route::post('/hotel/utility/get_utility_details', 'StaffController@utility_detail_get')->name('hotel/utility/get_utility_details');
    Route::post('/hotel/utility/update', 'StaffController@update_utility')->name('hotel/utility/update');
});
Route::group(['middleware' => 'utilityDelete'], function () {
    Route::post('/hotel/utility/delete_record', 'StaffController@utility_delete')->name('hotel/utility/delete_record');
});

//Route::post('/hotel/check_list/delete', 'StaffController@delete_check_list_item')->name('hotel/check_list/delete');
//Route::post('/hotel/check_list/delete', 'StaffController@delete_check_list_item')->name('hotel/check_list/delete');
//Route::get('/hotel/housekeeping/room_view', 'StaffController@view_housekeeping_room')->name('hotel/housekeeping/room_view');
//Route::post('/hotel/housekeeping/room_view_get/no_item', 'StaffController@view_housekeeping_room_get_no_item')->name('hotel/housekeeping/room_view_get/no_item');
//Route::get('/hotel/housekeeping/get_edit_housekeeper_checklist_details/{id}', 'StaffController@housekeeper_get_edit')->name('hotel/housekeeping/get_edit_housekeeper_checklist_details');
//Route::post('/hotel/check_list/housekeeper_edit_save', 'StaffController@housekeeper_check_list_edit_save')->name('hotel/check_list/housekeeper_edit_save');


Route::get('/management/view_housekeeping_layout/{id}', 'ManagementController@view_housekeeping_layout')->name('management/view_housekeeping_layout');
Route::post('/management/housekeeping_layout/save', 'ManagementController@housekeeping_layout_save')->name('management/housekeeping_layout/save');
Route::post('/management/edit_layout_name/save', 'ManagementController@edit_layout_name_save')->name('management/edit_layout_name/save');
//Route::get('/hotel/housekeeping/get_image_view/{id}', 'StaffController@get_image_view')->name('hotel/housekeeping/get_image_view');
Route::get('/management/otherbooking_view_location/{id}', 'ManagementController@other_location')->name('management/other_location');
Route::post('/management/other_location/save', 'ManagementController@other_location_save')->name('management/other_location/save');
Route::post('/management/other_location_get_edit_details', 'ManagementController@other_location_get_edit_details')->name('management/other_location_get_edit_details');
Route::post('/management/other_location_edit/save', 'ManagementController@other_location_edit_save')->name('management/other_location_edit/save');
Route::post('management/other_location/delete', 'ManagementController@other_location_delete')->name('management/other_location/delete');
Route::post('/management/housekeeping/get_edit_location', 'ManagementController@get_edit_location')->name('management/housekeeping/get_edit_location');
Route::post('/management/edit_location/save', 'ManagementController@location_edit_save')->name('management/edit_location/save');

Route::get('/hotel/housekeeping/other_location_view', 'StaffController@view_other_location')->name('hotel/housekeeping/other_location_view');
Route::get('/hotel/location/view', 'StaffController@view_location_list')->name('hotel/location/view');
Route::post('/hotel/location/save', 'StaffController@save_location')->name('hotel/location/save');
Route::post('/hotel/location/update', 'StaffController@update_location')->name('hotel/location/update');
Route::post('/hotel/location/delete_record', 'StaffController@location_delete')->name('hotel/location/delete_record');
Route::post('/hotel/location/get_location_details', 'StaffController@location_detail_get')->name('hotel/location/get_location_details');
Route::post('/hotel/housekeeping/other_location_view_get/no_item', 'StaffController@view_housekeeping_other_location_get_no_item')->name('hotel/housekeeping/other_location_view_get/no_item');


Route::get('/management/view_stock/{id}', 'ManagementController@view_stock')->name('management/view_stock');
Route::post('/management/stock_category/save', 'ManagementController@stock_category_save')->name('management/stock_category/save');
Route::post('/management/stock_category_get_edit_details', 'ManagementController@stock_category_get_edit_details')->name('management/stock_category_get_edit_details');
Route::post('/management/stock_category_edit/save', 'ManagementController@stock_category_edit_save')->name('management/stock_category_edit/save');
Route::post('management/stock_category/delete', 'ManagementController@stock_category_delete')->name('management/stock_category/delete');

Route::get('/management/view_table/{id}', 'ManagementController@view_table')->name('management/view_table');
Route::post('/management/table/save', 'ManagementController@table_save')->name('management/table/save');
Route::post('/management/table_edit/save', 'ManagementController@table_edit_save')->name('management/table_edit/save');
Route::post('/management/table_get_edit_details', 'ManagementController@table_get_edit_details')->name('management/table_get_edit_details');


Route::group(['middleware' => 'supplierView'], function () {
    Route::get('/hotel/supplier', 'StaffController@suppler')->name('hotel/supplier');
});
Route::group(['middleware' => 'supplierAdd'], function () {
    Route::post('/hotel/supplier/save', 'StaffController@supplier_save')->name('hotel/supplier/save');
});Route::group(['middleware' => 'utilityEdit'], function () {
    Route::post('/hotel/supplier_get_edit_details', 'StaffController@get_edit_supplier_details')->name('hotel/supplier_get_edit_details');
    Route::post('/hotel/edit_supplier/save', 'StaffController@edit_supplier_save')->name('hotel/edit_supplier/save');
});Route::group(['middleware' => 'utilityDelete'], function () {
    Route::post('hotel/supplier/delete', 'StaffController@supplier_delete')->name('hotel/supplier/delete');
});

Route::post('/hotel/supplier/payment/save', 'StaffController@supplier_save_payment')->name('hotel/supplier/payment/save');
Route::post('/hotel/supplier/get_second_payment_details', 'StaffController@get_supplier_second_payment_details')->name('hotel/supplier/get_second_payment_details');
Route::post('/hotel/supplier/detail/make_payment/save', 'StaffController@supplier_detail_make_payment_save')->name('hotel/supplier/detail/make_payment/save');
Route::post('/hotel/supplier/get_all_suppliere_history', 'StaffController@get_all_supplier_history')->name('hotel/supplier/get_all_suppliere_history');


Route::get('/hotel/finance', 'StaffController@finance')->name('hotel/finance');



Route::group(['middleware'=> 'customerView'],function (){
    Route::get('/hotel/customer', 'StaffController@customer')->name('hotel/customer');
    Route::get('hotel/customer/details1/{email}', 'StaffController@customerdetails1')->name('hotel/customer/details1');
});


Route::group(['middleware'=>'customerEdit'],function (){
    Route::post('hotel/customer/get_edit_customer_details', 'StaffController@get_customer_edit')->name('hotel/customer/get_edit_customer_details');
    Route::post('/hotel/customer/edit_customer/save', 'StaffController@save_customer_edit')->name('hotel/customer/edit_customer/save');
});

Route::get('/hotel/test', 'StaffController@test')->name('hotel/test');
Route::get('/hotel/upload/test', 'StaffController@upload_test')->name('hotel/upload/test');
Route::post('/hotel/upload/test', 'StaffController@upload_test_save')->name('hotel/upload/test');





Route::get('/management/view_Janitorial/{id}', 'ManagementController@view_Janitorial')->name('management/view_Janitorial');
Route::post('/management/janitorial_items/save', 'ManagementController@save_janitorial_items')->name('management/janitorial_items/save');
Route::post('/management/housekeeping/get_edit_janitorial_item_details', 'ManagementController@get_edit_janitorial_item_details')->name('management/housekeeping/get_edit_janitorial_item_details');
Route::post('/management/edit_janitorial_item/save', 'ManagementController@edit_janitorial_item')->name('management/edit_janitorial_item/save');
Route::post('/management/janitorial_item/delete', 'ManagementController@delete_janitorial_item')->name('management/janitorial_item/delete');
Route::get('/management/view_refilling/{id}', 'ManagementController@view_refilling')->name('management/view_refilling');
Route::post('/management/refilling/save', 'ManagementController@refilling_save')->name('management/refilling/save');
Route::post('/management/refilling_item/delete', 'ManagementController@delete_refilling_item')->name('management/refilling_item/delete');
Route::post('/other/income/save' , 'StaffController@save_other_incomepaymnt')->name('/other/income/save');


Route::group(['middleware'=>'otherIncomeView'],function (){
    Route::get('/hotel/other_income/view_list', 'StaffController@view_list_other_income')->name('hotel/other_income/view_list');

});

Route::group(['middleware'=>'otherIncomeAdd'],function (){
    Route::get('/hotel/other_income', 'StaffController@other_income')->name('hotel/other_income');
    Route::post('/hotel/other_income/save', 'StaffController@other_income_save')->name('hotel/other_income/save');
    Route::post('/hotel/other_income/get_second_payment_details_other', 'StaffController@get_second_payment_details_other')->name('/hotel/other_income/get_second_payment_details_other');
    Route::post('/hotel/other_income/second_payment_details_other_save', 'StaffController@second_payment_details_other_save')->name('/hotel/other_income/second_payment_details_other_save');
    Route::post('/hotel/other_income_list/get_other_income_payment_details', 'StaffController@get_other_income_payment_details')->name('/hotel/other_income_list/get_other_income_payment_details');



});

Route::group(['middleware'=>'otherIncomeEdit'],function (){
    Route::post('/hotel/other_income_list/get_other_income_details', 'StaffController@get_edit_list_view_other_income_details')->name('hotel/other_income_list/get_other_income_details');
    Route::post('/hotel/other_income_edit/save', 'StaffController@update_other_income')->name('hotel/other_income_edit/save');


});

Route::group(['middleware'=>'otherIncomeDelete'],function (){
    Route::post('/hotel/other_income/delete_record', 'StaffController@other_income_delete')->name('hotel/other_income/delete_record');

});



//Route::get('/hotel/hotel_invoice/detail/invoice/print', 'StaffController@hotel_invoice_detail_invoice_print')->name('hotel/hotel_invoice/detail/invoice/print');
Route::get('/hotel/other_income/save_income_payment', 'StaffController@save_income_payment')->name('hotel/other_income/save_income_payment');
Route::post('/hotel/other_income/payment/save', 'StaffController@other_income_save_payment')->name('hotel/other_income/payment/save');
Route::get('/hotel/other_income/get_all_other_income_history', 'StaffController@get_all_other_income_history')->name('hotel/other_income/get_all_other_income_history');



Route::get('/management/other_income/{id}', 'ManagementController@other_income')->name('management/other_income');
Route::post('/management/other_income_category/save', 'ManagementController@save_other_income_category')->name('management/other_income_category/save');
Route::post('/management/other_income_get_edit_details', 'ManagementController@get_edit_other_income_details')->name('management/other_income_get_edit_details');
Route::post('/management/edit_other_income_category/save', 'ManagementController@edit_other_income_category')->name('management/edit_other_income_category/save');
Route::post('/management/other_income/delete', 'ManagementController@delete_other_income')->name('management/other_income/delete');
Route::post('/hotel/other_income/save', 'StaffController@other_income_save')->name('hotel/other_income/save');
Route::post('management/other_income_cashbook/save', 'ManagementController@other_income_cashbook')->name('management/other_income_cashbook/save');


//Route::get('/hotel/hotel_invoice/detail/invoice/print', 'StaffController@hotel_invoice_detail_invoice_print')->name('hotel/hotel_invoice/detail/invoice/print');

Route::post('/hotel/other_income_list/get_other_income_details', 'StaffController@get_edit_list_view_other_income_details')->name('hotel/other_income_list/get_other_income_details');
Route::get('/hotel/other_income/save_income_payment', 'StaffController@save_income_payment')->name('hotel/other_income/save_income_payment');
Route::post('/hotel/other_income/payment/save', 'StaffController@other_income_save_payment')->name('hotel/other_income/payment/save');
Route::post('/hotel/other_income/delete_record', 'StaffController@other_income_delete')->name('hotel/other_income/delete_record');
Route::post('/hotel/other_income_edit/save', 'StaffController@update_other_income')->name('hotel/other_income_edit/save');
Route::post('/hotel/other_income/get_all_other_income_history', 'StaffController@get_all_other_income_history')->name('hotel/other_income/get_all_other_income_history');

Route::get('/hotel/other_income/other_income_detail_view/{id}', 'StaffController@view_other_income_details')->name('hotel/other_income/other_income_detail_view');
Route::get('/hotel/other_income/detail/invoice/print', 'StaffController@hotel_other_income_print')->name('hotel/other_income/detail/invoice/print');
Route::post('/hotel/other_income/invoice/send', 'StaffController@other_income_invoice_send')->name('hotel/other_income/invoice/send');
Route::get('/hotel/other_income/other_income_detail_edit/{id}', 'StaffController@other_income_detail_edit')->name('hotel/other_income/other_income_detail_edit');
Route::post('/hotel/other_income/edit_other_income_new', 'StaffController@edit_other_income_save_new')->name('hotel/other_income/edit_other_income_new');
Route::post('/hotel/other_income/delete_other_income_details', 'StaffController@delete_other_income_details')->name('hotel/other_income/delete_other_income_details');



Route::get('/management/other_income/{id}', 'ManagementController@other_income')->name('management/other_income');
Route::post('/management/other_income_category/save', 'ManagementController@save_other_income_category')->name('management/other_income_category/save');
Route::post('/management/other_income_get_edit_details', 'ManagementController@get_edit_other_income_details')->name('management/other_income_get_edit_details');
Route::post('/management/edit_other_income_category/save', 'ManagementController@edit_other_income_category')->name('management/edit_other_income_category/save');
Route::post('/management/other_income/delete', 'ManagementController@delete_other_income')->name('management/other_income/delete');


//hotel estimate


Route::get('/hotel/room_estimate/add_estimate', 'StaffController@add_estimate')->name('hotel/room_estimate/add_estimate');
Route::post('/hotel/room_estimate/save', 'StaffController@room_estimation_save')->name('hotel/room_estimate/save');
Route::get('/hotel/room_estimate/view_estimate_details', 'StaffController@view_estimate_details')->name('hotel/room_estimate/view_estimate_details');
Route::post('/hotel/room_estimate/get_estimate_details', 'StaffController@get_estimate_details')->name('hotel/room_estimate/get_estimate_details');
Route::post('/hotel/room_estimate/edit-estimate_new', 'StaffController@edit_estimate_save_new')->name('hotel/room_estimate/edit-estimate_new');
Route::post('/hotel/room_estimate/edit-estimate', 'StaffController@edit_estimate_save')->name('hotel/room_estimate/edit-estimate');
Route::get('/hotel/room_estimate/room_estimate_detail/{id}', 'StaffController@view_detail_room_estimate')->name('hotel/room_estimate/room_estimate_detail');
Route::post('/hotel/room_estimate/delete', 'StaffController@estimate_delete')->name('hotel/room_estimate/delete');
Route::get('/hotel/room_estimate/room_estimate_pdf/{id}', 'StaffController@view_detail_room_estimate_pdf')->name('hotel/room_estimate/room_estimate_pdf');
Route::get('/hotel/room_estimate/detail/invoice/print', 'StaffController@hotel_estimate_print')->name('hotel/room_estimate/detail/invoice/print');
//Route::post('/hotel/room_estimate/delete_estimate_details', 'StaffController@delete_estimate_details')->name('hotel/room_estimate/delete_estimate_details');
// web.php or routes.php
Route::post('/hotel/room_estimate/delete_estimate_details', 'StaffController@delete_estimate_details')->name('hotel/roagencyom_estimate/delete_estimate_details');
Route::post('/hotel/room_estimate/invoice/send', 'StaffController@room_estimate_invoice_send')->name('hotel/room_estimate/invoice/send');


    Route::get('/agency/agency_register', 'UserController@agency_register')->name('/agency_register');
    Route::post('/agencyRegister/save', 'UserController@agencyRegister')->name('agencyRegister/save');
Route::group(['middleware' => 'AgencyGuideView'], function () {
    Route::get('/agency/agencyAndGuideInfo', 'AdminController@agencyAndGuideInfoView')->name('agency/agencyAndGuideInfo');
    Route::get('/hotel/AgencyOrGuide/AgencyOrGuide_detail_complete/{id}', 'AdminController@view_detail_agency_guide_complete')->name('hotel/AgencyOrGuide/AgencyOrGuide_detail_complete');
});
Route::group(['middleware' => 'AgencyGuideEdit'], function () {
    Route::post('/agency/agencyAndGuideInfoUpdate', 'AdminController@update_agency_guide')->name('agency/agencyAndGuideInfoUpdate');
    Route::POST('hotel/AgencyOrGuide/getData', 'AdminController@getData_agency_guide')->name('hotel/AgencyOrGuide/getData');
});
Route::group(['middleware' => 'AgencyGuideDelete'], function () {
Route::get('/hotel/AgencyOrGuide/AgencyOrGuide_detail_delete', 'AdminController@delete_agency_guide')->name('hotel/AgencyOrGuide/AgencyOrGuide_detail_delete');
});
Route::get('/hotel/AgencyOrGuide/AgencyOrGuide_send_login_mail/{id}', 'AdminController@AgencyOrGuide_send_login_mail')->name('hotel/AgencyOrGuide/AgencyOrGuide_send_login_mail');

//Route::get('/agency/welcome_agency_guide', 'AgencyController@view_dashbord')->name('agency/welcome_agency_guide');
Route::get('/agency/booking/booking_list', 'AgencyController@view_booking_list')->name('agency/booking/booking_list');
Route::get('/agency/booking/add_booking', 'AgencyController@view_add_booking')->name('agency/booking/add_booking');
Route::get('/agency/booking/view_rates', 'AgencyController@view_rates')->name('agency/booking/view_rates');
Route::post('/agency/booking/add_booking_save', 'AgencyController@save_add_booking')->name('agency/booking/add_booking_save');
Route::get('/agency/booking/calender', 'AgencyController@view_calender')->name('agency/booking/calender');
Route::post('/agency/booking/get_pending_booking_details', 'AgencyController@get_pending_booking_details')->name('agency/booking/get_pending_booking_details');
Route::post('/agency/booking/delete_booking', 'AgencyController@delete_agency_booking')->name('agency/booking/delete_booking');
Route::post('/agency/booking/edit_pending_booking_save', 'AgencyController@edit_pending_booking_save')->name('agency/booking/edit_pending_booking_save');
Route::post('/agency/booking/get_booking_details_for_overall', 'AgencyController@get_booking_details_for_overall')->name('agency/booking/get_booking_details_for_overall');



Route::get('/resturent/table/order/{table_id}', 'UserController@table_order_welcome')->name('resturent/table/order');
Route::post('/resturent/table/order/{table_id}', 'UserController@table_order_welcome_save')->name('resturent/table/order');
Route::get('/resturent/table/dashboard/1', 'UserController@table_dashboard')->name('resturent/table/dashboard');
Route::post('/user/pos/try_add_to_cart', 'UserController@try_add_to_cart')->name('user/pos/try_add_to_cart');
Route::post('/user/pos/place_order', 'UserController@place_order')->name('user/pos/place_order');
Route::post('/user/resturent/getOngoingOrders', 'UserController@getOngoingOrders')->name('user/resturent/getOngoingOrders');
Route::post('/user/resturent/open_order', 'UserController@open_order')->name('user/resturent/open_order');

//route resturant

//Route::get('/hotel/resturant/view', 'StaffController@view_resturant')->name('hotel/resturant/view');
//Route::get('hotel/dashboard/resturent', 'StaffController@resturent')->name('hotel/dashboard/resturent');

Route::group(['middleware'=>'resturantView'],function (){
    Route::get('/hotel/resturant/view', 'StaffController@view_resturant')->name('hotel/resturant/view');
    Route::get('hotel/dashboard/resturent', 'StaffController@resturent')->name('hotel/dashboard/resturent');
});
