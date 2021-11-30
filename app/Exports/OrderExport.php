<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class OrderExport implements FromQuery, WithHeadings, WithMapping
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
			'Order Id',
			'Cart Total',
			'Delivery Fee',
			'Sub Total',
			'Tax Charge',
			'Convenience Fee',
			'Discount Amount',
			'Order Total',
			'Paid Amount',
			'Refund Amount',
			'Balance Amount',
			'Promocode',
			'Delivery Address',
			'Status',
		];
	}

	public function query()
	{
		$iOrders = Order::with([
			'address',
			'user',
			'user.address',
			'user.total_point',
			'user.current_membership',
			'orderdetail',
			'orderdetail.product',
			'paymentdetail',
			'paymentdetail.card',
			'promocode',
			'productActivity',
			'orderStatus',
		]);
		if (!empty($this->selectIds)) {
			$iOrders = $iOrders->whereIn('id', $this->selectIds);
		}
		return $iOrders;
	}

	public function map($iOrders): array
	{
		return [
			'Name' => $iOrders->user->first_name . " " . $iOrders->user->last_name,
			'Email' => $iOrders->user->email,
			'Order Id' => $iOrders->order_id,
			'Cart Total' => $iOrders->cart_total,
			'Delivery Fee' => $iOrders->delivery_fee,
			'Sub Total' => $iOrders->sub_total,
			'Discount Amount' => $iOrders->discount_amount,
			'Tax Charge' => $iOrders->tax_charges_amount,
			'Convenience Fee' => $iOrders->convenience_fee_amount,
			'Order Total' => $iOrders->order_total,
			'Paid Amount' => $iOrders->paid_amount,
			'Refund Amount' => $iOrders->refund_payment,
			'Balance Amount' => $iOrders->balance_amount,
			'Promocode' => $iOrders->promocode != null ? $iOrders->promocode->title : '',
			'Delivery Address' => $iOrders->address !== null ? $iOrders->address->full_address : '-',
		];
	}
}
