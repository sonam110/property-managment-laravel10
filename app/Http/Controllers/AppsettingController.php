<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class AppsettingController extends Controller
{
    public function index()
    {
        $data = AppSetting::first();
        return View('app-setting.index',compact('data'));
    }
    public function update(Request $request)
    {
        

        $validator = \Validator::make($request->all(), [
            'app_name'      => 'required',
            'mobile_no' => 'required|regex:/^(\+?1?[-. ]?)?(\(?\d{3}\)?[-. ]?)?\d{3}[-. ]?\d{4}$/',
            'email'     => 'required|email',
            'app_logo'          => 'image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

       
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }


        $destinationPath    = 'assets/uploads/';
        $image_name = Str::slug(substr($request->app_name, 0, 30));
        $saveFile = $request->old_app_logo;
        if($request->hasFile('app_logo'))
        {
            if($request->old_app_logo!='')
            {
                if(file_exists($destinationPath.$request->old_app_logo)){
                    unlink($destinationPath.$request->old_app_logo);
                }
            }
            $file       = $request->app_logo;
            $fileName   = value(function() use ($file, $image_name)
            {
              $newName = $image_name.'-'.time() . '.' . $file->getClientOriginalExtension();
              return strtolower($newName);
            });
            $request->app_logo->move($destinationPath, $fileName);
            // create image manager with desired driver
            $manager = new ImageManager(new Driver());

            // read image from file system
            $image = $manager->read($destinationPath.$fileName);
            $image->resize(80, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save($destinationPath.$fileName);
            $saveFile = $destinationPath.$fileName;
           /* if(file_exists($destinationPath.$fileName)){ 
                unlink($destinationPath.$fileName);
            }*/
        }

        $appsetting = Appsetting::first();
        $appsetting->app_name         = $request->app_name;
        $appsetting->email            = $request->email;
        $appsetting->mobile_no        = $request->mobile_no;
        $appsetting->address          = $request->address;
        $appsetting->description          = $request->description;
        $appsetting->Zipcode     = $request->Zipcode;
        $appsetting->website_url   = $request->website_url;
        $appsetting->app_logo         = $saveFile;
        $appsetting->save();
        if($appsetting)
        {
            return redirect()->route('app-setting.index')->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Oops!!!, something went wrong, please try again.');
           
        }
        return \Redirect()->back();

    }

}
