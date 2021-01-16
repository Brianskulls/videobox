<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use HasFactory;
    use LogsActivity;

    //Settings for Laravel/Activitylog
    protected static $logAttributes = ["*"]; //What attributes to track
    protected static $logFillable = true;    //Should attributes in the fillable array be tracked
    protected static $logOnlyDirty = true;   //Only track differences between old and new

    protected $fillable = [
        'title'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
