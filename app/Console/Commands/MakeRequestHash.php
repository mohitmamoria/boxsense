<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use RequestHash;
use App\Hub;

class MakeRequestHash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:request-hash {hub_uuid} {input}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes the valid hash for a request\'s data';

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
        $input = json_decode($this->argument('input'), true);

        $hub = Hub::findByUuid($this->argument('hub_uuid'));
        $salt = Crypt::decrypt($hub->salt);

        $this->comment(PHP_EOL.RequestHash::make($input, $salt).PHP_EOL);
    }
}
