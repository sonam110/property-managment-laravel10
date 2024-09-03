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
use App\Models\LeaseUtilityDeposite;
use App\Models\LeaseExtraCharge;
use App\Models\LeaseUtility;
use App\Models\AppSetting;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use PDF;
class LeaseController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:invoice-browse',['only' => ['index']]);
        $this->middleware('permission:invoice-read', ['only' => ['show']]);
    }

    public function index($id = NULL)
    {
        if (\Auth::user()->can('lease-browse')) {
            $data = Lease::get();
            $propertyTypes = Property::get()->pluck('property_name', 'id');
            $partners = User::get()->pluck('first_name', 'id');
            $tenants = Tenant::get()->pluck('firm_name', 'id');
            $id = $id;
            return View('lease.index',compact('propertyTypes','data','partners','tenants','id'));
        } else {
            return redirect()->back();
        }
    }

    public function generatePDF($id)
    {
        $lease = Lease::where('id',$id)->with('property','tenant')->first();
        $LeaseUtilityDeposite = LeaseUtilityDeposite::where('lease_id',$id)->with('utilityInfo')->get();
        $leaseExtraCharges = LeaseExtraCharge::where('lease_id',$id)->with('extraCharge')->get();
        $leaseUtilities = LeaseUtility::where('lease_id',$id)->get();
        $appSetting = AppSetting::first();
        $invoice_prefix = (!empty($appSetting->invoice_prefix)) ? $appSetting->invoice_prefix :'INV';
        $invoice_number = $invoice_prefix.'-'.rand(0,99999);
        $total_square = $lease->total_square;
        $price = $lease->price;
        $square_foot = $lease->square_foot;
        $price_per_sqare_ft = $price;
        $monthly_rent =  $total_square * $price_per_sqare_ft;
        $cam_amount =  $total_square * $lease->camp_price;
        $data =[
            'lease' => $lease,
            'LeaseUtilityDeposite' =>$LeaseUtilityDeposite,
            'leaseExtraCharges' =>$leaseExtraCharges,
            'leaseUtilities' =>$leaseUtilities,
            'invoice_number' =>$invoice_number,
            'monthly_rent' =>$monthly_rent,
            'cam_amount' =>$cam_amount,
        ];
        // Load the view and generate the PDF
        //return view('lease.lease-template',compact($data));
        $pdf = PDF::loadView('lease.lease-temp', $data);

        $fileName = $lease->unique_id.'.pdf';
        // Save the PDF to a temporary location
        $pdfPath = storage_path('app/public/uploads/' . $fileName);

        $pdf->save($pdfPath);

        // Generate the URL to access the PDF
    $fullPath = url('storage/uploads/' . $fileName);
    $unit_ids = explode(',', $lease->unit_ids);

    $propertyUnit = PropertyUnit::where('property_id',$lease->property_id)->groupby('unit_name_prefix')->orderby('id','ASC')->get();
    // Redirect to the PDF viewer
    return view('lease.lease-pdf', compact('fullPath','propertyUnit','unit_ids'));
    }


    public function contractDocument()
    {
        if (\Auth::user()->can('lease-browse')) {
            $data = Lease::pluck('unique_id','id')->toArray();
            $propertyTypes = Property::get()->pluck('property_name', 'id');
            $partners = User::get()->pluck('first_name', 'id');
            return View('lease.contract-document',compact('data'));
        } else {
            return redirect()->back();
        }
    }
    public function fetchLeaseData(Request $request)
    {
        $lease = Lease::with('property','tenant')->find($request->id);

        return response()->json([
            'content' => $this->generateLeaseContent($lease,$request)
        ]);
    }

public function previewPdf(Request $request, $id)
{
    $content = $request->input('content');
    $pdf = PDF::loadHTML($content); // Use a PDF library like Dompdf or Snappy
    $pdfPath = storage_path('app/public/lease_preview.pdf');
    $pdf->save($pdfPath);

    return response()->json(['pdfUrl' => asset('storage/lease_preview.pdf')]);
}


