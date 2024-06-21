<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\PatientMeta;
use DB;
use Hash;
class RegisterController extends Controller
{

    public function patientRegister(Request $request) {
        // return response()->json($request->all());
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'location' => 'required',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8',
        ]);
        DB::beginTransaction();
    
        try {
            $user = new User;
            $user->email = $request->email;
            $user->user_type = 'patient';
            $user->password = Hash::make($request->password);
            $user->save();
    
            $patientMeta = new PatientMeta;
            $patientMeta->user_id = $user->id;
            $patientMeta->location = $request->location;
            $patientMeta->doctor_id = $request->doctor_id;
            $patientMeta->save();
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Patient registered successfully',
                'user' => $user,
                'patient_meta' => $patientMeta
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
    }

    public function register(Request $request)
    {
        return response()->json($request->all()); 
        $request->validate([
            'weight' => 'required',
            'age' => 'required|integer',
            'race' => 'required',
            'sex' => 'required|in:male,female,other',
            'allergies' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'patient_at' => 'required',
    
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
    
        DB::beginTransaction();
    
        try {
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->password = Hash::make($request->password); 
            $user->email = $request->email;
            $user->user_type = 'patient';
    
            $user->save();
    
            $patientMeta = new PatientMeta;
            $patientMeta->patient_id = $user->id;
            $patientMeta->weight = $request->weight;
            $patientMeta->age = $request->age;
            $patientMeta->race = $request->race;
            $patientMeta->sex = $request->sex;
            $patientMeta->allergies = $request->allergies;
            $patientMeta->doctor_id = $request->doctor_id;
            $patientMeta->patient_at = $request->patient_at;
            $patientMeta->save();
    
            DB::commit();
    

            return response()->json([
                'success' => true,
                'message' => 'Patient registered successfully',
                // 'user' => $user,
                // 'patient_meta' => $patientMeta,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function completeProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'race' => 'required|string|max:255',
            'allergies' => 'nullable|string|max:255',
            'user_id' => 'required',
        ]);

        // $user = Auth::user();
    
        // if (!$user) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }
    
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->status = 0;
        $user->save();
    
        $patientMeta = PatientMeta::updateOrCreate(
            ['user_id' => $user->id],
            [
                'age' => $request->age,
                'weight' => $request->weight,
                'race' => $request->race,
                'allergies' => $request->allergies,
                'status' => 0
            ]
        );
    
        return response()->json(['message' => 'Profile updated successfully'], 200);
    }
    
}
