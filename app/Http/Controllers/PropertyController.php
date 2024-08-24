<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyPaymentSetting;
use App\Models\PropertyType;
use App\Models\PropertyUnit;
use App\Models\UnitType;
use App\Models\Utility;
use App\Models\ExtraCharge;
use App\Models\LateFees;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
class PropertyController extends Controller
{

    public function unitsall()
    {
        $units = PropertyUnit::all();
        return response()->json($units);
    }
    public function index()
    {
        if (\Auth::user()->can('property-browse')) {
            $data = Property::get();
            $propertyTypes = PropertyType::get()->pluck('display_name', 'id');
            $partners = User::get()->pluck('first_name', 'id');
            return View('property.index',compact('propertyTypes','data','partners'));
        } else {
            return redirect()->back();
        }
    }
    public function propertyList(Request $request)
    {
        $query = Property::orderBy('id','DESC');
        if(!empty($request->property_id))
        {
            $query->where('id', $request->property_id);
        }
        if($request->status!='')
        {
            $query->where('status', $request->status);
        }
        return datatables($query)
            ->editColumn('unit', function ($query)
            {
                $totalCount = PropertyUnit::where('property_id',$query->id)->count();
                return $totalCount;
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

                 $edit =' <a class="btn btn-sm btn-primary" href="'.route('property.edit', $query->id) .'" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                $delete = '<a href="'.route('property-destroy', $query->id) .'" 
                                 class="btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>';
                $copy =' <a class="btn btn-sm btn-info" href="'.route('property-copy', $query->id) .'"  onClick="return confirm(\'Are you sure you want to copy this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy"><i class="fa fa-copy"></i></a>';

                $view =' <a class="btn btn-sm btn-warning" href="'.route('property-units', $query->id) .'" data-toggle="tooltip" data-placement="top" title="Units" data-original-title="Units"><i class="fa fa-eye"></i></a>';


                

                return '<div class="btn-group btn-group-xs">'.$edit.$delete.$copy.$view.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

     public function create()
    {
        if (\Auth::user()->can('property-add')) {
            $partners = User::where('role_id','2')->get()->pluck('first_name', 'id');
            $unitTypes = UnitType::get()->pluck('display_name', 'id');
            return View('property.create',compact('partners','unitTypes'));
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
                    'unit_name_prefix.*' => [
                        'required',
                        'distinct',
                        'string'
                    ],
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
                   'unit_name_prefix.*' => [
                        'required',
                        'distinct',
                        'string'
                    ],
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
                        PropertyUnit::where('property_id',$property->id)->delete();
                        PropertyPaymentSetting::where('property_id',$property->id)->delete();
                        
                        $messages = 'Property successfully updated';
                    }
                    
                    /*--------Unit---------------------*/

                    if(is_array(@$request->unit_name_prefix) && count(@$request->unit_name_prefix) >0 ){

                        for ($i = 0;$i <= count($request->unit_name_prefix);$i++) {
                            if (!empty($request->unit_name_prefix[$i])) {

                                $total_shop = (!empty($request->total_shop[$i])) ? $request->total_shop[$i] :'1';
                                for ($j=1; $j <= $total_shop ; $j++) { 
                                    $unit = new PropertyUnit;
                                    $unit->property_id = $property->id;
                                    $unit->property_code = $property->property_code;
                                    $unit->unit_name = $request->unit_name_prefix[$i].'-'.$j;
                                    $unit->unit_floor = $request->unit_floor[$i];
                                    $unit->unit_name_prefix = $request->unit_name_prefix[$i];
                                    $unit->unit_type = $request->unit_type[$i];
                                    $unit->total_shop = $request->total_shop[$i];
                                    $unit->save();
                                   
                                }

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
                                $paymentSetting->save();

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
        if (\Auth::user()->can('property-edit')) {
            $property = Property::findOrFail($id);
            $propertyUnit = PropertyUnit::where('property_id',$id)->groupby('unit_name_prefix')->orderby('id','ASC')->get();
            $paymentSetting = PropertyPaymentSetting::where('property_id',$id)->with('partner')->get();
            $unitTypes = UnitType::get()->pluck('display_name', 'id');
            $partners = User::where('role_id','2')->get()->pluck('first_name', 'id');
           
            return View('property.edit',compact('partners','property','propertyUnit','paymentSetting','unitTypes'));
        } else {
            return redirect()->back();
        }
    }
    public function propertyUnits($id)
    {
        if (\Auth::user()->can('property-edit')) {
            $property = Property::findOrFail($id);
            $propertyUnit = PropertyUnit::where('property_id',$id)->groupby('unit_name_prefix')->orderby('id','DESC')->get();
            $paymentSetting = PropertyPaymentSetting::where('property_id',$id)->get();
            $unitTypes = UnitType::get()->pluck('display_name', 'id');
            $partners = User::where('role_id','2')->get()->pluck('first_name', 'id');
           
            return View('property.units',compact('partners','property','propertyUnit','paymentSetting','unitTypes'));
        } else {
            return redirect()->back();
        }
    }
     public function destroy($id)
    {
        if (\Auth::user()->can('property-delete')) {

            $leaseExist = Lease::where('property_id',$id)->where('status','Approved')->count();
            if($leaseExist > 0){
                return redirect()->back()->with('error', __("You can't  delete this property."));
            }

            $property = Property::find($id);
            if ($property) {
                
                $property->delete();
                PropertyUnit::where('property_id',$id)->delete();
                PropertyPaymentSetting::where('property_id',$id)->delete();
        
                return redirect()->route('property.index')->with('success', __('Property successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('Property not found.'));
            }
        } else {
            return redirect()->back();
        }
        
    }
   public function copy($id)
    {
        if (\Auth::user()->can('property-edit')) {
            $property = Property::findOrFail($id);

            $newProperty = $property->replicate(); 
            
            $newPropertyCode = $this->generateUniquePropertyCode();
            $newProperty->property_code = $newPropertyCode; 

            $newProperty->save(); // Save the new property
            $newPropertyId = $newProperty->id; 

            $propertyUnits = PropertyUnit::where('property_id', $id)->get();
            foreach ($propertyUnits as $unit) {
                $newUnit = $unit->replicate(); // Clone the unit record
                $newUnit->property_id = $newPropertyId; // Set the new property ID
                $newUnit->save(); // Save the new unit
            }

            // Copy Property Payment Settings
            $paymentSettings = PropertyPaymentSetting::where('property_id', $id)->get();
            foreach ($paymentSettings as $setting) {
                $newSetting = $setting->replicate(); // Clone the setting record
                $newSetting->property_id = $newPropertyId; // Set the new property ID
                $newSetting->save(); // Save the new setting
            }


            // Redirect back with a success message
            return redirect()->back()->with('success', __('Data successfully copied.'));
        } else {
            return redirect()->back()->with('error', __('You do not have permission to perform this action.'));
        }
    }

    // Function to generate a unique property code
    private function generateUniquePropertyCode()
    {
        // Generate a unique property code, for example, using a timestamp and random number
        $timestamp = time();
        $randomNumber = rand(1000, 9999);
        return "PROP-{$timestamp}-{$randomNumber}";
    }


}
