<?php

namespace App\Exports;

use App\Models\Product;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ProductExport implements FromQuery, WithHeadings, WithMapping
{
	protected $selectIds;

	function __construct($selectIds)
	{
		$this->selectIds = $selectIds;
	}

	public function headings(): array
	{
		return [
			'Name',
			'Price',
			'Size',
			'Inventory',
			'Category',
			'Category Description',
			'Tag',
			'Created At'
		];
	}

	public function query()
	{
		$products = Product::query()->with('size', 'category');
		if (!empty($this->selectIds)) {
			$products = $products->whereIn('id', $this->selectIds);
		}
		return $products;
	}

	public function map($product): array
	{
		$product->created_at = Carbon::parse($product->created_at)->format("M d,Y g:iA");
		return [
			'Name' => $product->title,
			'Price' => $product->price,
			'Size' => $product->size != null ? $product->size->size : "",
			'Inventory' => $product->quantity,
			'Category' => $product->category != null ? $product->category->title : "",
			'Category Description' => $product->category != null ? $product->category->description : "",
			'Tag' => $product->tags,
			'Created At' => $product->created_at,
		];
	}
}
