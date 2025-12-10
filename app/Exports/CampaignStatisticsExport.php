<?php

namespace App\Exports;

use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignStatisticsExport implements FromCollection, WithHeadings
{
    protected $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function collection()
    {
        $stats = [
            [
                'Campaign ID'      => $this->campaign->id,
                'Title'            => $this->campaign->title,
                'Template'         => $this->campaign->template->name,
                'Start Date'       => $this->campaign->start_date ? $this->campaign->start_date : null,
                'End Date'         => $this->campaign->end_date ? $this->campaign->end_date : null,
                'Status'           => $this->campaign->status,
                'Total Sent'       => $this->campaign->sends()->count(),
                'Delivered'        => $this->campaign->sends()->where('status','delivered')->count(),
                'Failed'           => $this->campaign->sends()->where('status','failed')->count(),
                'Open Rate (%)'    => $this->campaign->openRateCalculation(),
                'Click Rate (%)'   => $this->campaign->clickRateCalculation(),
                'Total Cost'       => $this->campaign->sends()->sum('cost'),
            ]
        ];

        return collect($stats);
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first());
    }
}
