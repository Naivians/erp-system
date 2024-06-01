<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalculateEndingInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:calculate-ending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and save ending inventory for the current month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $inventories = Inventory::all();

            $newInventories = [];
            foreach ($inventories as $inventory) {

                $newInventories[] = [
                    'code' => $inventory->code,
                    'category' => $inventory->category,
                    'name' => $inventory->name,
                    'price' => $inventory->price,
                    'description' => $inventory->description,
                    'beg_inv' => $inventory->end_inv,
                    'initial' => $inventory->end_inv * $inventory->price,
                    'stockin' => $inventory->end_inv,
                    'stockout' => 0,
                    'end_inv' => 0,
                    'total_amount' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Inventory::insert($newInventories);

            DB::commit();

            $this->info('Ending inventory calculated and saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating inventory records: ' . $e->getMessage());
            $this->error('Failed to calculate ending inventory.');
        }
    }
}
