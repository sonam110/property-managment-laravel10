<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
class AdminController extends Controller
{
    public function dashboard()
    {
    	$allProperties = Property::orderby('id','DESC')->withCount('units')->get();
        return view('dashboard',compact('allProperties'));
    }
}
