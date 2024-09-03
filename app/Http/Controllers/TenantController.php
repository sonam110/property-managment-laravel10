<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\Models\TenantContactInfo;
use App\Models\Lease;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use App\Models\TenantType;
class TenantController extends Controller
{

     public function __construct()
    {
        $this->middleware('permission:tenant-browse',['only' => ['index']]);
        $this->middleware('permission:tenant-add', ['only' => ['store']]);
        $this->middleware('permission:tenant-edit', ['only' => ['update']]);
        $this->middleware('permission:tenant-read', ['only' => ['show']]);
        $this->middleware('permission:tenant-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $data = Tenant::get();
        return View('tenant.index');
    }
    public function tenantList(Request $request)
    {
        $query = Tenant::orderBy('id','DESC');
       
        return datatables($query)
    
            ->addColumn('action', function ($query)
            {

                $edit =' <a class="btn btn-sm btn-primary" href="'.route('tenants.edit', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" title="Edit"><i class="fa fa-edit"></i></a>';
                $delete = '<a href="'.route('tenants-destroy', $query->id) .'" 
                                 class="btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>';

                $view =' <a class="btn btn-sm btn-info" href="'.route('tenants.show', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"  title="View"><i class="fa fa-eye"></i></a>';

                $lease =' <a class="btn btn-sm btn-secondary" href="'.route('tenant-leases', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"  title="View"><i class="fa fa-home"></i></a>';


                return '<div class="btn-group btn-group-xs">'.$edit.$view.$delete.$lease.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
    public function create()
    {
        if (\Auth::user()->can('tenant-add')) {
            return view('tenant.create');
        } else {
            return redirect()->back();
        }
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


        if(!empty($request->id))
        {

            $validator = \Validator::make($request->all(), [
                'full_name'      => 'required',
                'email'     => 'required|email|unique:tenants,email,'.$request->id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            $messages = 'Tenant successfully updated';

        } else{

            $validator = \Validator::make($request->all(), [
                'full_name'      => 'required',
                'email'     => 'required|email|unique:tenants,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            $messages = 'Tenant successfully created';

        }

        DB::beginTransaction();
        try {
            if(!empty($request->id))
            {
                $tenant = Tenant::find($request->id);

            } else{
                $tenant = new Tenant;
            }
            $tenant->user_id = auth()->user()->id;
            $tenant->full_name = $request->full_name;
            $tenant->firm_name = $request->firm_name;
            $tenant->email = $request->email;
            $tenant->phone  = $request->phone;
            $tenant->pan_no = $request->pan_no;
            $tenant->country = $request->country;
            $tenant->state = $request->state;
            $tenant->city = $request->city;
            $tenant->pan_no = $request->pan_no;
            $tenant->gst_no = $request->gst_no;
            $tenant->business_name = $request->business_name;
            $tenant->business_industry = $request->business_industry;
            $tenant->business_address = $request->business_address;
            $tenant->business_description = $request->business_description;
            $tenant->save();

            if($tenant){
                if(!empty($request->id))
                {
                    TenantContactInfo::where('tenant_id',$tenant->id)->delete();
                   
                }
                if(is_array(@$request->fullname) && count(@$request->fullname) >0 ){
                    for ($i = 0;$i <= count($request->fullname);$i++) {
                        if (!empty($request->fullname[$i])) {
                            $contactInfo = new TenantContactInfo;
                            $contactInfo->tenant_id = $tenant->id;
                            $contactInfo->contact_type = $request->contact_type[$i];
                            $contactInfo->full_name = $request->fullname[$i];
                            $contactInfo->email = $request->contact_email[$i];
                            $contactInfo->phone = $request->contact_phone[$i];
                            $contactInfo->position = $request->position[$i];
                            $contactInfo->save();

                        }
                    }
                }

            }

            DB::commit();
            return response()->json([
                    'message' => $messages
                ], 200);
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
            return response()->json([
                'errors' => $e->getMessage()
            ], 500);
           
        }
    }

     public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        $statsList = DB::table('states')->pluck('name', 'id');
        $tenantTypes = TenantType::get()->pluck('display_name', 'id');
        $tenantContactInfo = TenantContactInfo::where('tenant_id',$id)->get();
        return view('tenant.edit', compact('tenant','statsList','tenantContactInfo'));
        

    }

    public function getState(Request $request)
    {
       
        $statsList = DB::table('states')->where('country_id',$request->country_id)->get();
       
        $output = '';
        $selected = '';
        $output .='<select class="form-select shadow-none country" id="floatingSelect" aria-label="Floating label select example" name="country"><option value="" selected> Select State</option>';
              foreach($statsList as $state) {
                $output .='<option  value="'.$state->id.'"  >
                    '.ucfirst($state->name) .'
                </option>';
                }
           $output .=' </select>';

        return $output;
        
        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);
        $statsList = DB::table('states')->pluck('name', 'id');
        $tenantTypes = TenantType::get()->pluck('display_name', 'id');
        $tenantContactInfo = TenantContactInfo::where('tenant_id',$id)->get();
        return view('tenant.show', compact('tenant','statsList','tenantContactInfo'));
        

    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //update existing user data
    public function update(Request $request, $id)
    {

       
    }

     public function destroy($id)
    {
        if (\Auth::user()->can('tenant-delete')) {

            if ($id == 1) {
                return redirect()->back()->with('error', __('You can not delete By default Admin'));
            }
            $leaseExist = Lease::where('tenant_id',$id)->where('status','Approved')->count();
            if($leaseExist > 0){
                return redirect()->back()->with('error', __("You can't  delete this tenant."));
            }

            $user = User::find($id);
            if ($user) {
                
                $user->delete();
                $tenant = Tenant::where('user_id',$id)->delete();
                return redirect()->route('tenants.index')->with('success', __('Tenant successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('User not found.'));
            }
        } else {
            return redirect()->back();
        }
        
    }
    
}
