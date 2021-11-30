<?php

namespace App\Console\Commands;

use App\Imports\CategoryImport;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class CategoryCron extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'Category:cron';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		if (Category::count() == 0) {
			Log::info("=========================================Cron Job Start For Category=============================================\n");
			$file = public_path('defaults/category.xlsx');
			$import = new CategoryImport;
			Excel::import($import, $file);

			Log::info("category cron run");
			Log::info("=========================================Cron Job End For Category=============================================\n");
			return 0;
		}
	}
}
