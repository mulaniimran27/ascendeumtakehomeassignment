<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'campaign_id',
        'utm_term',
        'event_time',
        'revenue',
    ];

    /**
     * Define the relationship between Stat and Campaign.
     * A stat belongs to a campaign.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
