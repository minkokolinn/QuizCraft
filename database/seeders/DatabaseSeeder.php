<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Quiz;
use App\Models\Setting;
use App\Models\Type;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Mandatory Seeding
        Type::create([
            "name" => "True False",
            "header" => "<p>State TRUE or FALSE to the following statements. Do not copy the statements.</p>",
            "mark" => 1
        ]);
        Type::create([
            "name" => "Completion",
            "header" => "<p>Complete the following statements with appropriate words. Do not copy the statements.</p>",
            "mark" => 1
        ]);
        Type::create([
            "name" => "Multiple Choice",
            "header" => "<p>Choose the correct answer for the following statements. Do not copy the statements.</p>",
            "mark" => 1
        ]);
        Type::create([
            "name" => "Short Question",
            "header" => "<p>Answer ALL questions.</p>",
            "mark" => 5
        ]);
        Type::create([
            "name" => "Long Question",
            "header" => "<p>Answer ANY FOUR questions.</p>",
            "mark" => 10
        ]);

        Setting::create([
            "subject" => "Biology",
            "grade" => "10,11,12",
            "chapter" => "1,2,3,4,5,6"
        ]);

        // ========================
        // Quiz::factory()->create(["body"=>"A","type_id"=>1]);
        // Quiz::factory()->create(["body"=>"B","type_id"=>1]);
        // Quiz::factory()->create(["body"=>"C","type_id"=>1]);
        // Quiz::factory()->create(["body"=>"D","type_id"=>1]);
        // Quiz::factory()->create(["body"=>"E","type_id"=>1]);

        // Quiz::factory()->create(["body"=>"A","type_id"=>2]);
        // Quiz::factory()->create(["body"=>"B","type_id"=>2]);
        // Quiz::factory()->create(["body"=>"C","type_id"=>2]);
        // Quiz::factory()->create(["body"=>"D","type_id"=>2]);
        // Quiz::factory()->create(["body"=>"E","type_id"=>2]);

        // Quiz::factory()->create(["body"=>"A","type_id"=>3]);
        // Quiz::factory()->create(["body"=>"B","type_id"=>3]);
        // Quiz::factory()->create(["body"=>"C","type_id"=>3]);
        // Quiz::factory()->create(["body"=>"D","type_id"=>3]);
        // Quiz::factory()->create(["body"=>"E","type_id"=>3]);

        // Quiz::factory()->create(["body"=>"A","type_id"=>5]);
        // Quiz::factory()->create(["body"=>"B","type_id"=>5]);
        // Quiz::factory()->create(["body"=>"C","type_id"=>5]);
        // Quiz::factory()->create(["body"=>"D","type_id"=>5]);
        // Quiz::factory()->create(["body"=>"E","type_id"=>5]);
        // =============================================

    }
}
