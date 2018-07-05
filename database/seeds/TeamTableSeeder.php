<?php

use Illuminate\Database\Seeder;
use App\Team;
use App\Player;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::truncate();
        Player::truncate();
        factory(Team::class, 50)->create()->each(function ($t) {
            factory(Player::class, 20)->create(['team_id' => $t->id]);
        });
    }
}
