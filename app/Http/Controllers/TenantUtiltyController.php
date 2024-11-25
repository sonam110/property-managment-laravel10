<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use App\Models\Expense;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\TenantPropertyUtility;
class TenantUtiltyController extends Controller
{
    public function index()
    {   
        $propertyTypes = Property::get()->pluck('property_name', 'id');
        $tenants = Tenant::get()->pluck('full_name', 'id');
        return View('tenant-utility.index',compact('propertyTypes','tenants'));
    }
    public function tenantUtilityList(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = TenantPropertyUtility::select('tenant_property_utilities.*')
        ->with('property:id,property_name,property_code','tenant')
             ->when($startDate, function($query) use ($startDate) {
                    return $query->whereDate('tenant_property_utilities.bill_date', '>=', $startDate);
                })
                ->when($endDate, function($query) use ($endDate) {
                    return $query->whereDate('tenant_property_utilities.bill_date', '<=', $endDate);
                })
        ->orderBy('tenant_property_utilities.id', 'DESC');

        if($request->property_id !='')
        {
            $query->where('tenant_property_utilities.property_id', $request->property_id);
        }
        
        
        return datatables($query)
            ->editColumn('property_id', function ($query)
            {

                return $query->property->property_name.'('.$query->property->property_code.')';
            })
           
             ->editColumn('bill_date', function ($query)
            {

                return date('M d,Y',strtotime($query->bill_date));
            })
             ->editColumn('created_at', function ($query)
            {

                return date('M d,Y',strtotime($query->created_at));
            })
            
            ->addColumn('action', function ($query)
            {

                $edit =' <a href="#!" data-size="lg"
                                data-url="'.route('tenant-utility.edit', $query->id) .'" 
                                data-ajax-popup="true" class="btn btn-sm btn-primary"
                                data-bs-original-title="Expense Edit">
                                <i class="ti ti-pencil"></i>
                            </a>';
                $delete = '<a 
                                href="'.route('tenant-utility-destroy', $query->id) .'" 
                                 class="btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="ti ti-trash"></i>
                            </a>';
                $view =' <a href="'.route('tenant-utility.show', $query->id).'" class="btn btn-sm btn-info"
                                data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                <i class="ti ti-eye"></i>
                            </a>';
                

                return '<div class="btn-group btn-group-xs">'.$edit.$view.$delete.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

     public function create()
    {

        $properties = Property::pluck('property_name','id')->toArray();
        $tenants = Tenant::orderby('id','desc')->pluck('firm_name','id')->toArray();
        return view('tenant-utility.create', compact('properties','tenants'));
       
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //create new user
    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'bill_date'  => 'required',
            'energy_charge'  => 'required',
            'total_units'  => 'required',
            'tenant_id' => 'required|array',
            'tenant_id.*' => 'required|exists:tenants,id',
            'no_units_consume' => 'required|array',
            'no_units_consume.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $bill_month = date('m',strtotime($request->bill_date));
        $bill_year = date('Y',strtotime($request->bill_date));

        $existingUtility = TenantPropertyUtility::where('property_id', $request->property_id)
                        ->whereMonth('bill_date', $bill_month)
                        ->whereYear('bill_date', $bill_year)
                        ->first();
        

        if ($existingUtility) {
            return redirect()->back()->with('error', __('A utility bill for this property has already been uploaded for this month and year.'));
        }

       
        DB::beginTransaction();
        try {
        	$tenantDetails = [];
            $totalTenantUnit = 0;
            foreach ($request->tenant_id as $key => $tenantId) {
                $totalTenantUnit += $request->no_units_consume[$key];
                $tenantDetails[] = [
                    'tenant_id' => $tenantId,
                    'no_units_consume' => $request->no_units_consume[$key],
                ];
            }
           
            $energy_charge_as_per_bill =  $request->energy_charge+$request->fppas+$request->energy_duty+$request->tod_net_sum;
           	$per_unit_charge = $energy_charge_as_per_bill/$request->total_units;
           	$unit_lost = $request->total_units-$totalTenantUnit;;
           	$energy_losses = $unit_lost*$per_unit_charge;
           	$energy_losses_per_tenant_unit = $energy_losses/$totalTenantUnit;
            $energy_unit_per_unit = $per_unit_charge+$energy_losses_per_tenant_unit;
           
            
            $tenantUtility = new TenantPropertyUtility;
            $tenantUtility->property_id = $request->property_id;
            $tenantUtility->energy_charge = $request->energy_charge;
            $tenantUtility->fppas = $request->fppas;
            $tenantUtility->energy_duty = $request->energy_duty;
            $tenantUtility->tod_net_sum = $request->tod_net_sum;
            $tenantUtility->energy_charge_as_per_bill = $energy_charge_as_per_bill;
            $tenantUtility->total_units = $request->total_units;
            $tenantUtility->tenants_units =  json_encode($tenantDetails);
            $tenantUtility->tod_rebate_charge = $request->tod_rebate_charge;
            $tenantUtility->bill_date = (!empty($request->bill_date)) ? $request->bill_date: date('Y-m-d');
            $tenantUtility->per_unit_charge  = $per_unit_charge;
            $tenantUtility->total_tenant_units  = $totalTenantUnit;
            $tenantUtility->unit_lost  = $unit_lost;
            $tenantUtility->energy_losses  = $energy_losses;
            $tenantUtility->energy_losses_per_tenant_unit  = $energy_losses_per_tenant_unit;
            $tenantUtility->energy_unit_per_unit  = $energy_unit_per_unit;
            $tenantUtility->save();
           
            
            DB::commit();
            return redirect()->route('tenant-utility.index')->with('success', __('Utility successfully Added.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
           
        }
    }

     public function edit($id)
    {

        $tenantUtility = TenantPropertyUtility::findOrFail($id);
        $properties = Property::pluck('property_name','id')->toArray();
        $tenants = Lease::where('leases.property_id', $tenantUtility->property_id)->join('tenants','leases.tenant_id','tenants.id')
                           ->pluck('tenants.firm_name', 'tenants.id')->toArray();
        $tenantDetails = json_decode($tenantUtility->tenants_units, true);

        return view('tenant-utility.edit', compact('tenantUtility', 'properties','tenants','tenantDetails'));
       

    }
     public function update(Request $request, $id)
    {

        $validator = \Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'bill_date'  => 'required',
            'energy_charge'  => 'required',
            'total_units'  => 'required',
            'tenant_id' => 'required|array',
            'tenant_id.*' => 'required|exists:tenants,id',
            'no_units_consume' => 'required|array',
            'no_units_consume.*' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $bill_month = date('m',strtotime($request->bill_date));
        $bill_year = date('Y',strtotime($request->bill_date));

        $existingUtility = TenantPropertyUtility::where('property_id', $request->property_id)
                        ->whereMonth('bill_date', $bill_month)
                        ->whereYear('bill_date', $bill_year)
                        ->where('id', '!=', $id)
                        ->first();

        if ($existingUtility) {
            return redirect()->back()->with('error', __('A utility bill for this property has already been uploaded for this month and year.'));
        }
        

        DB::beginTransaction();
        try {
            $tenantUtility = TenantPropertyUtility::where('id',$id)->first();
        
            if(!$tenantUtility)
            {
                return redirect()->back()->with('error','Record not found');
            }

           	$tenantDetails = [];
            $totalTenantUnit = 0;
            foreach ($request->tenant_id as $key => $tenantId) {
                $totalTenantUnit += $request->no_units_consume[$key];
                $tenantDetails[] = [
                    'tenant_id' => $tenantId,
                    'no_units_consume' => $request->no_units_consume[$key],
                ];
            }
           
            $energy_charge_as_per_bill =  $request->energy_charge+$request->fppas+$request->energy_duty+$request->tod_net_sum;
            $per_unit_charge = $energy_charge_as_per_bill/$request->total_units;
            $unit_lost = $request->total_units-$totalTenantUnit;;
            $energy_losses = $unit_lost*$per_unit_charge;
            $energy_losses_per_tenant_unit = $energy_losses/$totalTenantUnit;
            $energy_unit_per_unit = $per_unit_charge+$energy_losses_per_tenant_unit;
           
            
            $tenantUtility->property_id = $request->property_id;
            $tenantUtility->energy_charge = $request->energy_charge;
            $tenantUtility->fppas = $request->fppas;
            $tenantUtility->energy_duty = $request->energy_duty;
            $tenantUtility->tod_net_sum = $request->tod_net_sum;
            $tenantUtility->energy_charge_as_per_bill = $energy_charge_as_per_bill;
            $tenantUtility->total_units = $request->total_units;
            $tenantUtility->tenants_units =  json_encode($tenantDetails);
            $tenantUtility->tod_rebate_charge = $request->tod_rebate_charge;
            $tenantUtility->bill_date = (!empty($request->bill_date)) ? $request->bill_date: date('Y-m-d');
            $tenantUtility->per_unit_charge  = $per_unit_charge;
            $tenantUtility->total_tenant_units  = $totalTenantUnit;
            $tenantUtility->unit_lost  = $unit_lost;
            $tenantUtility->energy_losses  = $energy_losses;
            $tenantUtility->energy_losses_per_tenant_unit  = $energy_losses_per_tenant_unit;
            $tenantUtility->energy_unit_per_unit  = $energy_unit_per_unit;
            $tenantUtility->save();

            DB::commit();
            return redirect()->route('tenant-utility.index')->with('success', __('Utility successfully updated.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
             return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = TenantPropertyUtility::with('property','tenant')->findOrFail($id);
        $tenantDetails = json_decode($data->tenants_units, true);
        return view('tenant-utility.show', compact('data','tenantDetails'));
        

    }

     public function destroy($id)
    {
        $tenantUtility = TenantPropertyUtility::find($id);
        if ($tenantUtility) {

            $tenantUtility->delete();
            return redirect()->route('tenant-utility.index')->with('success', __('Utility successfully deleted .'));
        } else {
            return redirect()->back()->with('error', __('Record not found.'));
        }
        
    }
    public function getTenantProperty(Request $request)
	{
	    // Fetch properties linked to the tenant from the lease table
	    $properties = Lease::where('leases.tenant_id', $request->tenantId)->join('properties','leases.property_id','properties.id')
	                       ->pluck('properties.property_name', 'properties.id');

	    
        $output = '';
        $selected = '';
        $output .='<select class="shadow-none state select2 form-select" id="floatingSelect" aria-label="Floating label select example" name="state" data-allow-clear="true"><option value="" selected> Select State</option>';
              foreach($properties as $key=> $property) {
                $output .='<option  value="'.$key.'"  >
                    '.ucfirst($property) .'
                </option>';
                }
           $output .=' </select>';

        return $output;
	}
    public function getTenantList(Request $request)
    {
        $tenants = Lease::where('leases.property_id', $request->property_id)->join('tenants','leases.tenant_id','tenants.id')
                           ->pluck('tenants.firm_name', 'tenants.id');

        $output = '';
        $selected = '';
        $output .='<select class="shadow-none state select2 form-select" id="floatingSelect" aria-label="Floating label select example" name="tenant_id" id="tenant_id" data-allow-clear="true"><option value="" selected> Select Tenant</option>';
              foreach($tenants as $key=> $tenant) {
                $output .='<option  value="'.$key.'"  >
                    '.ucfirst($tenant) .'
                </option>';
                }
           $output .=' </select>';

        return $output;
    }

}
