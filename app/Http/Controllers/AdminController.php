<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use App\Models\PartnerBankDetail;
class AdminController extends Controller
{
    public function dashboard(Request $request)
    {

       /* $users = User::where('role_id','2')->get();

        foreach ($users as $user) {
                PartnerBankDetail::create([
                    'user_id' => $user->id,
                    'for_type' => 1, // Example: Rent
                    'bank_se_name' => 'Test Nickname',
                    'bank_name' => 'Test Bank',
                    'account_holder_name' => 'Test Holder',
                    'account_no' => '123456789',
                    'bank_ifsc_code' => 'TEST0001',
                    'bank_address' => '123 Test Address',
                ]);

                PartnerBankDetail::create([
                    'user_id' => $user->id,
                    'for_type' => 2, // Example: CAM
                    'bank_se_name' => 'Test Nickname CAM',
                    'bank_name' => 'Test Bank CAM',
                    'account_holder_name' => 'Test Holder CAM',
                    'account_no' => '987654321',
                    'bank_ifsc_code' => 'TEST0002',
                    'bank_address' => '456 Test Address CAM',
                ]);
                PartnerBankDetail::create([
                    'user_id' => $user->id,
                    'for_type' => 3, // Example: CAM
                    'bank_se_name' => 'Test Nickname CAM',
                    'bank_name' => 'Test Bank CAM',
                    'account_holder_name' => 'Test Holder CAM',
                    'account_no' => '987654321',
                    'bank_ifsc_code' => 'TEST0002',
                    'bank_address' => '456 Test Address CAM',
                ]);
            }*/
        
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
