<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Contracts\UserService;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Auth\ResetsPasswords;

class AuthController extends ApiController
{
    use ResetsPasswords;

    public function __construct(User $user)
    {
        parent::__construct($user);
    }
    
    public function login(Request $request)
    {
    	$credentials = $request->only('email','password');
    	try {
    		if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
    	} catch (\JWTException $e) {
    		return response()->json(['error' => 'could_not_create_token'], 500);
    	}
        if (!\Auth::guard('web')->user()->active) {
            return response()->json(['error' => 'user_not_active'], 404);
        }

    	return response()->json([
    			'success' => true,
    			'data' => [
    				'access_token' => $token,
                    'users' => [
                        'identifier' => \Auth::guard('web')->user()->id
                    ]
    			]
    		]);
    }

    public function register(Request $request, UserService $service)
    {
    	$credentials = $request->only('email','password');
        $validator = \Validator::make($credentials, [
            'email' => "required|email|max:255|unique:users",
            'password' => 'sometimes|required||min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator_fails_auth','error' => $validator->errors()->all()], 401);
        }
    	try {
    		$user = $service->store($credentials);
    		if (! $token = JWTAuth::fromUser($user)) {
    			return response()->json(['error' => 'invalid_credentials'], 401);
    		}
            $service->sendMail([\Crypt::encrypt($user->id)], [$user->email], 'Active Register Parcel','register');
    	} catch (\Exception $e) {
    		return response()->json(['error' => 'not_insert_user'], 401);
    	}

    	return response()->json([
			'success' => true,
			'data' => [
				'access_token' => $token,
				'user' => [
					'identifier' => $user->id
				]
			]
		]);
    }

    public function logout()
    {
    	try {
    		if (! $token = JWTAuth::getToken()) {
    			return response()->json(['error' => 'invalid_credentials'], 401);
    		} 
    	} catch (\Exception $e) {
    		return response()->json(['error' => 'not_insert_user'], 401);
    	}
    	JWTAuth::setToken($token)->invalidate();

    	return response()->json(['success' => true]);
    }

    public function resetPassword(Request $request)
    {
    	try {
            if (! $this->repository->checkEmail($request->email)) {
                return response()->json(['error' => 'email_validator'], 401);
            }
            $this->sendResetLinkEmail($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_resset_password'], 401);
        }

        return response()->json(['success' => true]);
    }
}
