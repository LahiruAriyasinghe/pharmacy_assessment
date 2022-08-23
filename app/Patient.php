<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     *  generate custom patient id
     *  id contains 10 digits with 6 patient sequence
     *  one branch can have 999,999 patient total
     *
     *  example:
     *  1101000003
     *      11      - hospital id
     *      01      - hospital branch id
     *      000003  - patient sequence
     */
    protected static function booted()
    {
        $hospitalId = Auth::user()->hospital->id;
        $branchId = '01';
        $today = Carbon::now()->format('ymd');
        $patientStart = "{$hospitalId}{$branchId}";

        $lastPatient = Patient::withTrashed()
            ->select('id')
            ->where('hospital_id', $hospitalId)
            ->where(DB::raw('CAST(`id` AS CHAR)'), 'like', $patientStart . '%')
            ->orderBy('created_at', 'desc')->first();

        $currentId = 0;

        if ($lastPatient) {
            $currentId =  $lastPatient->id % 1000000;
        }

        $newId = sprintf("%06d", $currentId + 1);

        if ($currentId > 999999) {
            abort('403', 'patient id limit exceeds in Patient');
        }

        $newPatientId = "{$patientStart}{$newId}";

        static::creating(function ($patient) use ($newPatientId) {
            $patient->id = $newPatientId;
        });
    }

}
