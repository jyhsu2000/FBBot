<?php

use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Question::class, 5)->create()->each(function ($question) {
            for ($i = 0; $i < 3; $i++) {
                $question->choices()->save(factory(App\Choice::class)->make());
            }
        });
    }
}
