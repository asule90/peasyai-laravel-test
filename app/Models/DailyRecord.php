<?php

namespace App\Models;

use App\Events\DailyRecordCountChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRecord extends Model
{
    use HasFactory;

    protected $table = 'daily_record';
    protected $primaryKey = 'date';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $dispatchesEvents = [
        'updated' => DailyRecordCountChanged::class,
    ];
}
