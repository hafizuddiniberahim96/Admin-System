<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;


class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $state = new State();
        $state->name = 'Johor';
        $state->save();

        $state = new State();
        $state->name = 'Kedah';
        $state->save();

        $state = new State();
        $state->name = 'Kelantan';
        $state->save();

        $state = new State();
        $state->name = 'Kuala Lumpur';
        $state->save();

        $state = new State();
        $state->name = 'Labuan';
        $state->save();

        $state = new State();
        $state->name = 'Melaka';
        $state->save();

        $state = new State();
        $state->name = 'Negeri Sembilan';
        $state->save();

        $state = new State();
        $state->name = 'Pahang';
        $state->save();

        $state = new State();
        $state->name = 'Perak';
        $state->save();

        $state = new State();
        $state->name = 'Perlis';
        $state->save();

        $state = new State();
        $state->name = 'Pulau Pinang';
        $state->save();

        $state = new State();
        $state->name = 'Sabah';
        $state->save();

        $state = new State();
        $state->name = 'Sarawak';
        $state->save();

        $state = new State();
        $state->name = 'Selangor';
        $state->save();

        $state = new State();
        $state->name = 'Terengganu';
        $state->save();
    }
}
