<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasMessages
{
    public function getUserMessages()
    {
        if (Auth::check()) {
            return Auth::user()->messages()->get();
        }

        return [];

    }
}
