<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyPaymentSetting;
use App\Models\PropertyType;
use App\Models\PropertyUnit;
use App\Models\PropertyExtraCharges;
use App\Models\PropertyLateFees;
use App\Models\PropertyUtility;
use App\Models\UnitType;
use App\Models\Utility;
use App\Models\ExtraCharge;
use App\Models\LateFees;
use App\Models\Lease;
use App\Models\LeaseType;
use App\Models\Tenant;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
class LeaseController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('lease-browse')) {
            $data = Lease::get();
            $propertyTypes = LeaseType::get()->pluck('display_name', 'id');
            $partners = User::get()->pluck('first_name', 'id');
            return View('lease.index',compact('propertyTypes','data','partners'));
        } else {
            return redirect()->back();
        }
    }
    public function leaseList(Request $request)
    {
        $query = Lease::orderBy('id','DESC');
        if(!empty($request->property_id))
        {
            $query->where('property_id', $request->property_id);
        }
        if($request->status!='')
        {
            $query->where('status', $request->status);
        }
        return datatables($query)
            ->editColumn('property_id', function ($query)
            {
                
                return $query->property->property_code;
            })
           
            ->editColumn('status', function ($query)
            {
                if ($query->status == 1)
                {
                    $status = 'Active';
                    $class='bg-label-success';
                }
                else
                {
                    $status = 'Inactive';
                    $class='bg-label-secondary';
                }

                return '<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                 $edit =' <a class="btn btn-sm btn-primary" href="'.route('property.edit', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                $delete = '<a href="'.route('property-destroy', $query->id) .'" 
                                 class="btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>';
                $copy =' <a class="btn btn-sm btn-info" href="'.route('property-copy', $query->id) .'"  onClick="return confirm(\'Are you sure you want to copy this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy"><i class="fa fa-copy"></i></a>';


                

                return '<div class="btn-group btn-group-xs">'.$edit.$delete.$copy.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

     public function create()
    {
        if (\Auth::user()->can('lease-add')) {

            $properties = Property::pluck('property_name','id')->toArray();
            $tenants = Tenant::pluck('firm_name','id')->toArray();
            $leaseTypes = LeaseType::get()->pluck('display_name', 'id');
            $propertyTypes = PropertyType::get()->pluck('display_name', 'id');
            $partners = User::where('role_id','2')->get()->pluck('first_name', 'id');
            $unitTypes = UnitType::get()->pluck('display_name', 'id');
            $utilities = Utility::get()->pluck('display_name', 'id');
            $extraCharges = ExtraCharge::get()->pluck('display_name', 'id');
            $lateFees = LateFees::get()->pluck('display_name', 'id');
            return View('lease.create',compact('propertyTypes','partners','unitTypes','utilities','extraCharges','lateFees','leaseTypes','properties','tenants'));
        } else {
            return redirect()->back();
        }
    }
    public function store(Request $request)
    {

       
       if(!empty($request->id))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'property_name' => 'required',
                    'property_code' => 'required|unique:properties,property_code,'.$request->id,
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

        } else{
            $validator = \Validator::make(
                $request->all(), [
                   'property_name' => 'required',
                   'property_code' => 'required|unique:properties,property_code',
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

        }

        
        DB::beginTransaction();
        try{

                if(!empty($request->id))
                {
                    $property = Property::find($request->id);
                    

                } else{
                    $property = new Property;
                }
                $property->user_id = auth()->user()->id;
                $property->property_name       = $request->property_name;
                $property->property_code       = $request->property_code;
                $property->property_location       = $request->property_location;
                $property->property_type       = $request->property_type;
                $property->created_by       = auth()->user()->id;
                $property->save();

                if($property) {
                    $messages = 'Property successfully created';
                    if(!empty($request->id))
                    {
                        PropertyUnit::where('property_id',$request->id)->delete();
                        PropertyPaymentSetting::where('property_id',$request->id)->delete();
                        PropertyExtraCharges::where('property_id',$request->id)->delete();
                        PropertyLateFees::where('property_id',$request->id)->delete();
                        PropertyUtility::where('property_id',$request->id)->delete();
                        $messages = 'Property successfully updated';
                    }
                    /*--------Unit---------------------*/
                    if(is_array(@$request->unit_name) && count(@$request->unit_name) >0 ){
                        for ($i = 0;$i <= count($request->unit_name);$i++) {
                            if (!empty($request->unit_name[$i])) {
                                $unit = new PropertyUnit;
                                $unit->user_id = auth()->user()->id;
                                $unit->property_id = $property->id;
                                $unit->unit = $request->unit[$i];
                                $unit->unit_name = $request->unit_name[$i];
                                $unit->unit_floor = $request->unit_floor[$i];
                                $unit->rent_amount = $request->rent_amount[$i];
                                $unit->unit_type = $request->unit_type[$i];
                                $unit->bed_rooms = $request->bed_rooms[$i];
                                $unit->bath_rooms = $request->bath_rooms[$i];
                                $unit->total_rooms = $request->total_rooms[$i];
                                $unit->square_foot = $request->square_foot[$i];
                                $unit->save();

                            }
                        }
                    }

                    /*--------Commission---------------------*/
                    if(is_array(@$request->partners) && count(@$request->partners) >0 ){
                        for ($i = 0;$i <= count($request->partners);$i++) {
                            if (!empty($request->partners[$i])) {
                                $paymentSetting = new PropertyPaymentSetting;
                                $paymentSetting->user_id = $request->partners[$i];
                                $paymentSetting->property_id = $property->id;
                                $paymentSetting->commission_value = $request->commission_value[$i];
                                $paymentSetting->commission_type = $request->commission_type[$i];
                                $paymentSetting->payment_methods = $request->payment_methods[$i];
                                $paymentSetting->save();

                            }
                        }
                    }

                    /*--------Extra Charge---------------------*/
                    if(is_array(@$request->extra_charge_id) && count(@$request->extra_charge_id) >0 ){
                        for ($i = 0;$i <= count($request->extra_charge_id);$i++) {
                            if (!empty($request->extra_charge_id[$i])) {
                                $extraCharge = new PropertyExtraCharges;
                                $extraCharge->user_id = auth()->user()->id;
                                $extraCharge->property_id = $property->id;
                                $extraCharge->extra_charge_id = $request->extra_charge_id[$i];
                                $extraCharge->extra_charge_value = $request->extra_charge_value[$i];
                                $extraCharge->extra_charge_type = $request->extra_charge_type[$i];
                                $extraCharge->frequency = $request->frequency[$i];
                                $extraCharge->save();

                            }
                        }
                    }
                    /*--------Late Fees---------------------*/
                    if(is_array(@$request->late_fee_id) && count(@$request->late_fee_id) >0 ){
                        for ($i = 0;$i <= count($request->late_fee_id);$i++) {
                            if (!empty($request->late_fee_id[$i])) {
                                $latefee = new PropertyLateFees;
                                $latefee->user_id = auth()->user()->id;
                                $latefee->property_id = $property->id;
                                $latefee->late_fee_id = $request->late_fee_id[$i];
                                $latefee->late_fee_value = $request->late_fee_value[$i];
                                $latefee->late_fee_type = $request->late_fee_type[$i];
                                $latefee->frequency = $request->frequency[$i];
                                $latefee->save();

                            }
                        }
                    }


                    /*--------Utilities---------------------*/
                    if(is_array(@$request->utility_id) && count(@$request->utility_id) >0 ){
                        for ($i = 0;$i <= count($request->utility_id);$i++) {
                            if (!empty($request->utility_id[$i])) {
                                $latefee = new PropertyUtility;
                                $latefee->user_id = auth()->user()->id;
                                $latefee->property_id = $property->id;
                                $latefee->utility_id = $request->utility_id[$i];
                                $latefee->variable_cost = $request->variable_cost[$i];
                                $latefee->fixed_cost = $request->fixed_cost[$i];
                                $latefee->save();

                            }
                        }
                    }

             
                 DB::commit();
                return response()->json([
                    'message' => $messages
                ], 200);
            } else {
                return response()->json([
                    'errors' => 'Something went wrong!'
                ], 500);
            }
        
        } catch (Exception $exception) {
            \Log::info($exception->getMessage());
            return response()->json([
                'errors' => $exception->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('lease-edit')) {
            $property = Property::findOrFail($id);
            $propertyUnit = PropertyUnit::where('property_id',$id)->get();
            $paymentSetting = PropertyPaymentSetting::where('property_id',$id)->get();
            $propertyExtraCharges = PropertyExtraCharges::where('property_id',$id)->get();
            $propertyLateFees = PropertyLateFees::where('property_id',$id)->get();
            $propertyUtility = PropertyUtility::where('property_id',$id)->get();
            
            $propertyTypes = PropertyType::get()->pluck('display_name', 'id');
            $partners = User::where('role_id','2')->get()->pluck('first_name', 'id');
            $unitTypes = UnitType::get()->pluck('display_name', 'id');
            $utilities = Utility::get()->pluck('display_name', 'id');
            $extraCharges = ExtraCharge::get()->pluck('display_name', 'id');
            $lateFees = LateFees::get()->pluck('display_name', 'id');
            return View('lease.edit',compact('propertyTypes','partners','unitTypes','utilities','extraCharges','lateFees','property','propertyUnit','paymentSetting','propertyExtraCharges','propertyLateFees','propertyUtility'));
        } else {
            return redirect()->back();
        }
    }
     public function destroy($id)
    {
        if (\Auth::user()->can('lease-delete')) {

            $leaseExist = Lease::where('property_id',$id)->where('status','Approved')->count();
            if($leaseExist > 0){
                return redirect()->back()->with('error', __("You can't  delete this property."));
            }

            $property = Property::find($id);
            if ($property) {
                
                $property->delete();
                PropertyUnit::where('property_id',$id)->delete();
                PropertyPaymentSetting::where('property_id',$id)->delete();
                PropertyExtraCharges::where('property_id',$id)->delete();
                PropertyLateFees::where('property_id',$id)->delete();
                PropertyUtility::where('property_id',$id)->delete();
                return redirect()->route('property.index')->with('success', __('Property successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('Property not found.'));
            }
        } else {
            return redirect()->back();
        }
        
    }
     public function getUnits(Request $request)
    {
       
        $propertyUnit = PropertyUnit::where('property_id',$request->property_id)->groupby('unit_name_prefix')->orderby('id','DESC')->get();
       
        $output = '';
        $selected = '';
        $output .='<div class=""> <label for="unit_ids" class="form-label">Property Units</label> <span class="requiredLabel">*</span>';
              foreach($propertyUnit as $floor) {
                $allUnits = \App\Models\PropertyUnit::where('property_id',$floor->property_id)->where('unit_name_prefix',$floor->unit_name_prefix)->orderby('id','ASC')->get(); 

                $output .='<div class="floor" data-floor="floor-'.$floor->id .'"><h6 style="grid-column: span 12;"><span class="badge bg-label-primary">'.$floor->unit_floor .' ('.$floor->unit_name_prefix .')</span><button type="button" class="select-all btn btn-sm btn-primary" data-floor="floor-'.$floor->id .'">Select All</button></h6> ';
                foreach($allUnits as $unit) {
                    $is_rented =  ($unit->is_rented =='1') ? 'red' :'' ;
                    $is_rented_color =  ($unit->is_rented =='1') ? '#fff' :'' ;

                    $output .= '<div class="unit" style="background:'.$is_rented.';color:'.$is_rented_color.'">';
                    $output .= '<input type="checkbox" name="unit_ids[]" value="'.$unit->id.'" id="unit-'.$unit->id.'" ';
                    $output .= ($unit->is_rented == "1") ? 'disabled' : '';
                    $output .= '>';
                    $output .= '<label for="unit-'.$unit->id.'">'.$unit->unit_name.'</label>';
                    $output .= '</div>';

                    
                    }
                    $output .= '</div>';
                }
           $output .='</div>';

        return $output;
        
        
    }
    public function getUnitsold(Request $request)
    {
       
        $propertyUnits = PropertyUnit::where('property_id',$request->property_id)->get();
       
        $output = '';
        $selected = '';
        $output .=' <div class="select2-primary"><select class="form-control select2 form-select" aria-label="Floating label select example" name="unit_ids[]"  id="unit_ids" multiple="multiple" data-allow-clear="true">';
              foreach($propertyUnits as $unit) {
                $output .='<option  value="'.$unit->id.'"  >
                    '.ucfirst($unit->unit_name) .'
                </option>';
                }
           $output .=' </select></div>';

        return $output;
        
        
    }
   

    
}
