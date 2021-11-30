<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function (Blueprint $table) {
			$table->id();
			$table->engine = "InnoDB";
			$table->string('title', 100)->nullable();
			$table->string('slug', 100)->nullable();
			$table->string('video', 100)->unique();
			$table->boolean('status')->default(0)->comment("0-Inactive, 1-Active");
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
		Schema::dropIfExists('brands');
	}
}
