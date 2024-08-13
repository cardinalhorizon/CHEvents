<?php

namespace Modules\CHEvents\Models;

use App\Contracts\Model;
use App\Models\Pirep;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event
 * @package Modules\CHEvents\Models
 */
class Event extends Model
{
    use SoftDeletes;
    public $table = 'ch_events';
    protected $fillable = ['name', 'description', 'starting_at', 'ending_at', 'route_code', 'banner_url'];

    protected $casts = [

    ];

    public static $rules = [

    ];

    public function getCanJoinAttribute()
    {
        // Compare the current date and time with the ending_at field
        return now() < $this->ending_at;
    }

    public function getCanFlyAttribute()
    {
        return now() > Carbon::parse($this->starting_at)->subHours(2) && now() < $this->ending_at;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'ch_event_user');
    }

    public function matrix()
    {
        return $this->hasMany(EventMatrix::class);
    }
}
