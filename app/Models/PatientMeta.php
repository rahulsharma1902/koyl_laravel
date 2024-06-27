<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMeta extends Model
{
    use HasFactory;
    public function doctorDetails()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->with('doctorMeta');
    }
}
