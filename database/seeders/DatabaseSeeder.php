<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Artisan;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Room;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "name" => "Minda",
            "email" => "minda@gmail.com",
            "password" => Hash::make("P@55w0rd"),
            "role" => "admin"
        ]);

        RoomType::create([
            'room_type' => 'Laboratory'
        ]);

        RoomType::create([
            'room_type' => 'Lecture'
        ]); 

        RoomType::create([
            'room_type' => 'Gym'
        ]);

        RoomType::create([
            'room_type' => 'AVR'
        ]);

        RoomType::create([
            'room_type' => 'Registar'
        ]);


        Room::create([
            "room_name" => "Room 330",
            "room_type_id" => 1,
            "location" => "393 St",
            "description" => "This is a seminar room",
            "capacity" => 30,
            "image" => "https://images7.memedroid.com/images/UPLOADED950/6045883e4739b.jpeg"
        ]);

        Artisan::call('passport:keys');
        Artisan::call("passport:client --personal --no-interaction");



    }
}
