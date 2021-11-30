<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->command->warn('Running Admin Seeder');
		if (User::count() === 0) {
			$this->command->info('Add admin users.');
			User::create([
				'first_name' => config('constants.admin.first_name'),
				'last_name' => config('constants.admin.last_name'),
				'email' => config('constants.admin.email'),
				'password' => Hash::make(config('constants.admin.password')),
				'is_admin' => 1,
				'status' => config('constants.status.active')
			]);
			$this->command->info('Admin users details added successfully.');
		}
		$this->command->warn('Admin Seeder Run Completed.');
	}
}
