<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateCampaignStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update campaign statuses based on start_date and end_date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $excludedStatuses = ['paused', 'completed'];

        // change the campaign status from active to completed
        $toComplete = Campaign::whereNotIn('status', $excludedStatuses)
            ->whereDate('end_date', '<', $today)
            ->get();

        // change the campaign status from draft to active
        $toActivate = Campaign::whereNotIn('status', $excludedStatuses)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        DB::transaction(function () use ($toComplete, $toActivate) {
            foreach ($toComplete as $campaign) {
                $old = $campaign->status;
                $campaign->update(['status' => 'completed']);
                Log::info("Campaign status auto-updated", ['id' => $campaign->id, 'from' => $old, 'to' => 'completed']);
            }

            foreach ($toActivate as $campaign) {
                $old = $campaign->status;
                $campaign->update(['status' => 'active']);
                Log::info("Campaign status auto-updated", ['id' => $campaign->id, 'from' => $old, 'to' => 'active']);
            }
        });

        $this->info('Campaign statuses updated successfully.');

        return 0;
    }
}
