<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Get the user data
     */
    public function index(){
        $user = User::all();
        return response()->json([
            "ok" => true,
            "message" => "Retrieved Successfully",
            "data" => $user 
        ],200);
    }
}
