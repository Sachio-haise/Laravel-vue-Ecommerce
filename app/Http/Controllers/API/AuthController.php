<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerifyMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request){
         $validate = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validate->fails()){
           return response()->json(['errors'=>$validate->errors()]);
        }
        $user = User::where('email',$request->email)->first();
        if($user){
           $check_pwd = Hash::check($request->password,$user->password);
           if(!$check_pwd){
           return response()->json(['errors'=>['password'=>'Incorrect password.']]);
           }

           $token = $user->createToken($user->email . '_' .now(),[$user->role->role]);

           $ramdom = random_int(100000, 999999);
           $user->update([
            'check_code' => $ramdom
           ]);
           $data = [
               'random'=>$ramdom,
               'name' => $user->name,
               'email' => $user->email,
               'token' => $token
           ];

          if(!$user->hasVerifiedEmail()){
            Mail::to($user->email)->send(new EmailVerifyMail($data));
            return response()->json(['token'=>$token->accessToken,'user'=>$user]);
            }

            return response()->json(['token'=>$token->accessToken,'user'=>$user]);

        }else{
           return response()->json(['errors'=>['email'=>'Email does\'t not exist!']]);
        }
    }

    public function register(Request $request){
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'profile' => 'required|mimes:png,jpg'
        ]);
        if($validate->fails()){
           return response()->json(['errors'=>$validate->errors()]);
        }
        $folderName = Str::slug($request->name,'_') . '-' . date('mdg');
        $destination = 'profile/' .$folderName;
        if(File::exists(public_path($destination))){
          File::delete(public_path($destination));
        }
        $fileName =Str::slug($request->name,'_') . '-' . $request->file('profile')->getClientOriginalName() ;
        $request->file('profile')->move(public_path($destination),$fileName);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile' => $fileName,
            'birthday' => $request->birthday
        ]);

        Role::create([
            'role' => 'user',
            'user_id' => $user->id
        ]);

        $ramdom = random_int(100000, 999999);
        $token = $user->createToken($user->email . '_' .now(),[$user->role->role]);
        $user->update([
            'check_code' => $ramdom
        ]);
        $data = [
               'random'=>$ramdom,
               'name' => $user->name,
               'email' => $user->email,
               'token' => $token
           ];

        if(!$user->hasVerifiedEmail()){
            Mail::to($user->email)->send(new EmailVerifyMail($data));
            return response()->json(['token'=>$token->accessToken,'user'=>$user]);
        }
        return response()->json(['token'=>$token->accessToken,'user'=>$user]);

    }


    public function EmailVerify(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user){
            $check_code = $user->check_code == $request->check_code;
            if($check_code){
                if (!$user->hasVerifiedEmail()) {
                  $user->markEmailAsVerified();
                }
                $token = $user->createToken($user->email . '_' .now(),[$user->role->role]);
                return response()->json(['token'=>$token->accessToken,'user'=>$user]);
            }
        }
    }
}
