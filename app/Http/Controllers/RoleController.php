<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Auth;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:permission-browse',['only' => ['index']]);
        $this->middleware('permission:permission-add', ['only' => ['store']]);
        $this->middleware('permission:permission-edit', ['only' => ['update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        if(\Auth::user()->can('role-browse'))
        {
           
            $roles = Role::where('name', '!=','Admin')->orderBy('id','DESC')->get();
            return view('role.index')->with('roles', $roles);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }


    public function create()
    {
        if(\Auth::user()->can('role-add'))
        {
           $permissions = Permission::select('group_name')
            ->distinct()
            ->get();

            return view('role.create', ['permissions' => $permissions]);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('role-add'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:100|unique:roles,name',
                                   'permissions' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $name             = $request['name'];
            $role             = new Role();
            $role->name       = $name;
            $role->se_name       = $name;
            $permissions      = $request['permissions'];
            $role->save();

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->route('roles.index')->with('success' , 'Role successfully created.', 'Role ' . $role->name . ' added!');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function edit(Role $role)
    {
        if(\Auth::user()->can('role-edit'))
        {

            $user = \Auth::user();
            $permissions = Permission::select('group_name')
            ->distinct()
            ->get();

            $rolePermissions = \DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

            return view('role.edit', compact('role', 'permissions','rolePermissions'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }

    public function update(Request $request, Role $role)
    {

        if(\Auth::user()->can('role-edit'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:100|unique:roles,name,' . $role['id'],
                                   'permissions' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $user = \Auth::user();
           
            $input       = $request->except(['permissions','name']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach($p_all as $p)
            {
                $role->revokePermissionTo($p);
            }

            foreach($permissions as $permission)
            {

                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->route('roles.index')->with('success' , 'Role successfully updated.', 'Role ' . $role->name . ' updated!');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }


    public function destroy(Role $role)
    {
        if(\Auth::user()->can('role-delete'))
        {
            $role->delete();

            return redirect()->route('roles.index')->with('success', __('Role successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
