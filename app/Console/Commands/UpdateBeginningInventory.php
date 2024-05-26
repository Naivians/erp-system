<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;

class UpdateBeginningInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-beginning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update beginning inventory for the new month';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $inventories = Inventory::all();

        foreach ($inventories as $inventory) {
            $endingInventory = $inventory->beg_inv + $inventory->end_inv;
            $inventory->beg_inv = $endingInventory;
            $inventory->initial = ($endingInventory * $inventory->price);
            $inventory->save();
        }

        $this->info('Ending inventory calculated and saved.');
    }
}
