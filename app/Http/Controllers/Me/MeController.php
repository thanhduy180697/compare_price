<?php

namespace App\Http\Controllers\Me;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;

class MeController extends ApiController
{
    public function __construct()
    {

        $this->middleware('transform.input:'.UserTransformer::class)->only(['update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::guard('api')->user();
        return $this->showOne($user);
    }
    public function update(Request $request)
    {
        //
        
        $user = Auth::guard('api')->user();
        $rules = [
            'password' => 'min:6|confirmed',
            'email' => 'email|unique:users'
        ];

        $this->validate($request, $rules);

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }
        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }
        if($user->isClean()){
            return $this->errorResponse('You need to specify a different value to update',422);
        }
        $user->save();
        return $this->showOne($user);
    }
  
}
