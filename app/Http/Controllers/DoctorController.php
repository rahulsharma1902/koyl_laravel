<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class DoctorController extends Controller
{
    //
    public function index(){
        $doctors = User::where('status',0)->where('user_type','doctor')->with('doctor_meta')->get();
        return response()->json($doctors);
    }
}
