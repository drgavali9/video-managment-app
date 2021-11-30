<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Video::create([
			'title' => 'Fresh Fruit',
			'slug' => 'fresh-fruit',
			'video' => 'Fresh Fruit',
			'status' => 1,
		]);
	}
}
