<?php

namespace App\Console\Commands;

use App\Models\Brand;
use Edujugon\Laradoo\Odoo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BrandCron extends Command
{

	public $odooClient;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'Brand:cron';

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
		Log::info("=========================================Cron Job Start For Brand=============================================\n");
		$this->odooClient = new Odoo();
		$this->odooClient = $this->odooClient->db(config('laradoo.db'))->host(config('laradoo.host'))->username(config('laradoo.username'))->password(config('laradoo.password'))->connect();

		$brands = $this->odooClient->where('name', '!=', '.')->where('name', '!=', "")->where('name', '!=', '0')->get('product.attribute.value');
		if (!empty($brands)) {
			$b = 1;
			foreach ($brands as $brand) {
				if ($brand['attribute_id']['1'] === "Brand") {

					$brand_slug = !empty($brand['name']) ? Str::slug($brand['name']) : '';
					$brandtitle = !empty(trim($brand['name'])) ? trim($brand['name']) : '';

					Brand::updateOrCreate(
						['odoo_brand_id' => $brand['id']],
						[
							'title' => $brandtitle,
							'odoo_brand_id' => $brand['id'],
							'slug' => $brand_slug,
							'display_order' => $b,
							'status' => 1,
							'created_at' => $brand['create_date'],
						]
					);
					$b++;
				}
			}
			Log::info("Brand cron run successfully..");
		}
		Log::info("=========================================Cron Job End For Brand=============================================\n");
		return 0;
	}
}
