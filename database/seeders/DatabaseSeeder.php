<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Stadium;
use App\Models\Team;
use App\Models\Category;
use App\Models\Game;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Admin User
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@atlas.com',
            'password' => Hash::make('admin123'),
            'status' => 'active',
            'image' => 'https://cdn-icons-png.flaticon.com/512/9703/9703596.png',
            'role_id' => $adminRole->id,
        ]);

        // Users
        User::factory()->count(5)->create(['role_id' => $userRole->id]);

        // Teams
        $teams = Team::factory()->count(5)->create();

        // Stadiums
        $stadiums = Stadium::factory()->count(5)->create();

        // Categories
        $categories = Category::factory()->count(5)->create();

        // Games
        $games = Game::factory()->count(5)->create([
            'home_team_id' => $teams[0]->id,
            'away_team_id' => $teams[1]->id,
            'stadium_id' => $stadiums[0]->id
        ]);

        // Tickets
        $users = User::where('role_id', $userRole->id)->get();
        foreach ($games as $game) {
            Ticket::factory()->count(5)->create([
                'game_id' => $game->id,
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ]);
        }

        // Payments
        $tickets = Ticket::all();
        foreach ($tickets as $ticket) {
            Payment::create([
                'ticket_id' => $ticket->id,
                'status' => 'completed',
            ]);
        }
    }
}
