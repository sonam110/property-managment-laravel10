<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        
    	if($request->property_name!= ''){
    		$property_name = $request->input('property_name');
	        $fromDate = $request->input('from_date');
	        $toDate = $request->input('to_date');
    		$allProperties = Property::when($property_name, function($query) use ($property_name) {
                return $query->where('property_name', 'like', '%' . $property_name . '%')->orWhere('property_code', 'like', '%' . $property_name . '%');
            })
            
    		->orderby('id','DESC')
    		->withCount('units')
    		->get();
	        return view('dashboard-filter',compact('allProperties','fromDate','toDate','property_name'));
    	} else{
	    	$allProperties = Property::orderby('id','DESC')->withCount('units')->get();
	        return view('dashboard',compact('allProperties'));
    		
    	}
    }
}
