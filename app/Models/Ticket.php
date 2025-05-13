<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'price',
        'place_number',
        'status',
        'payment_id'
    ];


    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
