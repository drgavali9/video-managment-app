<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\Size;
use App\Models\TempProduct;
use App\Models\Variant;
use Edujugon\Laradoo\Odoo;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductCron extends Command
{

	public $odooClient;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'Product:cron';

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
		ini_set('memory_limit', '512M');
		ini_set('max_execution_time', '900');

		$this->odooClient = new Odoo();
		$this->odooClient = $this->odooClient->db(config('laradoo.db'))->host(config('laradoo.host'))->username(config('laradoo.username'))->password(config('laradoo.password'))->connect();

		Log::info("=========================================Cron Job Start For Product=============================================\n");
		Log::info("=========================================Cron Oddo Product Get Start=============================================\n");
		DB::disableQueryLog();
		Log::info("Execution Start Memory Usage :- " . formatSizeUnits(memory_get_usage()));
		try {
			TempProduct::truncate();
			$products = [];
			$start_offset = 0;
			$limit = 100;
			do {
				Log::info("==============================");
				Log::info(formatSizeUnits(memory_get_usage()));
				Log::info("Start :- " . $start_offset);
				if (empty($products)) {
					$products = $this->odooClient->where('name', '!=', '.')
						// differencing odoo online and off line products
						->where('purchase_method', 'receive')->where('product_pushed', 'true')
						->where('available_in_pos', 'true')->where('sale_ok', 1)->where('qty_available', '>', 0)

						->where('name', '!=', ' ')->limit($limit, $start_offset)
						->get('product.product');
				}
				$start_offset = $start_offset + $limit;
				$insertData = [];

				foreach ($products as $product) {
					$product = collect($product)->only(
						[
							'id', 'name', 'default_code', 'barcode', 'weight', 'available_in_pos', 'size', 'country_id',
							'description', 'categ_id', 'list_price', 'purchase_method', 'description_field', 'brand_id', 'taxes_id', 'supplier_taxes_id',
							'price', 'qty_available', 'product_img_url', 'create_date'
						]
					);
					$insertData[] = ['data' => $product];
				}
				foreach (array_chunk($insertData, 10) as $key => $value) {
					TempProduct::insert($value);
				}
				unset($insertData);
				unset($products);
				$products = $this->odooClient->where('name', '!=', '.')
					// differencing online and offline product
					->where('purchase_method', 'receive')->where('product_pushed', 'true')
					->where('available_in_pos', 'true')->where('sale_ok', 1)->where('qty_available', '>', 0)
					->where('name', '!=', ' ')->limit($limit, $start_offset)
					->get('product.product');

				// Below if temporary condition
				if ($start_offset >= 500) {
					$products = [];
				}
			} while (count($products) > 0);
		} catch (Exception $th) {
			Log::info($th->getMessage());
		}

		Log::info("=========================================Cron Oddo Product Get End=============================================\n");

		Log::info("=========================================Cron Product Add Start=============================================\n");
		Log::info(formatSizeUnits(memory_get_usage()));
		$allBrands = Brand::all()->pluck('title', 'id')->toArray();
		$allCategories = Category::all()->pluck('title', 'id')->toArray();
		try {
			$products = [];
			$start_offset = 0;
			$limit = 100;
			do {
				Log::info("==============================");
				Log::info(formatSizeUnits(memory_get_usage()));
				Log::info("Start :- " . $start_offset);
				if (empty($products)) {
					$products = TempProduct::limit($limit)->offset($start_offset)->get();
				}
				$start_offset = $start_offset + $limit;
				foreach ($products as $key => $product) {
					$iProduct = $product['data'];
					// Log::info(formatSizeUnits(memory_get_usage()) . "---1");

					$categoryId = $iProduct['categ_id'][0] ?? null;
					$categoryName = $iProduct['categ_id'][1] ?? null;
					$brandId = $iProduct['brand_id'][0] ?? null;
					$brandName = $iProduct['brand_id'][1] ?? null;

					if ($categoryId != null && $categoryName != null && $brandId != null && $brandName != null) {
						$brand_id = array_search(strtolower($brandName), array_map('strtolower', $allBrands));
						if ($brand_id == false || $brand_id < 0) {
							$dbBrand = Brand::Create(
								[
									'odoo_brand_id' => $brandId,
									'title' => $brandName,
									'status' => 1,
								]
							);
							$brand_id = $dbBrand->id;
							$allBrands[$brand_id] = $brandName;
						}

						$category_id = array_search(strtolower($categoryName), array_map('strtolower', $allCategories));
						if ($category_id == false || $category_id < 0) {
							$dbCategory = Category::Create(
								[
									'odoo_category_id' => $categoryId,
									'category_id' => null,
									'title' => $categoryName,
									'status' => 1,
								]
							);
							$category_id = $dbCategory->id;
							$allCategories[$category_id] = $categoryName;
						}

						$iProduct_name_slug = "";
						// Log::info(formatSizeUnits(memory_get_usage()) . "---2");
						if (!empty($iProduct['name'])) {
							// $iProduct_name_slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', "-", $iProduct['name']));
							$iProduct_name_slug = Str::slug($iProduct['name']);
						}
						$iProductName = trim($iProduct['name']);

						$size_id = null;
						if (isset($iProduct['size']) && $iProduct['size'] != null && $iProduct['size'] != "") {
							$iSizeData = Size::updateOrCreate(
								['size' => $iProduct['size']],
								['size' => $iProduct['size'], 'status' => 1]
							)->toArray();
							// Log::info(json_encode($iSizeData));
							$size_id = $iSizeData['id'];
						}

						if ($iProduct['id'] != null)
							$iProduct_new = Product::where('product_id', $iProduct['id'])->first();

						if (isset($iProduct_new) && $iProduct_new != null) {
							if ($iProductName != null)
								$iProduct_new->title = $iProductName;
							if (isset($iProduct['description']) && $iProduct['description'] != null)
								$iProduct_new->short_description = $iProduct['description_field'];
							if (isset($iProduct['description']) && $iProduct['description'] != null)
								$iProduct_new->description = $iProduct['description_field'];
							if (isset($iProduct['list_price']) && $iProduct['list_price'] > 0)
								$iProduct_new->price = $iProduct['list_price'];
							if (isset($iProduct['qty_available']) && $iProduct['qty_available'] != null)
								$iProduct_new->quantity = $iProduct['qty_available'];
							if (isset($iProduct['size']) && $iProduct['size'] != null)
								$iProduct_new->size_id = $size_id;
							if (isset($iProduct['taxes_id']) && $iProduct['taxes_id'] != null)
								$iProduct_new->tax_id = $iProduct['taxes_id'][0];
							$iProduct_new->save();
						} else {
							$iProduct_new = Product::Create(
								[
									'product_id' =>  $iProduct['id'],
									'title' => $iProductName,
									'category_id' => $category_id,
									'brand_id' => $brand_id,
									'short_description' => $iProduct['description_field'],
									'description' => $iProduct['description_field'],
									'size_id' => $size_id,
									'tax_id' => isset($iProduct['taxes_id']) && !empty($iProduct['taxes_id']) ? $iProduct['taxes_id'][0] : null,
									'status' => 1,
									'slug' => $iProduct_name_slug,
									'price' => $iProduct['list_price'],
									'quantity' => $iProduct['qty_available'],
									'product_weight' => $iProduct['weight'],
									'point' => '1',
								]
							);
						}

						// Log::info(formatSizeUnits(memory_get_usage()) . "---3");

						if (!Variant::where('product_id', $iProduct_new->id)->exists()) {
							$iProductvarient = Variant::Create(
								[
									'product_id' => $iProduct_new->id,
									'title' => $iProduct['name'],
									'sku' => $iProduct['default_code'],
									'barcode' => $iProduct['barcode'],
									'size' => isset($iProduct['size']) ? $iProduct['size'] : "",
									'description_koren' => $iProduct['description_field'],
									'country_origin' => isset($iProduct['country_id']) && !empty($iProduct['country_id']) ? $iProduct['country_id'][1] : null,
									'status' => 1,
									'created_at' => $iProduct['create_date'],
								]
							);
							// Log::info(formatSizeUnits(memory_get_usage()) . "---4");
						}

						$product_quantity = ProductQuantity::select(DB::raw('SUM(quantity) as total_quantity'))
							->where('product_id', $iProduct_new->id)->first();

						if ($product_quantity->total_quantity < $iProduct['qty_available']) {
							$iProduct['qty_available'] = abs($product_quantity->total_quantity - $iProduct['qty_available']);
						} elseif ($product_quantity->total_quantity < $iProduct['qty_available']) {
							$iProduct['qty_available'] = "-" . abs($product_quantity->total_quantity - $iProduct['qty_available']);
						} elseif ($product_quantity->total_quantity == $iProduct['qty_available']) {
							$iProduct['qty_available'] = 0;
						}

						if ($iProduct['qty_available'] > 0) {
							$iProductquantity = new ProductQuantity();
							$iProductquantity->product_id = $iProduct_new->id;
							// $iProductquantity->variant_id = !empty($iProductvarient) ? $iProductvarient->id : null;
							$iProductquantity->type = '1';
							$iProductquantity->quantity = $iProduct['qty_available'];
							$iProductquantity->save();
							unset($iProductquantity);
						}

						// Log::info(formatSizeUnits(memory_get_usage()) . "---5");
						unset($iProduct);
						unset($brand);
						unset($category);
						unset($iProduct_new);
						unset($iProductvarient);
						// Log::info(formatSizeUnits(memory_get_usage()) . "---6");
						// Log::info("----------------------");
					}
				}
				unset($products);
				$products = TempProduct::limit($limit)->offset($start_offset)->get();
			} while (count($products) > 0);
		} catch (Exception $th) {
			Log::info($th->getMessage());
		}
		TempProduct::truncate();
		Log::info("=========================================Cron Product Add End=============================================\n");

		return 0;
	}
}
