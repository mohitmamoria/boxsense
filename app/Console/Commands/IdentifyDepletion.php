<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Hub, App\Node, App\Trace;

class IdentifyDepletion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traces:depletion {threshold}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Identifies depletion in the traces.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $nodes = Node::connected();

        foreach($nodes as $node)
        {
            if($node->latestTrace()->value < (int) $this->argument('threshold'))
            {
                $this->comment(PHP_EOL.'Notifying HUB: '.$node->hub->uuid.' for Node: '.$node->uuid.PHP_EOL);
            }
        }
    }
}
