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
        $this->info('Beginning at... '.time().PHP_EOL);

        $nodes = Node::connected();
        $this->comment('Connected nodes found: '. $nodes->count().PHP_EOL);
        foreach($nodes as $node)
        {
            $this->comment('Trying for Node: '.$node->uuid.' having latest trace: '.$node->latestTrace()->value.' against threshold: '. (int) $this->argument('threshold').PHP_EOL);
            if($node->latestTrace()->value < (int) $this->argument('threshold'))
            {
                $this->comment('Notifying HUB: '.$node->hub->uuid.' for Node: '.$node->uuid.PHP_EOL);
            }
        }
        $this->info('Finishing at... '.time().PHP_EOL);
    }
}
