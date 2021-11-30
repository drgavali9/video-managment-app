<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithHeadingRow
{
	private $rows = 1;

	/**
	 * @param array $row
	 *
	 * @return Model|null
	 */
	public function model(array $row)
	{
		$this->rows++;

		$import = new CategoryImport;
		$import->getRowCount();
		$categories = explode('>', $row['categories']);
		$slug = '';

		$parentId = null;
		foreach ($categories as $category) {
			$category = trim($category);
			$dbCategory = Category::updateOrCreate(
				[
					'slug' => Str::slug($category)
				],
				[
					'category_id' => $parentId,
					'title' => $category,
					'status' => 1,
				]
			);
			$parentId = $dbCategory->id;
		}
		return;
	}

	public function getRowCount(): int
	{
		return $this->rows;
	}
}
