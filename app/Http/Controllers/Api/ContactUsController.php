<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;
use App\Trait\JsonResponsable;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    use JsonResponsable;
    public function contactUs()
    {
        return $this->success(200,[
            "mail"=>"capitianoksa@gmail.com",
            "phone"=>"920031989",
            "facebook"=>"www.facebook.com",
            "tiktok"=>"www.tiktok.com",
            "snapchat"=>"www.snapchat.com",

        ]);
    }
    public function contactUsForm(ContactUsRequest $request )
    {
        $data=$request->validated();
        $contact = ContactUs::create($data);
        return $this->success(200,$contact,__("we will replay to you soon"));

    }
    public function index()
    {
        $contacts = ContactUs::all();
        if(!$contacts) {
            return $this->success(200,[]);
        }
        return $this->success(200,ContactUsResource::collection($contacts));
    }
}
