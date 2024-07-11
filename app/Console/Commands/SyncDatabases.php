<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncDatabases extends Command
{
    protected $signature = 'sync:databases';
    protected $description = 'Sync orders table between primary and mysql_slave databases';

    public function handle()
    {
        $this->info('Starting database synchronization...');

        // Delete all existing data in mysql_slave orders table
        DB::connection('mysql_slave')->table('products')->delete();

        // Insert data into mysql_slave orders table from primary database
        DB::connection('mysql_slave')->statement("INSERT INTO products SELECT * FROM product_catalogue.products");

        $this->info('Productss table synchronization completed successfully.');
    }
}
