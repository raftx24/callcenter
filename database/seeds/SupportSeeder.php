<?php

use App\Models\Support;
use App\Enums\SupportStatus;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Support::class, 5)->create([
            'status' => SupportStatus::WAITING
        ]);
    }
}
