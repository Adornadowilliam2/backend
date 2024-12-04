<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     * method: GET
     * http://localhost:8000/api/bookings/retrieve
     */

     public function index(Request $request){
        return response()->json([
            'ok' => true,
            'message' => 'Retrieved Successfully',
            'data' => Booking::all()
        ], 200);
     }

     /**
      * Store a newly created resource in storage.
      * method: POST
      * http://localhost:8000/api/bookings/store
      */

      public function store(Request $request){
        $user = Auth::user();

        $validator = validator($request->all(), [
            'user_id' => 'required | exists:users,id',
            'room_id' => 'required | exists:rooms,id',
            'subject' => 'required | max:30',
            'start_time' => 'required | date_format:H:i',
            'end_time' => 'required | date_format:H:i',
            'day_of_week' => 'required | max:10',
            'status' => 'sometimes | max:10',
            'book_from' => 'required | date',
            'book_until' => 'required | date'
        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Booking Creation Failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        if($user->role == "admin"){
            $room = Room::find($validator->validated()['room_id']);

            $booking = Booking::create($validator->validated());
            return response()->json([
                'ok' => true,
                'message' => 'Booking Created Successfully',
                'data' => $booking,
                "room_info" => $room
            ], 200);
        }

        if($user->role !== "admin"){
            $bookrequest = Booking::create([
                'user_id' => $request->user_id,
                'room_id' => $request->room_id,
                'subject' => $request->subject,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'day_of_week' => $request->day_of_week,
                'status' => "pending",
                'book_from' => $request->book_from,
                'book_until' => $request->book_until
            ]);

            return response()->json([
                'ok' => true,
                'message' => 'Booking Request Created Successfully. Please wait for approval',
                'data' => $bookrequest
            ]);
        }
      }



      /**
       * display the specified resource.
       * method: GET
       * http://localhost:8000/api/bookings/show/{id}
       */

       public function show(Request $request, Booking $booking){
        return response()->json([
            'ok' => true,
            'message' => 'Retrieved Successfully',
            'data' => $booking
        ], 200);
       }

       /**
        * update the specified resource in storage.
        * method: POST
        * http://localhost:8000/api/bookings/update/{id}
        */

        public function update(Request $request, $id){
            $user = Auth::user();
            
            
            if($user->role !== "admin"){
                return response()->json([
                    'ok' => false,
                    'message' => 'You are not authorized to update this booking. Please contact the admin for approval',
                ], 400);
            }


            $validator = validator($request->all(), [
                'user_id' => 'required | exists:users,id',
                'room_id' => 'required | exists:rooms,id',
                'subject' => 'required | max:30',
                'start_time' => 'required | date',
                'end_time' => 'required | date',
                'day_of_week' => 'required | max:10',
                'status' => 'sometimes | max:10',
                'book_from' => 'required | date',
                'book_until' => 'required | date'
            ]);


            if($validator->fails()){
                return response()->json([
                    'ok' => false,
                    'message' => 'Booking Update Failed',
                    'errors' => $validator->errors()
                ], 400);
            };

            $bookings = Booking::find($id);
            $bookings->update($validator->validated());
            return response()->json([
                'ok' => true,
                'message' => 'Booking Updated Successfully',
                'data' => $bookings
            ], 200);
        }

        /**
         * remove the specified resource from storage.
         * method: DELETE
         * http://localhost:8000/api/bookings/destroy/{id}
         */

         public function destroy($id){
            $bookings = Booking::find($id);
            $bookings->delete();
            return response()->json([
                'ok' => true,
                'message' => 'Booking Deleted Successfully',
                'data' => $bookings
            ], 200);
         }
}
