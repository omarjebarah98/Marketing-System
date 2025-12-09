<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['template_id', 'title', 'description', 'target_audience', 'start_date', 'end_date', 'status'];
    protected $dates = ['start_date', 'end_date'];

    public function template() {
        return $this->belongsTo(Template::class);
    }

    public function sends() {
        return $this->hasMany(CampaignSend::class);
    }

    // calculate the percentage of opened emails/sms
    public function openRateCalculation() {
        $total = $this->sends->count();
        if ($total === 0) {
            return 0;
        }

        return round(($this->sends->whereNotNull('opened_at')->count() / $total) * 100, 2);
    }

    // calculate the percentage of clicked emails/sms
    public function clickRateCalculation() {
        $total = $this->sends->count();
        if ($total === 0) {
            return 0;
        }

        return round(($this->sends->whereNotNull('clicked_at')->count() / $total) * 100, 2);
    }
}
