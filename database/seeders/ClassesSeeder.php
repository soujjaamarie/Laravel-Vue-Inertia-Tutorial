<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\Sections;
use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::factory()->count(10)->sequence(fn($sequence) => ["name" => 'Class ' . ($sequence->index + 1)])
            ->has(
                Sections::factory()->count(2)->state(new Sequence(
                    ['name' => 'Section A'],
                    ['name' => 'Section B'],
                ))
            )
            ->create()
            ->each(function ($class) {
                // Create students for each class and section
                $class->sections->each(function ($section) {
                    Students::factory()->count(5)->create([
                        'class_id' => $section->class_id,  // Assign the correct class_id
                        'section_id' => $section->id       // Assign the correct section_id
                    ]);
                });
            });
    }
}
