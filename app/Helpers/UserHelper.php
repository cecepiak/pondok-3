<?php

namespace App\Helpers;

use App\Models\User;

function countUserBaru()
{
    try {
        return User::where('active', 0)->count();
    } catch (\Exception $e) {
        return 0;
    }
}