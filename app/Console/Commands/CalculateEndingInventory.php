<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Stockin;
use App\Models\TempStockins;
use Carbon\Carbon;
use Exception;

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
        Inventory::chunk(100, function ($inventories) {
            DB::beginTransaction();
            try {
                $firstDayOfNextMonth = Carbon::now()->addMonth()->startOfMonth();

                // at 23:59 last day of the month should be triggered
                foreach ($inventories as $inventory) {

                    Inventory::where('code', $inventory->code)->update([
                        'beg_inv' => $inventory->end_inv,
                        'initial' => $inventory->end_inv * $inventory->price,
                    ]);

                    Stockin::create([
                        'code' => $inventory->code,
                        'category' => $inventory->category,
                        'name' => $inventory->name,
                        'description' => $inventory->description,
                        'price' => $inventory->price,
                        'stocks' => $inventory->end_inv,
                        'total_amount' => $inventory->end_inv * $inventory->price,
                        'created_at' => $firstDayOfNextMonth,
                        'updated_at' => $firstDayOfNextMonth,
                    ]);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error updating inventory record for code: ' . $inventory->code . ' - ' . $e->getMessage());
            }
        });
    }
}
