<?php

namespace Modules\CHEvents\Models;

use App\Contracts\Model;
use App\Models\Pirep;

/**
 * Class EventUserMatrix
 * @package Modules\CHEvents\Models
 */
class EventMatrix extends Model
{
    public $table = 'ch_event_matrix';
    protected $fillable = ['user_id', 'event_id', 'flight_id', 'pirep_id'];

    public $timestamps = false;
    protected $casts = [

    ];

    public static $rules = [

    ];
    public function pirep() {
        return $this->belongsTo(Pirep::class);
    }
}
