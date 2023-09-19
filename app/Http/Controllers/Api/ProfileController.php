<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function profile()
    {
        return auth()->user();
    }
}
