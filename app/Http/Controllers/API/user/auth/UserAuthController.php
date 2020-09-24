<?php

namespace App\Http\Controllers\API\user\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Validator;

class UserAuthController extends Controller
{
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = array(  
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:6', 
        );
        //Validation
        $data = $request->all();
        $validator = Validator::make($data, $rules); 

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors(), 'code' => 400], 400);  
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            return response()->json([
                'message' => 'login_successfully',
                'code' => 200, 
                'data' => ['token' => $token, 'user' => new UserResource(auth()->user())]
            ], 200);
        } else {
            return response()->json( ['errors' => __('api.login_unsuccessful'), 'code' => 401 ], 401 );
        }
    }
}
