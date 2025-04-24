<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Stadium;
use App\Models\Team;
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

        User::factory()->count(3)->create(['role_id' => $userRole->id]);

        $teams = Team::factory()->count(3)->create();

        $stadiums = Stadium::factory()->count(3)->create();

        $games = Game::factory()->count(3)->create();

        $users = User::where('role_id', $userRole->id)->get();

        foreach ($users as $user) {
            Payment::create([
                'payment_id' => Str::random(10),
                'user_id' => $user->id,
                'status' => 'completed',
                'amount' => $user->id * 100,
                'payment_method' => 'stripe',
                'status' => 'pending'
            ]);
        }

        $payments = Payment::all();
        foreach ($payments as $payment) {
            Ticket::factory()->count(2)->create([
                'game_id' => $games->random()->id,
                'user_id' => $users->random()->id,
                'payment_id' => $payment->id,
            ]);
        }


        $groups = Group::factory()->count(3)->create();

        $posts = Post::factory()->count(3)->create();

        Comment::factory()->count(3)->create();

        Like::factory()->count(3)->create();

        Notification::factory()->count(3)->create();
    }
}
