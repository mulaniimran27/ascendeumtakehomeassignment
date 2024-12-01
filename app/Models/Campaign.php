<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'utm_campaign',
    ];

    /**
     * Define the relationship between Campaign and Stat.
     * A campaign can have many stats.
     */
    public function stats()
    {
        return $this->hasMany(Stat::class, 'campaign_id');
    }

    
}
