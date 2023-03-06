<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i=0; $i < 60 ; $i++){
            $new_project = new Project();
            $new_project->type_id = Type::inRandomOrder()->first()->id;
            $new_project->title = $faker->text($maxNbChars = 15);
            $new_project->slug = Str::slug($new_project->title);
            $new_project->argument = $faker->text($maxNbChars = 50);
            $new_project->description = $faker->text();
            $new_project->user_id = User::inRandomOrder()->first()->id;
            $new_project->start_date = $faker->dateTimeThisYear();
            $new_project->image = $faker->unique()->imageUrl();
            $new_project->concluded = $faker->boolean();
            $new_project->save();
        }
    }
}
