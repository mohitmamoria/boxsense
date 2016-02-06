<?php

namespace App\Services\RequestHash;

use Crypt;
use App\Hub;

class Hash
{
    public function verify($request, $salt)
    {
        // Pull out 'hash' from the input and sort
        // it by the keys
        $input = $request->all();
        $hash = array_pull($input, 'hash');

        return $hash == $this->make($input, $salt);
    }

    public function make($input, $salt)
    {
        ksort($input);

        return hash_hmac('sha256', $this->toString($input), $salt);
    }

    public function toString($input)
    {
        $stringlets = [];
        foreach($input as $key => $value)
        {
            $stringlets[] = implode('=', [$key, $value]);
        }

        return implode('&', $stringlets);
    }
}