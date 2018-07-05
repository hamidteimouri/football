<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';
    protected $fillable = [
        'team_id',
        'first_name',
        'last_name',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class,'team_id');
    }
}
