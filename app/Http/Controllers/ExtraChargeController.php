<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaseType;
use App\Models\PropertyType;
use App\Models\Utility;
use App\Models\UnitType;
use App\Models\AppSetting;
use App\Models\ExtraCharge;
use App\Models\LateFees;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
class ExtraChargeController extends Controller
{
    public function index()
    {
        $propertyTypes = PropertyType::get();
        $utilities = Utility::get();
        $unitTypes = UnitType::get();
        $LeaseTypes = LeaseType::get();
        $extraCharges = ExtraCharge::get();
        $appSetting = AppSetting::first();
        $LateFees = LateFees::get();
        return View('lease-type.index',compact('propertyTypes','utilities','unitTypes','LeaseTypes','appSetting','extraCharges','LateFees'));
    }

    
    public function create()
    {
        
        return view('extra-charge.create');
        
    }

    public function store(Request $request)
    {
       
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:extra_charges,name',
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $ExtraCharge             = new ExtraCharge();
        $ExtraCharge->name       = $request->name;
        $ExtraCharge->display_name       = $request->display_name;
        $ExtraCharge->description       = $request->description;
        $ExtraCharge->save();

        return redirect()->route('extra-charge.index')->with('success', __('ExtraCharge  successfully created.'));
        
        
    }

    public function show(ExtraCharge $ExtraCharge)
    {
        return redirect()->route('extra-charge.index');
    }

    public function edit(ExtraCharge $extraCharge)
    {
       

        return view('extra-charge.edit', compact('extraCharge'));
    }
    public function update(Request $request, ExtraCharge $extraCharge)
    {
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:extra_charges,name,'.$extraCharge->id,
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $extraCharge->name = $request->name;
        $extraCharge->display_name       = $request->display_name;
        $extraCharge->description       = $request->description;
        $extraCharge->save();

        return redirect()->route('extra-charge.index')->with('success', __('extraCharge successfully updated.'));
        
        
        
        
    }

    public function destroy(ExtraCharge $extraCharge)
    {
        
        $extraCharge->delete();

        return redirect()->route('extra-charge.index')->with('success', __('extraCharge successfully deleted.'));
        
        
    }
}
