<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorMeta;
use Illuminate\Support\Facades\Mail;
use App\Mail\DoctorAccountApprovedMail;

class DoctorController extends Controller
{
    //
    public function index(){
        $doctors = User::where('status',1)->where('user_type','doctor')->with('doctor_meta')->get();
        return response()->json($doctors);
    }


    public function requestDoctors(){
        $doctors = User::where('status',0)->where('user_type','doctor')->with('doctor_meta')->get();
        return response()->json($doctors);
    }

    public function requestApprove(Request $request)
    {
        try {
            $id = $request->input('id');
            if (!$id) {
                throw new \InvalidArgumentException('Invalid request: Missing user id');
            }

            $user = User::where('id', $id)->where('user_type', 'doctor')->firstOrFail();

            $user->status = 1;
            $user->save();

            DoctorMeta::where('user_id', $id)->update(['status' => 1]); 
            $mailData = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'url' => 'http://localhost:3000/login'
            ];
               
            Mail::to($user->email)->send(new DoctorAccountApprovedMail($mailData));
            return response()->json(['message' => 'Doctor request approved successfully', 'id' => $id]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Doctor not found'], 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function removeDoctorAccount(Request $request)
    {
        try {
            $id = $request->input('id');
            if (!$id) {
                return response()->json(['error' => 'Invalid request: Missing Doctor Data'], 400);
            }

            $user = User::where('id', $id)->where('user_type', 'doctor')->firstOrFail();

            $user->status = 0;
            $user->save();

            $user->delete();
            DoctorMeta::where('user_id', $id)->delete();

            return response()->json(['message' => 'Doctor Account has been removed successfully', 'id' => $id]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Doctor not found'], 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


  
    public function doctorDetail(Request $request, $id)
    {
        if ($id) { 
            $doctor = User::where('id', $id)
                        ->where('user_type', 'doctor')
                        ->with('doctorMeta')
                        ->first();

            if (!$doctor) {
                return response()->json(['error' => 'Doctor not found'], 404);
            }

            return response()->json($doctor);
        }else{
            return response()->json(['error' => 'Invalid ID'], 400);
        }
    }


    public function updateDoctor(Request $request)
    {
        if($request->id){
            $id = $request->id;
            $request->validate([
                'id'=>'required',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'practice' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'doctor_type' => 'required|string|max:255',
            ]);

            $doctor = User::find($id);

            if (!$doctor) {
                return response()->json(['error' => 'Doctor not found.'], 404);
            }

            if ($doctor->user_type !== 'doctor') {
                return response()->json(['error' => 'Sorry, you are in the wrong place.'], 403);
            }
            $doctorMeta = DoctorMeta::where('user_id', $id)->first();

            if (!$doctorMeta) {
                return response()->json(['error' => 'Doctor meta data not found.'], 404);
            }

            $doctor->first_name = $request->first_name;
            $doctor->last_name = $request->last_name;
            $doctor->save();

            $doctorMeta->location = $request->location;
            $doctorMeta->practice = $request->practice;
            $doctorMeta->doctor_type = $request->doctor_type;
            $doctorMeta->save();

            return response()->json(['message' => 'Doctor updated successfully.', 'doctor' => $doctor, 'doctor_meta' => $doctorMeta], 200);
        }
        return response()->json(['error' => 'Failed to find you profile!'], 404);
    }

}
