<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignSend extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'status', 'opened_at', 'clicked_at', 'cost'];
    protected $dates = ['opened_at', 'clicked_at'];

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
