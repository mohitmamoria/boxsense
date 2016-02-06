<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use RequestHash;
use App\Hub;

abstract class Request extends FormRequest
{
    public function validHash()
    {
        if(config('auth.bypass_hash')) return true;

        $hub = Hub::findByUuid($this->route()->parameter('hub_id'));
        $salt = Crypt::decrypt($hub->salt);

        return RequestHash::verify($this, $salt);
    }
}
