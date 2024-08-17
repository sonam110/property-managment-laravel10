<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenantType;
use App\Models\AppSetting;
use Validator;
use Auth;
use Exception;
use DB;
class TenantSettingController extends Controller
{
     public function index()
    {
        $tenantTypes = TenantType::get();
        $appSetting = AppSetting::first();
      
        return View('tenant-type.index',compact('tenantTypes','appSetting'));
    }
    public function tenantupdate(Request $request)
    {
        

        $validator = \Validator::make($request->all(), [
            'tenant_prefix'      => 'required',
           
        ]);

       
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }


        $appsetting = Appsetting::first();
        $appsetting->tenant_prefix         = $request->tenant_prefix;
        $appsetting->save();
        if($appsetting)
        {
            return redirect()->route('tenant-setting')->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Oops!!!, something went wrong, please try again.');
           
        }
        return \Redirect()->back();

    }

    public function create()
    {
        
        return view('tenant-type.create');
        
    }

    public function store(Request $request)
    {
       
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:tenant_types,name',
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $TenantType             = new TenantType();
        $TenantType->name       = $request->name;
        $TenantType->display_name       = $request->display_name;
        $TenantType->description       = $request->description;
        $TenantType->save();

        return redirect()->route('tenant-type.index')->with('success', __('TenantType  successfully created.'));
        
        
    }

    public function show(TenantType $TenantType)
    {
        return redirect()->route('lease-type.index');
    }

    public function edit(TenantType $tenantType)
    {
       

        return view('tenant-type.edit', compact('tenantType'));
    }
    public function update(Request $request, TenantType $TenantType)
    {
      
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|unique:tenant_types,name,'.$TenantType->id,
                               'display_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $TenantType->name = $request->name;
        $TenantType->display_name       = $request->display_name;
        $TenantType->description       = $request->description;
        $TenantType->save();

        return redirect()->route('tenant-type.index')->with('success', __('TenantType successfully updated.'));
        
        
        
        
    }

    public function destroy(TenantType $TenantType)
    {
        
        $TenantType->delete();

        return redirect()->route('tenant-type.index')->with('success', __('TenantType successfully deleted.'));
        
        
    }
}
