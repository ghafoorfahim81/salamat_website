<?php

namespace App\Console\Commands;

use App\Http\Controllers\DTSController;
use Illuminate\Console\Command;

class FetchArchiveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-archive-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from HR system and insert into the DTS database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new \App\Http\Controllers\DTSController)->getArchiveData();
    }
}
