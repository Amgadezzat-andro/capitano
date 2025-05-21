<?php

namespace App\Http\Controllers\Api;

use App\Customs\Services\EmailResetPasswordService;
use App\Customs\Services\EmailVerificationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendEmailVerificationLinkRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $service, $reset_service;
    public function __construct(EmailVerificationService $service, EmailResetPasswordService $reset_service)
    {
        $this->reset_service = $reset_service;
        $this->service = $service;
    }
    public function login(Request $request )
    {
        $credentials = $request->only('mobile', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => auth()->user(),
        ]);
    }
    public function register(RegisterRequest $request ){
    $customer = User::create([
                'name'=>$request->validated('name'),
                'mobile'=>$request->validated('mobile'),
                'email'=>$request->validated('email'),
                'password'=>Hash::make($request->validated('password')),
                

            ]);
            if ($customer) {
                // dd($customer instanceof \PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject);
    
                $this->service->sendVerificationlink($customer);
                // $token = auth('api')->login($customer);
                return response()->json([
                    'status' => 'success',
                    'message' => __('Registration successful, Please check your email to verify your address '),
                ], 201);  //$this->responseWithToken($token,$customer);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => __('An error occure while trying to create user')
                ], 500);
            }
    }
    public function verifyCustomerEmail(VerifyEmailRequest $request)
    {
        //dd($request->email,$request->token);
        return $this->service->verifyEmail($request->email, $request->token);
    }
    public function getToken(Request $request)
    {
        
            return response()->json([
                'status' => 'success',
                'message' => __('you can verify your email now'),
                'token' => $request->token,
                'email' => $request->email
            ]);
        
    }
    public function loginUser(LoginRequest $request)
    {
        $dataValidated = $request->validated();
        // dd($dataValidated);
        $customer = User::where('email', $dataValidated['email'])->first();
        if ($customer) {
            if (!$customer->status) {
                return response()->json([
                    'status' => 'failed',
                    'message' => __('Admin blocked this account')
                ], 400);
            }
        }

        $token = auth('api')->attempt($dataValidated);
        //dd($dataValidated);
        if (!$token) {
            return response()->json([
                'status' => 'failed',
                'message' => __('Invalid email or password or you must verify your email first')
            ], 401);
        } else {

            $verify = auth('api')->user()->email_verified_at;
            if ($token && $verify) {
                return $this->responseWithToken($token, auth('api')->user());
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => __('Invalid email or password or you must verify your email first')
                ], 401);
            }
        }
    }
    public function responseWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'customer' => $user,
            'access_token' => $token,
            'type' => 'bearer'
        ]);
    }
    public function resendVerificationEmailLink(ResendEmailVerificationLinkRequest $request)
    {
        return $this->service->resendLink($request->email);
    }
}
