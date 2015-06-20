<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RecordTraceRequest;
use App\Http\Controllers\Controller;
use App\Hub;
use App\Trace;

class TraceController extends Controller
{
    public function store(RecordTraceRequest $request, $hubId)
    {
        $request->validHash();
        
        $input = $request->all();
        $input = array_add($input, 'hub_id', Hub::findByUuid($hubId)->id);
        $input = array_add($input, 'created_at_node', date('Y-m-d H:i:s', $input['created_at']));
        
        $trace = Trace::create($input);

        dd($trace);
    }
}
