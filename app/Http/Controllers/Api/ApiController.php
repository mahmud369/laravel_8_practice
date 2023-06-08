<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

class ApiController extends Controller
{
    public function __construct() {
        // For anything to initialize
    }

    public function users_list(Request $rqst) {
        //echo 'Your email: '.$rqst['email'];
        print_r(User::all()->toArray());
    }
}
