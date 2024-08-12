<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('permission:user-browse',['only' => ['users']]);
        $this->middleware('permission:user-add', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update','userAction']]);
        $this->middleware('permission:user-read', ['only' => ['show']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //users list
    public function index()
    {
        $data = User::where('role_id','!=','1')->get();
        $roles = Role::whereNotIn('id',['1','3'])->get()->pluck('name', 'id');
        return View('user.index',compact('roles','data'));
    }
    public function userList(Request $request)
    {
        $query = User::where('role_id','!=','1')->orderBy('id','DESC');
        return datatables($query)
            ->editColumn('name', function ($query)
            {

                return $query->name.' '.$query->lastname;
            })
            ->editColumn('role', function ($query)
            {

                return $query->role->name;
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

                return '<s<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                $edit =' <a href="#!" data-size="lg"
                                data-url="'.route('users.edit', $query->id) .'" 
                                data-ajax-popup="true" class="dropdown-item"
                                data-bs-original-title="User Edit">
                                <i class="ti ti-pencil"></i>
                            </a>';
                $delete = '<a 
                                href="'.route('user-delete', $query->id) .'" 
                                 class="dropdown-item"
                                onClick="return confirm(\'Are you sure you want to delete this?\');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="ti ti-trash"></i>
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
        if (\Auth::user()->can('user-add')) {
            return view('user.create', compact('roles','countries'));
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

        $validator = \Validator::make($request->all(), [
            'first_name'      => 'required',
            'mobile'         => 'required|regex:/^(\+?1?[-. ]?)?(\(?\d{3}\)?[-. ]?)?\d{3}[-. ]?\d{4}$/',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|same:confirm-password',
            'role_id'  => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        DB::beginTransaction();
        try {
           
            $user = new User;
            $user->role_id = $request->role_id;
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
            $role = Role::where('id', $request->role_id)->first();
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

            
            DB::commit();
            return redirect()->route('users.index')->with('success', __('User successfully created.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
           
        }
    }

     public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::whereNotIn('id',['1','3'])->get()->pluck('name', 'id');
        $countries = DB::table('countries')->get();
        $statsList = DB::table('states')->pluck('name', 'id');
        if (\Auth::user()->can('user-edit')) {
           

            return view('user.edit', compact('user', 'roles','countries','statsList'));
        } else {
            return redirect()->back();
        }

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
        return redirect()->route('user.index');
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
            'mobile'         => 'required|regex:/^(\+?1?[-. ]?)?(\(?\d{3}\)?[-. ]?)?\d{3}[-. ]?\d{4}$/',
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
            return redirect()->route('users.index')->with('success', __('User successfully updated.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
             return redirect()->back()->with('error', $e->getMessage());
        }
    }

     public function destroy($id)
    {

        if (\Auth::user()->can('user-delete')) {
            if ($id == 1) {
                return redirect()->back()->with('error', __('You can not delete By default Admin'));
            }

            $user = User::find($id);
            if ($user) {
    
                $user->delete();
                return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('User not found.'));
            }
        } else {
            return redirect()->back();
        }
    }

  
}
