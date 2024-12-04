<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * 
     */

     protected $table = 'bookings';
     protected $fillable = [
        'user_id', 
        'room_id', 
        'subject', 
        'start_time', 
        'end_time', 
        'day_of_week',
         'status', 
         'book_start',
         'book_until'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function rooms(){
        return $this->belongsTo(Room::class);
    }
}
