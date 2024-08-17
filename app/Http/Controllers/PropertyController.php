<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
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
    public function index()
    {
        $data = Property::get();
        $propertyTypes = PropertyType::get()->pluck('display_name', 'id');
        $partners = User::get()->pluck('first_name', 'id');
        return View('property.index',compact('propertyTypes','data','partners'));
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

                return '<s<span class="badge '.$class.' text-capitalize ">' . $status . '</span>';
            })

            ->addColumn('action', function ($query)
            {

                $edit =' <a href="#!" data-size="lg"
                                data-url="'.route('property.edit', $query->id) .'" 
                                data-ajax-popup="true" class="dropdown-item"
                                data-bs-original-title="User Edit">
                                <i class="ti ti-pencil"></i>
                            </a>';
                $delete = '<a 
                                href="'.route('property-delete', $query->id) .'" 
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
        $propertyTypes = PropertyType::get()->pluck('display_name', 'id');
        $partners = User::where('role_id','2')->get()->pluck('first_name', 'id');
        $unitTypes = UnitType::get()->pluck('display_name', 'id');
        $utilities = Utility::get()->pluck('display_name', 'id');
        $extraCharges = ExtraCharge::get()->pluck('display_name', 'id');
        $lateFees = LateFees::get()->pluck('display_name', 'id');
        return View('property.create',compact('propertyTypes','partners','unitTypes','utilities','extraCharges','lateFees'));
    }
}
