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
			'userName' => '',
			'userCountry' => '',
			'userPicture' => '',
			'video' => 'test.mp4',
			'thumbnail' => 'test.jpg',
			'status' => 1,
		]);
	}
}
