<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BurialRecord;
use Carbon\Carbon;

class DeleteOldBurialRecords extends Command
{
    protected $signature = 'delete:old-burial-records';
    protected $description = 'Delete burial records that were archived more than a month ago';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        BurialRecord::where('archived_at', '<', Carbon::now()->subMonth())->delete();
        $this->info('Old burial records deleted successfully.');
    }
}
