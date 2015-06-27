<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ConnectNodeRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Hub;
use App\Node;

class NodeController extends Controller
{
    public function connect(ConnectNodeRequest $request, $hubId)
    {
        if( ! $request->validHash()) throw new \Exception('Invalid Hash');
        
        $input = $request->all();

        $node = Node::findForConnection($input['uuid'], $input['generation'], $input['type']);
        $node->hub_id = Hub::findByUuid($hubId)->id;
        $node->connected_at = Carbon::now();
        $node->save();

        dd($node);
    }
}