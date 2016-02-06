<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Hub, App\Node, App\Trace;
use Horntell;
use Carbon\Carbon;

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
        Horntell\App::init('81vtnAxVtt8a7faFKc45n6dStBQapMhotXCfkYCm', 'Xa7KadbFBSWww9UYH9V9mhMsdxBGCCMphOdfxEjh');
        Horntell\App::setBase('http://demo.api.horntell.com');
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
            $latestTrace = $node->latestTrace();
            $this->comment('Trying for Node: '.$node->uuid.' having latest trace: '.$latestTrace->value.' against threshold: '. (int) $this->argument('threshold').PHP_EOL);
            if(is_null($latestTrace->processed_at) && $latestTrace->value < (int) $this->argument('threshold'))
            {
                $this->comment('Notifying HUB: '.$node->hub->uuid.' for Node: '.$node->uuid.PHP_EOL);
                (new Horntell\Campaign)->toProfile(
                    $node->hub->uuid,
                    '562b4ad39f17f6a06d8b4567',
                    ['node_uuid' => $node->uuid, 'latest_trace' => $latestTrace->value]
                );
                $latestTrace->processed_at = Carbon::now();
                $latestTrace->save();
            }
        }
        $this->info('Finishing at... '.time().PHP_EOL);
    }
}
