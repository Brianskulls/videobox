<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Model
{
    use HasFactory;
    use LogsActivity;

    //Settings for Laravel/Activitylog
    protected static $logAttributes = ["*"]; //What attributes to track
    protected static $logFillable = true;    //Should attributes in the fillable array be tracked
    protected static $logOnlyDirty = true;   //Only track differences between old and new

    protected $fillable = [
        'title',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
