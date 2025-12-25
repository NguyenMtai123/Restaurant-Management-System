<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    public function faq()
    {
        return view('customer.policies.faq');
    }

    public function termsOfService()
    {
        return view('customer.policies.terms');
    }

    public function refundPolicy()
    {
        return view('customer.policies.refund');
    }

    public function shippingPolicy()
    {
        return view('customer.policies.shipping');
    }

    public function privacyPolicy()
    {
        return view('customer.policies.privacy');
    }
}
