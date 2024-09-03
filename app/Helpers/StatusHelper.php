<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

function getStatusMessage()
{
    return Session::get('status') ?? '';
}

function setStatusMessage($message)
{
    Session::flash('status', $message);
}
