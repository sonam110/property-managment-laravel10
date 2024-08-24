<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\Utility;
use App\Models\UnitType;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
class PropertySettingController extends Controller
{
    public function index()
    {
        $propertyTypes = PropertyType::get();
        $utilities = Utility::get();
        $unitTypes = UnitType::get();
        return View('property-type.index',compact('propertyTypes','utilities','unitTypes'));
    }

     public function create()
    {
        
        return view('property-type.create');
        
    }
    

    public function store(Request $request)
    {
       
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:property_types,name',
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $propertyType             = new PropertyType();
        $propertyType->name       = $request->name;
        $propertyType->display_name       = $request->display_name;
        $propertyType->description       = $request->description;
        $propertyType->save();

        return redirect()->route('property-type.index')->with('success', __('PropertyType  successfully created.'));
        
        
    }

    public function show(PropertyType $propertyType)
    {
        return redirect()->route('property-type.index');
    }

    public function edit(PropertyType $propertyType)
    {
        return view('property-type.edit', compact('propertyType'));
    }

    public function update(Request $request, PropertyType $propertyType)
    {
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:property_types,name,'.$propertyType->id,
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $propertyType->name = $request->name;
        $propertyType->display_name       = $request->display_name;
        $propertyType->description       = $request->description;
        $propertyType->save();

        return redirect()->route('property-type.index')->with('success', __('Property Type successfully updated.'));
        
        
        
        
    }

    public function destroy(PropertyType $propertyType)
    {
        
        $propertyType->delete();

        return redirect()->route('property-type.index')->with('success', __('Property Type successfully deleted.'));
        
        
    }
}
