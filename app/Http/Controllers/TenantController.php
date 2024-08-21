<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
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
    public function index()
    {
        $data = User::where('role_id','3')->get();
        $roles = Role::where('name','Tenant')->get()->pluck('name', 'id');
        $tenantTypes = TenantType::get()->pluck('display_name', 'id');
        return View('tenant.index',compact('roles','data','tenantTypes'));
    }
    public function tenantList(Request $request)
    {
        $query = User::where('role_id','3')->orderBy('id','DESC');
        return datatables($query)
            
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

                return '<s<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                $edit =' <a class="btn btn-sm btn-primary" href="'.route('tenants.edit', $query->id) .'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                $delete = '<a href="'.route('tenants-destroy', $query->id) .'" 
                                 class="btn btn-sm btn-danger"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>';


                return '<div class="btn-group btn-group-xs">'.$edit.$delete.'</div>';
            })
        ->escapeColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
    public function create()
    {

        
        $user = \Auth::user();
        $roles = Role::whereNotIn('id',['1','3'])->get()->pluck('name', 'id');
        $countries = DB::table('countries')->get();
        $tenantTypes = TenantType::get()->pluck('display_name', 'id');
        if (\Auth::user()->can('tenant-add')) {
            return view('tenant.create', compact('roles','countries','tenantTypes'));
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
                'first_name'      => 'required',
                'email'     => 'required|email|unique:users,email,'.$request->id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            

        } else{

            $validator = \Validator::make($request->all(), [
                'first_name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required|min:6|same:confirm_password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

        }

        DB::beginTransaction();
        try {
            if(!empty($request->id))
            {
                $user = User::find($request->id);

            } else{
                $user = new User;
            }
            $user->role_id = '3';
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->email  = $request->email;
            $user->password =  Hash::make($request->password);
            $user->mobile = $request->mobile;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->national_id_no = $request->national_id_no;
            $user->postal_address = $request->postal_address;
            $user->residential_address = $request->residential_address;
            $user->created_by = auth()->user()->id;
            $user->save();

           
            //Role and permission sync
            $role = Role::where('id','3')->first();
            $permissions = $role->permissions->pluck('name');
            
            $user->assignRole($role->name);
            foreach ($permissions as $key => $permission) {
                $user->givePermissionTo($permission);
            }


            //Delete if entry exists
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            $token = \Str::random(64);
            DB::table('password_reset_tokens')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => \Carbon\Carbon::now()
            ]);

            if($user){
                $tenant = Tenant::where('user_id',$request->id)->first();
                if(!empty($tenant)){
                    $tenant =  Tenant::find($tenant->id);
                    $messages = 'Tenant successfully updated';
                } else {
                    $tenant = new Tenant;
                    $messages = 'Tenant successfully created';
                }
                
                $tenant->user_id = $user->id;
                $tenant->unique_id = \Str::random(10);
                $tenant->tenant_type = $request->tenant_type;
                $tenant->gender = $request->gender;
                $tenant->merital_status = $request->merital_status;
                $tenant->kin_name = $request->kin_name;
                $tenant->kin_mobile = $request->kin_mobile;
                $tenant->kin_relation = $request->kin_relation;
                $tenant->emergency_contact_name = $request->emergency_contact_name;
                $tenant->emergency_contact_mobile = $request->emergency_contact_mobile;
                $tenant->emergency_contact_email = $request->emergency_contact_email;
                $tenant->emergency_contact_relationship = $request->emergency_contact_relationship;
                $tenant->emergency_postal_address = $request->emergency_postal_address;
                $tenant->emergency_residential_address = $request->emergency_residential_address;
                $tenant->employment_status = $request->employment_status;
                $tenant->employment_status_mobile = $request->employment_status_mobile;
                $tenant->employment_status_email = $request->employment_status_email;
                $tenant->employment_postal_address = $request->employment_postal_address;
                $tenant->employment_residential_address = $request->employment_residential_address;
                $tenant->business_name = $request->business_name;
                $tenant->business_industry = $request->business_industry;
                $tenant->license_no = $request->license_no;
                $tenant->tax_id = $request->tax_id;
                $tenant->business_address = $request->business_address;
                $tenant->business_description = $request->business_description;
                $tenant->save();

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
        $user = User::findOrFail($id);
        $tenant = Tenant::where('user_id',$id)->first();
        $roles = Role::whereNotIn('id',['1','3'])->get()->pluck('name', 'id');
        $countries = DB::table('countries')->get();
        $statsList = DB::table('states')->pluck('name', 'id');
        $tenantTypes = TenantType::get()->pluck('display_name', 'id');
        
        return view('tenant.edit', compact('user', 'roles','countries','statsList','tenantTypes','tenant'));
        

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
    public function show()
    {
        return redirect()->route('tenants.index');
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

        $validator = \Validator::make($request->all(), [
            'first_name'      => 'required',
            'mobile'           => 'required',
            'email'     => 'email|required|unique:users,email,'.$id,
            'role_id'  => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        DB::beginTransaction();
        try {
            $user = User::where('id',$id)->first();
        
            if(!$user)
            {
                return redirect()->back()->with('error','User not found');
            }
            if($user->role_id=='1')
            {
                return redirect()->back()->with('error','Record not found');
            }
            
            $user->role_id = $request->role_id;
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->email  = $request->email;
            $user->mobile = $request->mobile;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->national_id_no = $request->national_id_no;
            $user->postal_address = $request->postal_address;
            $user->residential_address = $request->residential_address;
            $user->save();

            //delete old role and permissions
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            DB::table('model_has_permissions')->where('model_id', $user->id)->delete();

            //Role and permission sync
            $role = Role::where('id', $request->role_id)->first();
            $permissions = $role->permissions->pluck('name');
            
            $user->assignRole($role->name);
            foreach ($permissions as $key => $permission) {
                $user->givePermissionTo($permission);
            }
           
            DB::commit();
            return redirect()->route('tenants.index')->with('success', __('User successfully updated.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
             return redirect()->back()->with('error', $e->getMessage());
        }
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
