<?php

namespace App\Console\Commands;

use App\Service\DisturbDataService;
use Illuminate\Console\Command;

class DisturbUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disturb_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '混肴user資料';

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
    	$disturbUserService = new DisturbDataService();
	    $disturbUserService->user();
        return 0;
    }
}
