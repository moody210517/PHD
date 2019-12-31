<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an hourly sensor data  to webserver';
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
        //
        $this->info('Hourly Update has been send successfully');
        $data  = array('patient_id'=>3, "weight"=>33);
        $res = CallAPI("POST", "https://prohealthdetect.com/phd/api/updateWeight", $data);
        
    }
}
