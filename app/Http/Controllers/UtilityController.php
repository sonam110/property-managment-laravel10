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
class UtilityController extends Controller
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
        
        return view('utility.create');
        
    }

    public function store(Request $request)
    {
       
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:utilities,name',
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $Utility             = new Utility();
        $Utility->name       = $request->name;
        $Utility->display_name       = $request->display_name;
        $Utility->description       = $request->description;
        $Utility->save();

        return redirect()->route('utility.index')->with('success', __('Utility  successfully created.'));
        
        
    }

    public function show(Utility $utility)
    {
        return redirect()->route('property-type.index');
    }

    public function edit(Utility $utility)
    {
       

        return view('utility.edit', compact('utility'));
    }
    public function update(Request $request, Utility $Utility)
    {
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:utilities,name,'.$Utility->id,
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $Utility->name = $request->name;
        $Utility->display_name       = $request->display_name;
        $Utility->description       = $request->description;
        $Utility->save();

        return redirect()->route('utility.index')->with('success', __('Utility successfully updated.'));
        
        
        
        
    }

    public function destroy(Utility $Utility)
    {
        
        $Utility->delete();

        return redirect()->route('utility.index')->with('success', __('Utility successfully deleted.'));
        
        
    }
}
