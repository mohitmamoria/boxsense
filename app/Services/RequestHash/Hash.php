<?php

namespace App\Services\RequestHash;

use Crypt;
use App\Hub;

class Hash
{
    public function verify($request)
    {
        // Pull out 'hash' from the input and sort
        // it by the keys
        $input = $request->all();
        $hash = array_pull($input, 'hash');
        ksort($input);

        // Find the decrypted salt for the hub
        $hub = Hub::findByUuid($request->route()->parameter('hub_id'));
        $salt = Crypt::decrypt($hub->salt);

        // Prepare the string that needs to be verified
        $stringlets = [];
        foreach($input as $key => $value)
        {
            $stringlets[] = implode('=', [$key, $value]);
        }
        $string = implode('&', $stringlets);

        // Verify
        return $hash == hash_hmac('sha256', $string, $salt);
    }
}