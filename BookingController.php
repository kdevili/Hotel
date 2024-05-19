<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Booking_room;
use App\Booking_room_count;
use App\Cash_book_log_activity;
use App\Hotel;
use App\Mail\Booking_approved_mail;
use App\Mail\BookingMail;
use App\Mail\Pending_booking_mail;
use App\Price_category;
use App\Room;
use App\Room_rapair;
use App\Room_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BookingController extends Controller
{

    public function booking_view($id){
        $room_categories = Room_category::where('hotel_id',$id)->where('status','Active')->get();
        return view('Booking.home',['room_categories'=>$room_categories,'hotel_id'=>$id]);
    }
    public function check_availability($id , Request $request){
        //return $request;
        if($request->has('hotel_id')){
            $hotel_id = $request->input('hotel_id');
        }else{
            $hotel_id = $id;
        }
        if($request->has('departure') and $request->has('arrive'))
        {
            $checkoutDate = $request->input('departure');
            $checkinDate = $request->input('arrive');
            $children = $request->input('children');
            $adults = $request->input('adults');

            $roomCategories = Room_category::where('hotel_id',$hotel_id)->get();

            $availableRoomCounts = [];

            foreach ($roomCategories as $category) {
                $totalRoomCount = $category->room_count;

                 $bookedRoomCount = Booking_room::whereIn('room_id', function ($query) use ($checkinDate, $checkoutDate) {
                    $query->select('rooms.id')
                        ->from('rooms')
                        ->join('booking_rooms', 'rooms.id', '=', 'booking_rooms.room_id')
                        ->join('bookings', 'bookings.id', '=', 'booking_rooms.booking_id')
                        ->where(function ($subQuery) use ($checkinDate, $checkoutDate) {
                            $subQuery->where(function ($subSubQuery) use ($checkinDate, $checkoutDate) {
                                $subSubQuery->where('bookings.checking_date', '>=', $checkinDate)
                                    ->where('bookings.checking_date', '<=', $checkoutDate);
                            })
                                ->orWhere(function ($subSubQuery) use ($checkinDate, $checkoutDate) {
                                    $subSubQuery->where('bookings.checkout_date', '>=', $checkinDate)
                                        ->where('bookings.checkout_date', '<=', $checkoutDate);
                                })
                                ->orWhere(function ($subSubQuery) use ($checkinDate, $checkoutDate) {
                                    $subSubQuery->where('bookings.checking_date', '<=', $checkinDate)
                                        ->where('bookings.checkout_date', '>=', $checkoutDate);
                                });
                        });
                })->whereIn('room_id', function ($query) use ($category) {
                    $query->select('id')
                        ->from('rooms')
                        ->where('room_category_id', $category->id);
                })->count();

                $availableRoomCount = $totalRoomCount - $bookedRoomCount;

                $availableRoomCounts[] = [
                    'category' => $category,
                    'available_count' => $availableRoomCount
                ];
            }

            //return $availableRoomCounts;
            return view('Booking.room_list',['availableRoomCounts'=>$availableRoomCounts,'adults'=>$adults,'children'=>$children,'checkinDate'=>$checkinDate,'checkoutDate'=>$checkoutDate,'hotel_id'=>$hotel_id]);

        }else{
            return redirect()->route('booking_view_new',[$id]);
        }
    }
    public function add_booking_next($id , Request $request){
       //return $request;
        $roomCategoryIds = $request->input('room_category_ids');
        $checkinDate = $request->input('arrive');
        $checkoutDate = $request->input('departure');
        $adults = $request->input('r_adults');
        $children = $request->input('r_children');
        $total_price = $request->input('price');
        $room_count = $request->input('room_count');

        $test = json_encode($roomCategoryIds);
//        // Example: Print the room category IDs and room count
//        foreach ($roomCategoryIds as $categoryId => $count) {
//            echo "Room Category ID: $categoryId, Room Count: $count <br>";
//        }
//
//        echo "Total Room Count: $roomCount";

        return view('Booking.add_booking',['roomCategoryIds'=>$test,'hotel_id'=>$id,'adults'=>$adults,'children'=>$children,'checkinDate'=>$checkinDate,'checkoutDate'=>$checkoutDate,'total_price'=>$total_price,'room_count'=>$room_count]);
    }
    public function save_booking_form($id , Request $request){
        //return $request;
        $adults = $request->input('n_adult');
        $children = $request->input('n_children');
        $checkingDate = $request->input('n_checking');
        $checkoutDate = $request->input('n_checkout');
        $total_price = $request->input('n_price');
        $room_count = $request->input('n_room_count');
        $first_name = $request->input('f_name');
        $last_name = $request->input('l_name');
        $phone = $request->input('p_number');
        $whatsapp_number = $request->input('w_number');
        $email = $request->input('email');
        $address = $request->input('address');
        $country = $request->input('country');
        $note = $request->input('message');

        $total_person = $adults + $children;
        $hotel = Hotel::find($id);
        $hotel_name = substr($hotel->hotel_name, 0, 3);

        $booking = new Booking();
        $booking->first_name=$first_name;
        $booking->last_name=$last_name;
        $booking->phone=$phone;
        $booking->email=$email;
        $booking->address=$address;
        $booking->total_person=$total_person;
        $booking->checking_date=$checkingDate;
        $booking->checkout_date=$checkoutDate;
        $booking->checking_time='14:00:00';
        $booking->checkout_time='12:00:00';
        $booking->country=$country;
        $booking->note=$note;
        $booking->total_amount=$total_price;
        $booking->hotel_id=$id;
        $booking->payment='Due';
        $booking->payment='Approved';
        $booking->source='Booking_engine';
        $booking->booking_code='#'.$hotel_name.$hotel->id.'$'.$hotel->hotel_chain_id;
        $booking->children=$children;
        $booking->adults=$adults;
        $booking->room_count=$room_count;
        $booking->w_number=$whatsapp_number;
        $booking->save();

// Step 3: Retrieve available rooms within the selected date/time range
        $category_details = $request->input('category_details'); // Array of selected room category IDs and counts
        $selectedRooms=json_decode($category_details);
        $checkingTime = $booking->checking_time;
        $checkoutTime = $booking->checkout_time;
        foreach ($selectedRooms as $categoryId => $count) {
            $availableRooms = Room::where('room_category_id', $categoryId)
                ->whereNotIn('id', function ($query) use ($checkingDate, $checkoutDate, $checkingTime, $checkoutTime) {
                    $query->select('room_id')
                        ->from('booking_rooms')
                        ->join('bookings', 'booking_rooms.booking_id', '=', 'bookings.id')
                        ->where(function ($query) use ($checkingDate, $checkoutDate, $checkingTime, $checkoutTime) {
                            $query->where(function ($query) use ($checkingDate, $checkingTime, $checkoutDate, $checkoutTime) {
                                $query->where('checking_date', '=', $checkingDate)
                                    ->where('checking_time', '<', $checkoutTime);
                            })
                                ->orWhere(function ($query) use ($checkingDate, $checkingTime, $checkoutDate, $checkoutTime) {
                                    $query->where('checkout_date', '=', $checkoutDate)
                                        ->where('checkout_time', '>', $checkingTime);
                                })
                                ->orWhere(function ($query) use ($checkingDate, $checkingTime, $checkoutDate, $checkoutTime) {
                                    $query->where('checking_date', '<', $checkingDate)
                                        ->where('checkout_date', '>', $checkoutDate);
                                })
                                ->orWhere(function ($query) use ($checkingDate, $checkingTime, $checkoutDate, $checkoutTime) {
                                    $query->where('checking_date', '=', $checkingDate)
                                        ->where('checking_time', '=', $checkingTime)
                                        ->where('checkout_date', '=', $checkoutDate)
                                        ->where('checkout_time', '=', $checkoutTime);
                                });
                        });
                })
                ->inRandomOrder()
                ->take($count)
                ->get();

            // Step 4: Randomly select available rooms
            foreach ($availableRooms as $room) {
                // Step 5: Save room details to booking_rooms table
                $bookingRoom = new Booking_room();
                $bookingRoom->booking_id = $booking->id;
                $bookingRoom->room_id = $room->id;
                $bookingRoom->save();
            }
        }

        $rooms = Booking_room::with('room')->where('booking_id',$booking->id)->get();

        $booking_data = new \stdClass;
        $booking_data->bookingdetails = $booking;
        $booking_data->roomdata = $rooms;

        Mail::to('info@ravantangalle.com')->send(new BookingMail($booking_data));
        Mail::to($booking->email)->send(new BookingMail($booking_data));
        return redirect()->route('booking_view_new',$id);
    }

    public function booking_view_out_side($id){
        return view('User.booking_form',['hotel_id'=>$id]);
    }

    public function get_available_rooms_count_old($id, Request $request)
    {
        try {
            if ($request->has('hotel_id')) {
                $hotel_id = $request->input('hotel_id');
            } else {
                $hotel_id = $id;
            }
            $checkoutDate = $request->input('checkout_date');
            $checkinDate = $request->input('checking_date'); // Corrected variable name to 'checkin_date'
            $stay = $request->input('stay'); // 'Night Stay'  or 'Day Stay'
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
            return response()->json(['availableRoomCounts' => $availableRoomCounts, 'hotel_id' => $hotel_id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


//    public function get_available_rooms_count($id, Request $request)
//    {
//        try {
//            if ($request->has('hotel_id')) {
//                $hotel_id = $request->input('hotel_id');
//            } else {
//                $hotel_id = $id;
//            }
//            $checkoutDate = $request->input('checkout_date');
//            $checkinDate = $request->input('checking_date'); // Corrected variable name to 'checkin_date'
//            $stay = $request->input('stay'); // 'Night Stay'  or 'Day Stay'
//            // Fetch only the rooms with a valid room category
//            $roomCategories = Room_category::where('hotel_id', $hotel_id)->get();
//            $availableRoomCounts = [];
//            foreach ($roomCategories as $category) {
//                // Use Eloquent relationships to fetch available rooms for the category
//                $bookedRoomIds = Booking_Room::whereHas('booking', function ($query) use ($checkinDate, $checkoutDate, $stay) {
//                    if ($stay === 'Night Stay') {
//                        $query->where(function ($q) use ($checkinDate, $checkoutDate) {
//                            $q->where('checkout_date', '>', $checkinDate)
//                                ->orWhere(function ($subQuery) use ($checkinDate) {
//                                    $subQuery->where('checkout_date', '=', $checkinDate)
//                                        ->where('checkout_time', '>', '14:00:00');
//                                });
//                        })->where(function ($q) use ($checkinDate, $checkoutDate) {
//                            $q->where('checking_date', '<', $checkoutDate)
//                                ->orWhere(function ($subQuery) use ($checkoutDate) {
//                                    $subQuery->where('checking_date', '=', $checkoutDate)
//                                        ->where('checking_time', '<=', '12:00:00');
//                                });
//                        });
//                    } elseif ($stay === 'Day Stay') {
//                        $query->where(function ($q) use ($checkinDate, $checkoutDate) {
//                            $q->where('checking_date', '>=', $checkinDate)
//                                ->where('checkout_date', '<=', $checkoutDate);
//                        });
//                    }
//                })->pluck('room_id')->toArray();
//
//                $availableRooms = Room::where('room_category_id', $category->id)
//                    ->whereNotIn('id', $bookedRoomIds)
//                    ->get();
//
//                $availableRoomCount = count($availableRooms);
//
//                $availableRoomCounts[] = [
//                    'category' => $category, // Assuming the category has a 'name' attribute
//                    'available_count' => $availableRoomCount,
//                ];
//            }
//            return response()->json(['availableRoomCounts' => $availableRoomCounts, 'hotel_id' => $hotel_id]);
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()]);
//        }
//    }




    public function get_available_rooms_count($id, Request $request)
    {
//        try {
            if ($request->has('hotel_id')) {
                $hotel_id = $request->input('hotel_id');
            } else {
                $hotel_id = $id;
            }

            $checkin = $request->input('checking_date');
            $checkout = $request->input('checkout_date');
            $stay = $request->input('stay'); // 'Night Stay' or 'Day Stay'

            // Fetch only the rooms with a valid room category
            $roomCategories = Room_category::where('hotel_id', $hotel_id)->get();
            $priceCategories = Price_category::where('hotel_id', $hotel_id)->get();
            $availableRoomCounts = [];

            // Initialize the date range
            $checkinDate = Carbon::parse($checkin);
            $checkoutDate = Carbon::parse($checkout);

            foreach ($roomCategories as $category) {
                $categoryAvailableCounts = []; // Initialize for each category
                $currentDate = clone $checkinDate; // Reset current date for each category

                //return $checkinDate;
                while ($currentDate <= $checkoutDate) {
                    // Calculate the available room count for the current date
                    Log::info($currentDate.' '.$checkoutDate);

                    $availableRooms = Room::where('room_category_id', $category->id)

                        ->whereDoesntHave('bookings', function ($query) use ($currentDate, $stay) {
                            $query->where(function ($q) use ($currentDate, $stay) {
                                if ($stay === 'Night Stay') {
                                    $q->where('checkout_date', '>', $currentDate)
                                        ->orWhere(function ($subQuery) use ($currentDate) {
                                            $subQuery->where('checkout_date', '=', $currentDate)
                                                ->where('checkout_time', '>', '14:00:00');
                                        });
                                } elseif ($stay === 'Day Stay') {
                                    $q->where('checkout_date', '>=', $currentDate)
                                        ->orWhere(function ($subQuery) use ($currentDate) {
                                            $subQuery->where('checkout_date', '=', $currentDate);

                                        });
                                }
                            })->where(function ($q) use ($currentDate, $stay) {
                                if ($stay === 'Night Stay') {
                                    $q->where('checking_date', '<', $currentDate)
                                        ->orWhere(function ($subQuery) use ($currentDate) {
                                            $subQuery->where('checking_date', '=', $currentDate)
                                                ->where('checking_time', '<=', '12:00:00');
                                        });
                                } elseif ($stay === 'Day Stay') {
                                    $q->where('checking_date', '<=', $currentDate)
                                        ->orWhere(function ($subQuery) use ($currentDate) {
                                            $subQuery->where('checking_date', '=', $currentDate);

                                        });

                                }
                            });
                        })
                        ->whereDoesntHave('room_repairs', function ($query) use ($checkin, $checkout) {
                            $query->where(function ($q) use ($checkin, $checkout) {
                                $q->where('start_date', '<', $checkout)
                                    ->where('end_date', '>', $checkin);
                            })->orWhere(function ($q) use ($checkin, $checkout) {
                                $q->whereBetween('start_date', [$checkin, $checkout])
                                    ->orWhereBetween('end_date', [$checkin, $checkout]);
                            });
                        })

                        ->whereNull('deleted_at') // Add this line to exclude soft-deleted rooms
                        ->count(); // Count the available rooms

                    $categoryAvailableCounts[] = [
                        'date' => $currentDate->format('Y-m-d'),
                        'available_count' => $availableRooms,
                    ];

                    $currentDate->addDay(); // Move to the next day
                }
                Log::info(json_encode($categoryAvailableCounts));

// If ignoreLastDay is true, remove the last element from the array
                if ($stay === 'Night Stay') {
                    array_pop($categoryAvailableCounts);
                }

// Find the minimum available count
                $minAvailableCount = PHP_INT_MAX; // Initialize with a large value
                foreach ($categoryAvailableCounts as $availableCount) {
                    $minAvailableCount = min($minAvailableCount, $availableCount['available_count']);
                }

// Log the minimum available count
                Log::info("Minimum Available Count: $minAvailableCount");
                $availableRoomCounts[] = [
                    'category' => $category, // Assuming the category has a 'name' attribute
                    'available_counts' => $minAvailableCount,
                ];
            }




            $dateRange = []; // Array to store all dates between checking and checkout dates
            $currentDate = Carbon::parse($checkin);
            $checkoutDate = Carbon::parse($checkout);
            while ($currentDate < $checkoutDate) {
                $dateRange[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            $totalPrices = []; // Array to store total prices for each date
            $totalBookingValues = []; // Array to store total booking values for each room category

            foreach ($dateRange as $date) {
                $pricesForDate = [];
                $bookingValuesForDate = []; // Array to store booking values for each room category

                foreach ($roomCategories as $category) {
                    $booking = null;
                    $bookingDate = Carbon::parse($date)->format('Y-m-d');

                    // Check if there's a booking for the current date and room category
                    if (isset($roomDetailsItem['dates'][$bookingDate])) {
                        $bookingData = $roomDetailsItem['dates'][$bookingDate];
                        $booking = $bookingData;
                    }

                    // Get all price categories for the current date and room category
                    $priceCategoriesForDate = $priceCategories
                        ->where('room_category_id', $category->id)
                        ->where('start_date', '<=', $date)
                        ->where('end_date', '>', $date); // Exclude the end date from the range

                    // Get the latest price category based on 'updated_at'
                    $latestPriceCategory = $priceCategoriesForDate
                        ->sortByDesc('updated_at')
                        ->first();

                    // Calculate the price for the current date and room category
                    $price = $booking ? 0 : ($latestPriceCategory ? $latestPriceCategory->price : $category->price);

                    $pricesForDate[$category->id] = $price;

                    // Calculate the value for the current date and room category
                    $value = $booking ? 0 : ($latestPriceCategory ? $latestPriceCategory->price : $category->price);
                    $pricesForDate[$category->id] = $value;

                    // Calculate the total booking value for the current room category
                    $bookingValuesForDate[$category->id] = $value;
                }

                $totalPrices[$date] = $pricesForDate;

                // Calculate and store the total booking value for each room category
                foreach ($bookingValuesForDate as $categoryId => $value) {
                    if (!isset($totalBookingValues[$categoryId])) {
                        $totalBookingValues[$categoryId] = 0;
                    }
                    $totalBookingValues[$categoryId] += $value;
                }
            }




            return response()->json([
                'totalPrices' => $totalPrices,
                'availableRoomCounts' => $availableRoomCounts,
                'totalBookingValues' => $totalBookingValues,
                'hotel_id' => $hotel_id
            ]);
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()]);
//        }
    }






    public function get_available_rooms_count_oldd($id, Request $request)
    {
        try {
            if ($request->has('hotel_id')) {
                $hotel_id = $request->input('hotel_id');
            } else {
                $hotel_id = $id;
            }

            $stay = $request->input('stay'); // 'Night Stay' or 'Day Stay'

            // Fetch only the rooms with a valid room category
            $roomCategories = Room_category::where('hotel_id', $hotel_id)->get();
            $availableRoomCounts = [];
            if ($stay === 'Day Stay') {
                $checkoutDate = $request->input('checkout_date');
                $checkinDate = $request->input('checking_date');
            foreach ($roomCategories as $category) {
                $bookedRoomIds = Booking_Room::whereHas('booking', function ($query) use ($checkinDate, $checkoutDate, $stay) {

                        $query->where(function ($q) use ($checkinDate, $checkoutDate) {
                            $q->where('checkout_date', '>', $checkinDate)
                                ->orWhere(function ($subQuery) use ($checkinDate) {
                                    $subQuery->where('checkout_date', '=', $checkinDate);
                                });
                        })->where(function ($q) use ($checkinDate, $checkoutDate) {
                            $q->where('checking_date', '<', $checkoutDate)
                                ->orWhere(function ($subQuery) use ($checkoutDate) {
                                    $subQuery->where('checking_date', '=', $checkoutDate)
//                                        ->where('checking_time', '<=', '12:00:00')
                                        ->where('booking_type', 'Day Stay');
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
                return response()->json(['availableRoomCounts' => $availableRoomCounts, 'hotel_id' => $hotel_id]);

            }

            if ($stay === 'Night Stay') {
                $currentDate = $request->input('checkout_date');
                $checkin = $request->input('checking_date');
                // Initialize the date range
                $checkinDate = Carbon::parse($checkin);
                $checkoutDate = Carbon::parse($currentDate);

                foreach ($roomCategories as $category) {
                    $categoryAvailableCounts = []; // Initialize for each category
                    $currentDate = clone $checkinDate; // Reset current date for each category

                    //return $checkinDate;
                    while ($currentDate <= $checkoutDate) {
                        // Calculate the available room count for the current date
                        Log::info($currentDate.' '.$checkoutDate);

                        $availableRooms = Room::where('room_category_id', $category->id)
                            ->whereDoesntHave('bookings', function ($query) use ($currentDate, $stay) {
                                $query->where(function ($q) use ($currentDate, $stay) {
                                    if ($stay === 'Night Stay') {
                                        $q->where('checkout_date', '>', $currentDate)
                                            ->orWhere(function ($subQuery) use ($currentDate) {
                                                $subQuery->where('checkout_date', '=', $currentDate)
                                                    ->where('checkout_time', '>', '14:00:00');
                                            });
                                    } elseif ($stay === 'Day Stay') {
                                        $q->where('checkout_date', '>=', $currentDate)
                                            ->orWhere(function ($subQuery) use ($currentDate) {
                                                $subQuery->where('checkout_date', '=', $currentDate);

                                            });
                                    }
                                })->where(function ($q) use ($currentDate, $stay) {
                                    if ($stay === 'Night Stay') {
                                        $q->where('checking_date', '<', $currentDate)
                                            ->orWhere(function ($subQuery) use ($currentDate) {
                                                $subQuery->where('checking_date', '=', $currentDate)
                                                    ->where('checking_time', '<=', '12:00:00');
                                            });
                                    } elseif ($stay === 'Day Stay') {
                                        $q->where('checking_date', '<=', $currentDate)
                                            ->orWhere(function ($subQuery) use ($currentDate) {
                                                $subQuery->where('checking_date', '=', $currentDate);

                                            });

                                    }
                                });
                            })
                            ->count(); // Count the available rooms

                        $categoryAvailableCounts[] = [
                            'date' => $currentDate->format('Y-m-d'),
                            'available_count' => $availableRooms,
                        ];

                        $currentDate->addDay(); // Move to the next day
                    }
                    Log::info(json_encode($categoryAvailableCounts));

// If ignoreLastDay is true, remove the last element from the array
                    if ($stay === 'Night Stay') {
                        array_pop($categoryAvailableCounts);
                    }

// Find the minimum available count
                    $minAvailableCount = PHP_INT_MAX; // Initialize with a large value
                    foreach ($categoryAvailableCounts as $availableCount) {
                        $minAvailableCount = min($minAvailableCount, $availableCount['available_count']);
                    }

// Log the minimum available count
                    Log::info("Minimum Available Count: $minAvailableCount");
                    $availableRoomCounts[] = [
                        'category' => $category, // Assuming the category has a 'name' attribute
                        'available_counts' => $minAvailableCount,
                    ];
                }

                return response()->json([
                    'availableRoomCounts' => $availableRoomCounts,
                    'hotel_id' => $hotel_id
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function booking_save_out_side(Request $request){
//       return $request;
        $hotel_id = $request->input('hotel_id');
        $first_name = $request->input('f_name');
        $last_name = $request->input('l_name');
        $booking_method = $request->input('booking_method');
        $country = $request->input('country');
        $passport = $request->input('passport_number');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $w_number = $request->input('whatsapp_number');
        $checking_date = $request->input('check_in_date');
        $checkout_date = $request->input('check_out_date');
        $adults = $request->input('adults');
        $children = $request->input('children');
        $breakfast = $request->input('Breakfast');
        $advance_payment = $request->input('advanced_payment');
        $note = $request->input('note');
        $bookingtype = $request->input('bookingtype');

        $total_person = $adults+$children;

        $hotel = Hotel::find($hotel_id);
        $hotel_name = substr($hotel->hotel_name, 0, 3);
        $last_name_spilt = substr($last_name, 0, 3);
        $booking = new Booking();
        $booking->first_name=$first_name;
        $booking->last_name=$last_name;
        $booking->phone=$phone;
        $booking->email=$email;
        $booking->total_person=$total_person;
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

        $booking->country=$country;
        $booking->note=$note;
        $booking->advance_payment=$advance_payment;
        $booking->hotel_id=$hotel_id;
        $booking->payment= 'Due';
        $booking->booking_code='#'.$hotel_name.$hotel->id.$hotel->hotel_chain_id.$last_name_spilt;
        $booking->adults=$adults;
        $booking->children=$children;
        $booking->w_number=$w_number;
        $booking->breakfast=$breakfast;
        $booking->status='Pending';
        $booking->source='Outside';
        $booking->passport=$passport;
        $booking->booking_method=$booking_method;
        $booking->booking_type=$bookingtype;

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

        $room_categories = Room_category::where('hotel_id',$hotel_id)->get();
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

        return redirect()->route('booking_form_second',$booking->id);
    }
    public function booking_view_second($booking_id){
        $booking_detail = Booking::with('booking_room_count.room_categories')->where('id',$booking_id)->first();
        return view('User.booking_form_second',['booking_detail'=>$booking_detail]);
    }
    public function edit_pending_booking_save_outside(Request $request){
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
        $rooms = Booking_room_count::with('room_categories')->where('booking_id',$booking->id)->get();
        $booking_data = new \stdClass;
        $booking_data->bookingdetails = $booking;
        $booking_data->roomdata = $rooms;

        Mail::to('info@ravantangalle.com')->send(new Pending_booking_mail($booking_data));

        return redirect()->route('booking_form_thankyou',$booking->id);
    }
    public function booking_view_thank_you($booking_id){
        $booking_detail = Booking::where('id',$booking_id)->first();
        return view('User.booking_form_thankyou',['booking_detail'=>$booking_detail]);
    }

}
