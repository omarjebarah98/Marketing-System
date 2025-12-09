<?php

namespace App\Repositories;

use App\Models\Campaign;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardRepository
{
    public function getDashboardStats(): array
    {
        $totalTemplates = Template::count();
        $totalCampaigns = Campaign::count();

        $activeCampaigns = Campaign::where('status', 'active')->count();
        $pausedCampaigns = Campaign::where('status', 'paused')->count();
        $completedCampaigns = Campaign::where('status', 'completed')->count();

        // Fetch campaigns with sends for detailed statistics
        $campaigns = Campaign::with('sends')->get();

        $campaignStats = $campaigns->map(function ($campaign) {
            $totalSent = $campaign->sends->count();
            $delivered = $campaign->sends->where('status', 'delivered')->count();
            $failed = $campaign->sends->where('status', 'failed')->count();
            $openRate = $totalSent ? round(($campaign->sends->whereNotNull('opened_at')->count() / $totalSent) * 100, 2) : 0;
            $clickRate = $totalSent ? round(($campaign->sends->whereNotNull('clicked_at')->count() / $totalSent) * 100, 2) : 0;
            $totalCost = $campaign->sends->sum('cost');

            return [
                'id' => $campaign->id,
                'title' => $campaign->title,
                'status' => $campaign->status,
                'total_sent' => $totalSent,
                'delivered' => $delivered,
                'failed' => $failed,
                'open_rate' => $openRate,
                'click_rate' => $clickRate,
                'total_cost' => $totalCost,
                'start_date' => $campaign->start_date,
                'end_date' => $campaign->end_date,
            ];
        });

        return [
            'templates_count' => $totalTemplates,
            'campaigns_count' => $totalCampaigns,
            'active_campaigns' => $activeCampaigns,
            'paused_campaigns' => $pausedCampaigns,
            'completed_campaigns' => $completedCampaigns,
            'campaigns' => $campaignStats,
        ];
    }
}
