<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        EmailTemplate::factory()->create();


        EmailTemplate::factory()->adminNotice()->create();
    }
}
