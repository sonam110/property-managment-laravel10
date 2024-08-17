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
class LeaseSettingController extends Controller
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

    public function leaseupdate(Request $request)
    {
        

        $validator = \Validator::make($request->all(), [
            'lease_prefix'      => 'required',
            'invoice_prefix' => 'required',
           
        ]);

       
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }


        $appsetting = Appsetting::first();
        $appsetting->lease_prefix         = $request->lease_prefix;
        $appsetting->invoice_prefix            = $request->invoice_prefix;
        $appsetting->invoice_disclaimer        = $request->invoice_disclaimer;
        $appsetting->invoice_terms          = $request->invoice_terms;
        $appsetting->recipt_note          = $request->recipt_note;
        $appsetting->generate_invoice_day     = $request->generate_invoice_day;
        $appsetting->save();
        if($appsetting)
        {
            return redirect()->route('lease-setting')->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Oops!!!, something went wrong, please try again.');
           
        }
        return \Redirect()->back();

    }

    public function create()
    {
        
        return view('lease-type.create');
        
    }

    public function store(Request $request)
    {
       
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:lease_types,name',
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $LeaseType             = new LeaseType();
        $LeaseType->name       = $request->name;
        $LeaseType->display_name       = $request->display_name;
        $LeaseType->description       = $request->description;
        $LeaseType->save();

        return redirect()->route('lease-type.index')->with('success', __('LeaseType  successfully created.'));
        
        
    }

    public function show(LeaseType $LeaseType)
    {
        return redirect()->route('lease-type.index');
    }

    public function edit(LeaseType $leaseType)
    {
       

        return view('lease-type.edit', compact('leaseType'));
    }
    public function update(Request $request, LeaseType $leaseType)
    {
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:lease_types,name,'.$leaseType->id,
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $leaseType->name = $request->name;
        $leaseType->display_name       = $request->display_name;
        $leaseType->description       = $request->description;
        $leaseType->save();

        return redirect()->route('lease-type.index')->with('success', __('LeaseType successfully updated.'));
        
        
        
        
    }

    public function destroy(LeaseType $leaseType)
    {
        
        $leaseType->delete();

        return redirect()->route('lease-type.index')->with('success', __('LeaseType successfully deleted.'));
        
        
    }
}
