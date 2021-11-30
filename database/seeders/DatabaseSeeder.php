<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// Add admin users
		$this->call(AdminSeeder::class);
		$this->call(VideoSeeder::class);
	}
}
