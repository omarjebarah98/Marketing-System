<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'type', 'subject', 'content', 'variables'];
    protected $casts = ['variables' => 'array'];

    public function campaigns() {
        return $this->hasMany(Campaign::class);
    }

    // render template variables
    public function render(array $data): string
    {
        $rendered = $this->content;

        foreach ($data as $key => $value) {
            $rendered = str_replace("{{{$key}}}", $value, $rendered);
        }

        return $rendered;
    }
}
