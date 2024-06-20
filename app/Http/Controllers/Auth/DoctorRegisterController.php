<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\DoctorMeta;
use DB;
use Hash;

class DoctorRegisterController extends Controller
{
    //
    public function doctorRegister(Request $request){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'practice' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'doctor_type' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8',
        ]);
        DB::beginTransaction();



        try {
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->user_type = 'doctor';
            $user->password = Hash::make($request->password);
            $user->save();
    
            $doctortMeta = new DoctorMeta;
            $doctortMeta->user_id = $user->id;
            $doctortMeta->location = $request->location;
            $doctortMeta->doctor_type = $request->doctor_type;
            $doctortMeta->practice = $request->practice;
            $doctortMeta->save();
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Doctor account registered successfully. Please await approval and check your email for updates.',
            ], 201);
            
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            \Log::error('Patient registration failed: '.$e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
        return response()->json($request->all());
    }
}
