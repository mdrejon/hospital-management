<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class FrontendController extends Controller
{
    public function home(): View
    {
        return view('frontend.home');
    }

    public function about(): View
    {
        return view('frontend.about');
    }

    public function achievements(): View
    {
        return view('frontend.achievements');
    }

    public function appointment(): View
    {
        return view('frontend.appointment');
    }

    public function blogList(): View
    {
        return view('frontend.blog-list');
    }

    public function blogDetails(): View
    {
        return view('frontend.blog-details');
    }

    public function contact(): View
    {
        return view('frontend.contact');
    }

    public function doctors(): View
    {
        return view('frontend.doctors');
    }

    public function doctorDetails(): View
    {
        return view('frontend.doctor-details');
    }

    public function faq(): View
    {
        return view('frontend.faq');
    }

    public function gallery(): View
    {
        return view('frontend.gallery');
    }

    public function history(): View
    {
        return view('frontend.history');
    }

    public function management(): View
    {
        return view('frontend.management');
    }

    public function mdMessage(): View
    {
        return view('frontend.md-message');
    }

    public function privacyPolicy(): View
    {
        return view('frontend.privacy-policy');
    }

    public function services(): View
    {
        return view('frontend.services');
    }

    public function serviceDetails(): View
    {
        return view('frontend.service-details');
    }

    public function termsConditions(): View
    {
        return view('frontend.terms-conditions');
    }
}
