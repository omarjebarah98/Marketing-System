<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'target_audience' => $this->target_audience,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,

            // eager loaded relations
            'template' => new TemplateResource($this->whenLoaded('template')),
            'sends' => CampaignSendResource::collection($this->whenLoaded('sends')),

            // computed stats
            'statistics' => [
                'total_sent' => $this->sends->count(),
                'delivered'  => $this->sends->where('status', 'delivered')->count(),
                'failed' => $this->sends->where('status', 'failed')->count(),
                'open_rate' => $this->openRateCalculation(),
                'click_rate' => $this->clickRateCalculation(),
                'total_cost' => $this->sends->sum('cost'),
            ]
        ];
    }
}
