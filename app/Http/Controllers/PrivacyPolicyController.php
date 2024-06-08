<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PrivacyPolicyController extends Controller
{
    

    /**
     * Show the form for creating a new resource.
     */
    public function privacy_policy()
    {
        return view('privacy_policy');
    }
    
        
        public function delete_user_account()
    {
        return view('delete_user_account');
    }


}