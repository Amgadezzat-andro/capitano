<?php 
namespace App\Customs\Services;

use App\Mail\VerifyEmail;
use App\Models\Customer;
use App\Models\EmailVerificationToken;
use App\Models\User;
// use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class EmailVerificationService 
{
    /**
     * Send verification link
    */
    public function sendVerificationlink($user)
    {
        Mail::to($user->email)->send(new VerifyEmail($user,$this->generateVerificationLink($user->email)));

      //  Notification::send($user, new EmailVerificationNotification($this->generateVerificationLink($user->email)));
    }
    /**
     * Resend link with token
     */
    public function resendLink($email)
    {
        $user = User::where('email',$email)->first();
        if($user)
        {
            $this->sendVerificationlink($user);
            return response()->json([
                'status'=>'success',
                'message'=>__('verification link sent successfully')
            ]);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>__('No email found')
            ]);
        }
    }
    /**
     * Check if user already verified
     */
    public function checkEmailIsVerified($user)
    {
        if($user->email_verified_at)
        {
            
           return  response()->json([
                'status'=>'failed',
                'message'=>__('Email has already been verified')
            ],400);
        }

    }
    /**
     * Verify user Email
     */
    // public function verifyEmail($email,$token)
    // {
    //     $user = User::where('email',$email)->first();
    //     if(!$user)
    //     {
    //         return response()->json([
    //             'status'=>'failed',
    //             'message'=>__('No data found'),

    //         ]);
    //     }
    //     $this->checkEmailIsVerified($user);
    //     $verifiedToken = $this->verifyToken($email,$token);
    //     if($user->markEmailAsVerified())
    //     {
    //         if($verifiedToken instanceof EmailVerificationToken)
    //             $verifiedToken->delete();
    //         return response()->json([
    //             'status'=>'success',
    //             'message'=> __('Email has been verified successfully')
    //         ],200);
    //     }else{
    //         return response()->json([
    //             'status'=>'failed',
    //             'message'=>__('Email verification failed , please try again later')
    //         ]);
    //     }
    // }
    public function verifyEmail($email, $token)
{
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return response()->json([
            'status' => 'failed',
            'message' => __('No data found'),
        ], 404);
    }

    $emailVerifiedResponse = $this->checkEmailIsVerified($user);
    if ($emailVerifiedResponse) {
        return $emailVerifiedResponse; // Return the response if email is already verified
    }

    $verifiedToken = $this->verifyToken($email, $token);

    if ($verifiedToken instanceof EmailVerificationToken && $user->markEmailAsVerified()) {
        $verifiedToken->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('Email has been verified successfully')
        ], 200);
    }

    return response()->json([
        'status' => 'failed',
        'message' => __('Email verification failed, please try again later')
    ], 500);
}

    /**
     * Verify token
     */
    public function verifyToken($email,$token)
    {
        $token = EmailVerificationToken::where('email',$email)->where('token',$token)->first();
        if($token)
        {
            if($token->expired_at>=now())
            {
                return $token;
            }else{
                $token->delete();
                return response()->json([
                    'status'=>'failed',
                    'message'=>__('Token expired'),
                ],400);
            }
        }
        else
        {
           return response()->json([
                'status'=>'failed',
                'message'=>__('Invalid token')
            ],400);
            
        }
    }   
    /**
     * Generate verification Link
     */
       public function generateVerificationLink($email)
       {
            $checkIfTokenExists = EmailVerificationToken::where('email',$email)->first();
            if($checkIfTokenExists) $checkIfTokenExists->delete();
            $token = Str::uuid(); 
            $url =  "http://127.0.0.1:8000/api/customer/verify?token=".$token."&email=".$email;
            $saveToken = EmailVerificationToken::create([
                "email"=>$email,
                "token"=>$token,
                "expired_at"=>now()->addMinutes(60),
            ]);
            if($saveToken)
            {
                return $url;
            }
       }
      
}
