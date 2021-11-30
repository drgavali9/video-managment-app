<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		commands\CategoryCron::class,
		commands\BrandCron::class,
		commands\ProductCron::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')->hourly();
		$schedule->command('telescope:prune --hours=48')->daily();
		if (config('app.env') == 'production') {
			// For APP_TIMEZONE In Live Server
			$schedule->command('Category:cron')->dailyAt('1:15');
			$schedule->command('Brand:cron')->dailyAt('1:30');
			$schedule->command('Product:cron')->dailyAt('1:45');
		} else {
			// For Local Development
			// $schedule->command('Category:cron')->everyFiveMinutes();
			$schedule->command('Brand:cron')->everyFiveMinutes();
			$schedule->command('Product:cron')->everyFiveMinutes();
		}
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
