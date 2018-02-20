<?php

namespace App\Console\Commands;

use App\Test;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test';

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
        Test::create(['test' => Carbon::now()->format('Y-m-d H:m:s')]);
    }
}
