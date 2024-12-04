<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
class RoomTypeController extends Controller
{
    /**
     * Create a new room type
     * method: POST
     * http://localhost:8000/api/room-types/
     */
    public function create(Request $request){
        $validator = validator($request->all(), [
            'room_type' => 'required | max:30 | unique:room_types,room_type'
        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Room Type Creation Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $room_type = RoomType::create($validator->validated());
        return response()->json([
            'ok' => true,
            'message' => 'Room Type Created Successfully',
            'data' => $room_type
        ], 200);
    }

    /**
     * Get all room types
     * method: GET
     * http://localhost:8000/api/room-types/
     */
    public function index(){
        $room_types = RoomType::all();
        return response()->json([
            'ok' => true,
            'message' => 'Room Types Found Successfully',
            'data' => $room_types
        ], 200);
    }


    /**
     * Update a room type
     * method: POST
     * http://localhost:8000/api/room-types/{id}
     */

     public function update(Request $request, $id){
        $validator = validator($request->all(), [
            'room_type' => 'required | max:30 | unique:room_types,room_type,'.$id
        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Room Type Update Failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $room_type = RoomType::find($id);
        $room_type->update($validator->validated());
        return response()->json([
            'ok' => true,
            'message' => 'Room Type Updated Successfully',
            'data' => $room_type
        ], 200);
    }


    /**
     * Delete a room type
     * method: DELETE
     * http://localhost:8000/api/room-types/{id}
     */

     public function destroy($id){
        $room_type = RoomType::find($id);
        $room_type->delete();
        return response()->json([
            'ok' => true,
            'message' => 'Room Type Deleted Successfully',
            'data' => $room_type
        ], 200);
    }


}
