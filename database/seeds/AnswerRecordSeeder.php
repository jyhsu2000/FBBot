<?php

use Illuminate\Database\Seeder;

class AnswerRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AnswerRecord::class, 50)->create();
    }
}
