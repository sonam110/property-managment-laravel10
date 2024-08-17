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
class UnitTypeController extends Controller
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
        
        return view('unit-type.create');
        
    }

    public function store(Request $request)
    {
       
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:unit_types,name',
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $UnitType             = new UnitType();
        $UnitType->name       = $request->name;
        $UnitType->display_name       = $request->display_name;
        $UnitType->description       = $request->description;
        $UnitType->save();

        return redirect()->route('unit-type.index')->with('success', __('UnitType  successfully created.'));
        
        
    }

    public function show(UnitType $unitType)
    {
        return redirect()->route('unit-type.index');
    }

    public function edit(UnitType $unitType)
    {
       

        return view('unit-type.edit', compact('unitType'));
    }
    public function update(Request $request, UnitType $UnitType)
    {
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:unit_types,name,'.$UnitType->id,
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $UnitType->name = $request->name;
        $UnitType->display_name       = $request->display_name;
        $UnitType->description       = $request->description;
        $UnitType->save();

        return redirect()->route('unit-type.index')->with('success', __('UnitType successfully updated.'));
        
        
        
        
    }

    public function destroy(UnitType $UnitType)
    {
        
        $UnitType->delete();

        return redirect()->route('unit-type.index')->with('success', __('UnitType successfully deleted.'));
        
        
    }
}
