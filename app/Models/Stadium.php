<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $fillable = ['stade_name', 'city', 'capacity'];
    protected $table = 'stadiums';


    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
