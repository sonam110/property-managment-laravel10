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
class LateFeeController extends Controller
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
        
        return view('late-fees.create');
        
    }

    public function store(Request $request)
    {
       
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:late_fees,name',
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $LateFees             = new LateFees();
        $LateFees->name       = $request->name;
        $LateFees->display_name       = $request->display_name;
        $LateFees->description       = $request->description;
        $LateFees->save();

        return redirect()->route('late-fees.index')->with('success', __('LateFees  successfully created.'));
        
        
    }
    public function show(LateFees $lateFees)
    {
        return redirect()->route('late-fees.index');
    }

    public function edit(LateFees $lateFees)
    {
       

        return view('late-fees.edit', compact('lateFees'));
    }
    public function update(Request $request, LateFees $lateFees)
    {
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:late_fees,name,'.$lateFees->id,
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $lateFees->name = $request->name;
        $lateFees->display_name       = $request->display_name;
        $lateFees->description       = $request->description;
        $lateFees->save();

        return redirect()->route('late-fees.index')->with('success', __('lateFees successfully updated.'));
        
        
        
        
    }

    public function destroy(LateFees $lateFees)
    {
        
        $lateFees->delete();

        return redirect()->route('late-fees.index')->with('success', __('lateFees successfully deleted.'));
        
        
    }
}
