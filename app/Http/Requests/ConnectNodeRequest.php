<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Crypt;
use RequestHash;
use App\Http\Requests\Request;
use App\Hub;

class ConnectNodeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function validHash()
    {
        $hub = Hub::findByUuid($this->route()->parameter('hub_id'));
        $salt = Crypt::decrypt($hub->salt);

        return RequestHash::verify($this, $salt);
    }
}
