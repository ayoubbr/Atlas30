<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'start_hour',
        'home_team_id',
        'away_team_id',
        'stadium_id',
        'home_team_goals',
        'away_team_goals',
        'image'
    ];

   
    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
