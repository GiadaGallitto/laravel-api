<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $technologies = ['HTML5', 'CSS3', 'SCSS', 'Bootstrap', 'Laravel', 'Python', 'JavaScript', 'PHP', 'Vue3', 'Java', 'Vite', 'Composer', 'NPM', 'Angular', 'C', 'React', 'HTML4', 'Node.js', 'Mysql', ];
        foreach ($technologies as $technologyName) {
            $newTechnology = new Technology();
            $newTechnology->name = $technologyName;
            $newTechnology->slug = Str::slug($technologyName);
            $newTechnology->color = $faker->unique()->colorName();
            $newTechnology->save();
            $newTechnology->slug = $newTechnology->slug . "-$newTechnology->id";
            $newTechnology->update();
        }
    }
}
