<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    //
    protected $table = 'rooms';

    protected $fillable = [
        'room_name',
        'room_type_id',
        'location',
        'description',
        'capacity',
        'image',
    ];

    public function users(){
    return $this->belongsTo(User::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function room_types(){
        return $this->belongsTo(RoomType::class);
    }
}
