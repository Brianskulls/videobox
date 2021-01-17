<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;

    //Settings for Laravel/Activitylog
    protected static $logAttributes = ["*"]; //What attributes to track
    protected static $logFillable = true;    //Should attributes in the fillable array be tracked
    protected static $logOnlyDirty = true;   //Only track differences between old and new

    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