private function generateLeaseContent($lease,$request)
{
    $appSetting = AppSetting::first();
    $total_square = $lease->total_square;
    $price_per_sqare_ft = $lease->price;
    $monthly_rent =  $total_square * $price_per_sqare_ft;
    $cam_amount =  $total_square * $lease->camp_price;
    // Generate dynamic content using the lease data
    $content = "Lease Agreement for {$lease->property_name}...";
    // Replace placeholders with actual data
    $content = str_replace([
        '{owner_name}', '{owner_address}', '{owner_phone}', '{owner_email}', '{property_name}',
        '{property_code}', '{lease_area_of_sq}', '{property_address}', '{tenant_name}', '{tenant_address}',
        '{tenant_phone}', '{tenant_email}', '{lease_start_date}', '{monthly_rent_amount}', '{lease_price_per_sq}',
        '{lease_units}', '{lease_end}', '{lease_cam}'
    ], [
        $appSetting->app_name, $appSetting->address, $appSetting->mobile_no, $appSetting->email, $lease->property->property_name,
        $lease->property->property_code, $lease->total_square, $lease->property->location, $lease->tenant->firm_name, $lease->tenant->business_address,
        $lease->tenant->phone, $lease->tenant->email, $lease->start_date, $monthly_rent, $lease->price,
        $lease->unit_ids, $lease->end_month, $cam_amount
    ], $request->content);

    return $content;
}

    
    public function leaseList(Request $request)
    {
        $query = Lease::orderBy('id','DESC')->with('property','tenant');
       
        if(!empty($request->property_id))
        {
            $query->where('property_id', $request->property_id);
        }
        if(!empty($request->tenant_id))
        {
            $query->where('tenant_id', $request->tenant_id);
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
            ->editColumn('tenant_id', function ($query)
            {
                
                return $query->tenant->firm_name;
            })
           
            ->editColumn('status', function ($query)
            {
                if ($query->status == 'Approved')
                {
                    $status = 'Approved';
                    $class='bg-label-success';
                }
                elseif ($query->status == 'Processing')
                {
                    $status = 'Processing';
                    $class='bg-label-info';
                }
                else
                {
                    $status = 'Pending';
                    $class='bg-label-primary';
                }

                return '<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                if($query->status != 'Approved') {
                    $edit =' <a class="btn btn-sm btn-primary" href="'.route('leases.edit', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                } else{
                    $edit ='';
                }
                $delete = '<a href="'.route('leases-destroy', $query->id) .'" 
                                 class="btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>';
                $view =' <a class="btn btn-sm btn-primary" href="'.route('generate-pdf', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-eye"></i></a>';



                return '<div class="btn-group btn-group-xs">'.$edit.$view.$delete.'</div>';
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
            $utilities = Utility::pluck('display_name', 'id')->toArray();
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
                    'tenant_id' => 'required|exists:tenants,id',
                    'property_id' => 'required|exists:properties,id',
                    'unit_ids.*' => 'required','unit_ids' => 'required|array|min:1',
                    'unit_ids.*' => 'integer|distinct',
                    'total_square' => 'required',
                    'price' => 'required',
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $checkLeaseApproved = Lease::where('id',$request->id)->where('status','Approved')->first();
            if(!empty($checkLeaseApproved)){
                return response()->json([
                    'errors' => "You can't' edit this lease"
                ], 422);
            }

        } else{
            $validator = \Validator::make(
                $request->all(), [
                    'tenant_id' => 'required|exists:tenants,id',
                    'property_id' => 'required|exists:properties,id',
                    'unit_ids' => 'required|array|min:1',
                    'unit_ids.*' => 'integer|distinct',
                    'total_square' => 'required',
                    'price' => 'required',
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
                    $lease = Lease::find($request->id);
                    

                } else{
                    $lease = new Lease;
                }
                $appSetting = AppSetting::first();
                $lease_prefix = (!empty($appSetting->lease_prefix)) ? $appSetting->lease_prefix :'LS';
                $unit_ids  = (!empty($request->unit_ids)) ? implode(',',$request->unit_ids) :'';
                
                $lease->user_id = auth()->user()->id;
                $lease->unique_id       = $lease_prefix.'-'.rand(0,99999);
                $lease->property_id       = $request->property_id;
                $lease->tenant_id       = $request->tenant_id;
                $lease->unit_ids       = $unit_ids;
                $lease->start_date       = (!empty($request->start_date)) ? $request->start_date :date('Y-m-d');
                $lease->due_on       = $request->due_on;
                $lease->total_square       = $request->total_square;
                $lease->price       = $request->price;
                $lease->fixed_price       = $request->fixed_price;
                $lease->square_foot       = $request->square_foot;
                $lease->cam_square_foot       = $request->cam_square_foot;
                $lease->camp_price       = $request->camp_price;
                $lease->camp_fixed_price       = $request->camp_fixed_price;
                $lease->month       = $request->month;
                $lease->end_month       = $request->end_month;
                $lease->inc_percenatge       = $request->inc_percenatge;
                $lease->status       = $request->status;
                $lease->created_by       = auth()->user()->id;
                $lease->save();


                if($lease) {

                    $messages = 'Lease successfully created';

                    if(!empty($request->id))
                    {
                        LeaseUtilityDeposite::where('lease_id',$request->id)->delete();
                        LeaseExtraCharge::where('lease_id',$request->id)->delete();
                        LeaseUtility::where('lease_id',$request->id)->delete();
        
                        $messages = 'Lease successfully updated';
                    }
                    /*--------Unit---------------------*/
                    if(is_array(@$request->deposit_amount) && count(@$request->deposit_amount) >0 ){
                        for ($i = 0;$i <= count($request->deposit_amount);$i++) {
                            if (!empty($request->deposit_amount[$i])) {
                                $leaseDeposit = new LeaseUtilityDeposite;
                                $leaseDeposit->lease_id  = $lease->id;
                                $leaseDeposit->property_id  = $request->property_id ;
                                $leaseDeposit->utility = $request->utility[$i];
                                $leaseDeposit->deposit_amount = $request->deposit_amount[$i];
                                $leaseDeposit->save();
                                

                            }
                        }
                    }
                   
                   
                    /*--------Extra Charge---------------------*/
                    if(is_array(@$request->extra_charge_value) && count(@$request->extra_charge_value) >0 ){
                        for ($i = 0;$i <= count($request->extra_charge_value);$i++) {
                            if (!empty($request->extra_charge_value[$i])) {
                                $extraCharge = new LeaseExtraCharge;
                                $extraCharge->lease_id = $lease->id;
                                $extraCharge->property_id = $request->property_id;
                                $extraCharge->property_id = $request->tenant_id;
                                $extraCharge->extra_charge_id = $request->extra_charge_id[$i];
                                $extraCharge->extra_charge_value = $request->extra_charge_value[$i];
                                $extraCharge->extra_charge_type = $request->extra_charge_type[$i];
                                $extraCharge->frequency = $request->frequency[$i];
                                $extraCharge->save();

                            }
                        }
                    }
                   

                    /*--------Utilities---------------------*/
                    if(is_array(@$request->utility_id) && count(@$request->utility_id) >0 ){
                        for ($i = 0;$i <= count($request->utility_id);$i++) {
                            if (!empty($request->utility_id[$i])) {
                                $leaseutility = new LeaseUtility;
                                $leaseutility->lease_id = $lease->id;
                                $leaseutility->property_id = $request->property_id;
                                $leaseutility->tenant_id = $request->tenant_id;
                                $leaseutility->utility_id = $request->utility_id[$i];
                                $leaseutility->variable_cost = $request->variable_cost[$i];
                                $leaseutility->fixed_cost = $request->fixed_cost[$i];
                                $leaseutility->save();

                            }
                        }
                    }

                   
                    if($request->status ='Approved'){
                        PropertyUnit::whereIn('id',$request->unit_ids)->update(['is_rented'=>'1']);
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
            $lease = Lease::findOrFail($id);
            $checkLeaseApproved = Lease::where('id',$id)->where('status','Approved')->first();
            if(!empty($checkLeaseApproved)){
               return redirect()->route('leases.index')->with('error', __("You can't  edit this lease."));
            }
            $unit_ids = explode(',', $lease->unit_ids);

            $propertyUnit = PropertyUnit::where('property_id',$lease->property_id)->groupby('unit_name_prefix')->orderby('id','ASC')->get();
            $rented_units = PropertyUnit::select('id')->where('property_id',$lease->property_id)->where('is_rented','1')->orderby('id','ASC')->get()->toArray();
            $properties = Property::pluck('property_name','id')->toArray();
            $tenants = Tenant::pluck('firm_name','id')->toArray();
            $leaseDeposits = LeaseUtilityDeposite::where('lease_id',$id)->get();
            $leaseExtraCharges = LeaseExtraCharge::where('lease_id',$id)->get();;
            $leaseUtilities = LeaseUtility::where('lease_id',$id)->get();;
            $partners = User::where('role_id','2')->get()->pluck('first_name', 'id');
            $utilities = Utility::pluck('display_name', 'id')->toArray();
            $extraCharges = ExtraCharge::get()->pluck('display_name', 'id');
            return View('lease.edit',compact('lease','properties','tenants','leaseDeposits','leaseExtraCharges','leaseUtilities','utilities','extraCharges','propertyUnit','unit_ids','rented_units'));
        } else {
            return redirect()->back();
        }
    }
     public function destroy($id)
    {
        if (\Auth::user()->can('lease-delete')) {

            $leaseExist = Lease::where('id',$id)->where('status','Approved')->count();
            if($leaseExist > 0){
                return redirect()->back()->with('error', __("You can't  delete this lease."));
            }

            $lease = Lease::find($id);
            if ($lease) {
                
                $lease->delete();
                LeaseUtilityDeposite::where('lease_id',$id)->delete();
                LeaseExtraCharge::where('lease_id',$id)->delete();
                LeaseUtility::where('lease_id',$id)->delete();
                return redirect()->route('leases.index')->with('success', __('Lease successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('Lease not found.'));
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
