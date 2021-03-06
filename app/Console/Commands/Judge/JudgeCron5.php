<?php

namespace App\Console\Commands\Judge;

use Illuminate\Console\Command;

class JudgeCron5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'judge:cron5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        (new \App\Services\Judge\JudgeService(5))->multiJudge();
        return 0;
    }
}
