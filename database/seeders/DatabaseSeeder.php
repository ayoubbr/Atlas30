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
use App\Models\Group;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
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

        User::factory()->count(5)->create(['role_id' => $userRole->id]);

        $teams = Team::factory()->count(6)->create();

        $stadiums = Stadium::factory()->count(5)->create();

        $categories = Category::factory()->count(5)->create();

        $games = Game::factory()->count(10)->create();

        $users = User::where('role_id', $userRole->id)->get();
        foreach ($games as $game) {
            Ticket::factory()->count(5)->create([
                'game_id' => $game->id,
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ]);
        }

        $tickets = Ticket::all();
        foreach ($tickets as $ticket) {
            Payment::create([
                'ticket_id' => $ticket->id,
                'status' => 'completed',
            ]);
        }

        $groups = Group::factory()->count(5)->create();

        $posts = Post::factory()->count(10)->create();

        Comment::factory()->count(15)->create();

        Like::factory()->count(20)->create();

        Notification::factory()->count(10)->create();
    }
}
