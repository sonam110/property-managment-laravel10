<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyType;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
class PropertySettingController extends Controller
{
    public function index()
    {
        $propertyTypes = PropertyType::get();
        return View('property-type.index',compact('propertyTypes'));
    }
}
