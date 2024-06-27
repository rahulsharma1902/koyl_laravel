<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PatientMeta;
class PatientController extends Controller
{
    public function index(){
        $patients = User::where('status',1)->where('user_type','patient')->with('patientMeta')->get();
        return response()->json($patients);
    }

    public function patientDetail(Request $request,$id){
        if ($id) { 
            $patient = User::where('id', $id)
            ->where('user_type', 'patient')
            ->with('patientMeta.doctorDetails')
            ->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient not found'], 404);
            }

            return response()->json($patient);
        }else{
            return response()->json(['error' => 'Invalid ID'], 400);
        }
    }
}
