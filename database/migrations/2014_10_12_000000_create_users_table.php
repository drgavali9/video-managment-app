<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->engine = "InnoDB";
			$table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->string('profile_image', 255)->nullable();
			$table->string('email', 50)->unique();
			$table->string('country_code')->nullable();
			$table->string('phone', 20)->unique()->nullable();
			$table->string('password')->nullable();
			$table->rememberToken();
			$table->tinyInteger('is_admin')->default(0);
			$table->tinyInteger('status')->default(0)->comment('0-Inactive, 1-Active, 2-Blocked');
			$table->timestamp('email_verified_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
