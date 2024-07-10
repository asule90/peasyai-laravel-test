<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandomUser extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'random_user';
    protected $primaryKey = 'uuid';
    public $timestamps = false;

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
}
