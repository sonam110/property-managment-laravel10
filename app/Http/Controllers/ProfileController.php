<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use Exception;
use DB;
use Str;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
     public function index()
    {
        $user = \Auth::user();
        $countries = DB::table('countries')->get();
        $statsList = DB::table('states')->pluck('name', 'id');
        return View('user-profile.index',compact('user','countries','statsList'));
    }
    public function update(Request $request, $id)
    {

        $validator = \Validator::make($request->all(), [
            'first_name'      => 'required',
            'mobile'         => 'required|regex:/^(\+?1?[-. ]?)?(\(?\d{3}\)?[-. ]?)?\d{3}[-. ]?\d{4}$/',
            'email'     => 'email|required|unique:users,email,'.$id,
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
            $destinationPath    = 'assets/uploads/';
            $image_name = Str::slug(substr($request->first_name, 0, 30));
            $saveFile = $request->old_profile_pic;
            if($request->hasFile('profile_pic'))
            {
                if($request->old_profile_pic!='')
                {
                    if(file_exists($destinationPath.$request->old_profile_pic)){
                        unlink($destinationPath.$request->old_profile_pic);
                    }
                }
                $file       = $request->profile_pic;
                $fileName   = value(function() use ($file, $image_name)
                {
                  $newName = $image_name.'-'.time() . '.' . $file->getClientOriginalExtension();
                  return strtolower($newName);
                });
                $request->profile_pic->move($destinationPath, $fileName);
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
            $user->profile_pic         = $saveFile;
            $user->save();
           
            DB::commit();
            return redirect()->route('user-profile.index')->with('success', __('Profile successfully updated.'));
        } catch (\Throwable $e) {
            \Log::error($e);
            DB::rollback();
             return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function changePasswordUpdate(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'old_password'              => ['required'],
            'new_password'              => ['required', 'confirmed', 'min:6', 'max:25'],
            'new_password_confirmation' => ['required']
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        
        $matchpassword  = User::find(Auth::user()->id)->password;
        if(\Hash::check($request->old_password, $matchpassword))
        {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('change-password')->with('success', __('Password successfully changed.'));
            
        }
        else
        {
            return redirect()->route('change-password')->with('error', 'Incorrect password, Please try again with correct password.');
           
        }
        return \Redirect()->back();
    }
}
