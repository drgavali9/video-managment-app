<html>
	<head>
        <script src="{{ asset('assets/js/plugins/bootstrap.min.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-ui.min.css')}}" />

	</head>
	<body>
		<div class="continer">
			<div style="text-align: center">
				<h5>Order {{$order->order_id}} place </h5>
			</div>
			<div>
				<p>Dear : {{$order->user->first_name}} </p>
				<p>Order Id : {{$order->order_id}}</p>
				<p>
					<table>
						<thead>
							<tr>
								<th>#id</th>
								<th>Product</th>
								<th>Quantity</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($order->orderdetail as $orderdetail )
								<tr>
									<td>{{$orderdetail->order_id}}</td>
									<td>{{$orderdetail->product->title}}</td>
									<td>{{$orderdetail->quantity}}</td>
									<td>{{$orderdetail->quantity * $orderdetail->product->price}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</p>
				<p>Delivery fee : {{config('constants.currency')}} {{$order->delivery_fee}}</p>
				<p>Order Total : {{config('constants.currency')}} {{$order->order_total}}</p>
			</div>
		</div>
	</body>
</html>
