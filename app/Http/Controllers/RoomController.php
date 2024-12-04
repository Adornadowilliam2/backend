<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     * method: GET
     * http://localhost/8000/api/rooms/retrieve
     */

     public function index(){
        $room = Room::all();
        return response()->json([
            'ok' => true,
            'message' => 'Retrieved Successfully',
            'data' => $room
        ], 200);
     }

     /**
      * Create a New Room
      * method: POST
      * http://localhost/8000/api/rooms/create
      */

      public function create(Request $request){
        $validator = validator($request->all(), [
            'room_name' => 'required | max:30',
            'room_type_id' => 'required | exists:room_types,id',
            'location' => 'required | max:30',
            'description' => 'required | max:255',
            'capacity' => 'required | numeric | max:100',
            'image' => 'sometimes | images | mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Room Creation Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $room = Room::create($validator->validated());
        return response()->json([
            'ok' => true,
            'message' => 'Room Created Successfully',
            'data' => $room
        ], 200);
      }

      /**
       * Display the specified resource.
       * method: GET
       * http://localhost/8000/api/rooms/show/{id}
       */

       public function show($id){
        $room = Room::find($id);
        $room->bookings;
        return response()->json([
            'ok' => true,
            'message' => 'Retrieved Successfully',
            'data' => $room
        ], 200);
       }

       /**
        * Update the specified resource in storage.
        * method: POST
        * http://localhost/8000/api/rooms/update/{id}
        */

        public function update(Request $request, $id){
            $validator = validator($request->all(), [
                'room_name' => 'required | max:30',
                'room_type_id' => 'required | exists:room_types,id',
                'location' => 'required | max:30',
                'description' => 'required | max:255',
                'capacity' => 'required | numeric | max:100',
                'image' => 'sometimes | images | mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public');
                $validator->validated()['image'] = $path;
            }

            if($validator->fails()){
                return response()->json([
                    'ok' => false,
                    'message' => 'Room Update Failed',
                    'errors' => $validator->errors()
                ], 400);
            }

            $room = Room::find($id);
            $room->update($validator->validated());
            return response()->json([
                'ok' => true,
                'message' => 'Room Updated Successfully',
                'data' => $room
            ], 200);
        }

        /**
         * Delete the specified resource from storage.
         * method: DELETE
         * http://localhost/8000/api/rooms/delete/{id}
         */

         public function destroy($id){
            $room = Room::find($id);
            $room->delete();
            return response()->json([
                'ok' => true,
                'message' => 'Room Deleted Successfully',
                'data' => $room
            ], 200);
         }

         /**
           * Search Function
           * method: POST
           * http://localhost:8000/api/rooms/search
           */

           public function search(Request $request){
            $validator = validator($request->all(), [
                'search' => 'required'
            ]);

           
            if($validator->fails()){
                return response()->json([
                    'ok' => false,
                    'message' => 'Search Failed',
                    'errors' => $validator->errors()
                ], 400);
            }  

            $rooms = Room::where('room_name', 'like', '%'.$validator->validated()['search'].'%')->get();



            return response()->json([
                "ok" => true,
                "message" => "Find successfully",
                "data" => $rooms
            ], 200);
    }
}
