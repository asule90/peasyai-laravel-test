<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandomUser extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'random_user';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';

    /* protected $fillable = [
        'name->title',
        'name->first',
        'name->last',
        'location->street->number',
        'location->street->name',
        'location->city',
        'location->state',
        'location->country',
        'location->postcode',
        'location->coordinates->latitude',
        'location->coordinates->longitude',
        'location->timezone->offset',
        'location->timezone->description',
        'gender',
        'age',
    ]; */
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
        'location' => 'array',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y/M/d H:i:s T');
    }
}
