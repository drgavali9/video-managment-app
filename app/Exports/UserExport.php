<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class UserExport implements FromQuery, WithHeadings, WithMapping
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
			'Email',
			'Mobile Number',
			'Date of join',
			'Orders',
			'Revenue',
			'Membership',
			'Location',
			'Status',
		];
	}

	public function query()
	{
		$users = User::where('is_admin', 0)
			->with(['default_address', 'active_membership'])
			->withCount([
				'orders as total_order',
				'revenue as total_revenue' => function ($query) {
					$query->select(DB::raw('SUM(amount)'))->where('transactions.status', 1);
				}
			]);
		if (!empty($this->selectIds)) {
			$users = $users->whereIn('id', $this->selectIds);
		}
		return $users;
	}

	public function map($user): array
	{
		$app_settings = config('app_settings');
		$user->created_at = Carbon::parse($user->created_at)->format("M d,Y g:iA");
		$user_membership = "No active membership";
		if (isset($user->active_membership)) {
			$user_membership = $user->active_membership->membershipPlan->title;
		}
		$user_address = "Details not available";
		if (isset($user->default_address)) {
			$user_address = $user->default_address->city->city . ', ' . $user->default_address->country->country;
		}
		if (is_null($user->revenue)) {
			$user->revenue = '0';
		}
		return [
			'Name' => $user->first_name . ' ' . $user->last_name,
			'Email' => $user->email,
			'Mobile Number' => $user->phone,
			'Date of join' => $user->created_at,
			'Orders' => '' . $user->total_order,
			'Revenue' => '' . $user->total_revenue,
			'Membership' => $user_membership,
			'Location' => $user_address,
			'Status' => $user->status_text,
		];
	}
}
