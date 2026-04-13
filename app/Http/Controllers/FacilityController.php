<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::with('images')->active()->ordered()->paginate(24);
        $heroSection = HomeSection::where('section', 'facilities')->first();
        
        return view('facilities.index', compact('facilities', 'heroSection'));
    }
}