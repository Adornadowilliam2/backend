<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'room_type',
    ];


    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
