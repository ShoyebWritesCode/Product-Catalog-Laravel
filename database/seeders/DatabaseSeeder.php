<?php

namespace Database\Seeders;

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(UserSeed::class);
        $this->call(ProductSeeder::class);
        $this->call([
            TemplateSeeder::class,
        ]);
        $this->call([
            CategorySeeder::class,
        ]);
        $this->call([
            MappingSeeder::class,
        ]);
        $this->call([
            PlaceholderSeeder::class,
        ]);
    }
}
