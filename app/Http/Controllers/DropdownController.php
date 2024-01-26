<?php

namespace App\Http\Controllers;
use App\Models\Barangay;
use App\Models\Municipality;

class DropdownController extends Controller
{
    public function index()
    {
        $muni = Municipality::get(['name', 'id']);
        return view('/bhwInputData')->with('muni', $muni);
    }

    public function getBrgy($municipalityId)
    {
        $barangays = Barangay::where('municipality_id', $municipalityId)->get(['id', 'name']);
    
        return response()->json(['barangays' => $barangays]);
    }
}