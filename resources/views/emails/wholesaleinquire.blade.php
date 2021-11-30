<html>
	<head>
		<script src="{{ asset('assets/js/plugins/bootstrap.min.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-ui.min.css')}}" />

	</head>
	<body>
		<div class="continer">
			<div style="text-align: center">
				<h2>Inquiry Details</h2>
			</div>
			<div>
				<p>Dear : <b>Admin</b> </p>
				<p>Name : {{$inquire->name}}</p>
				<p>Email : {{$inquire->email}}</p>
				<p>Message : {{$inquire->message}}</p>
				<p>{{ !empty($inquire->order_number) ? 'Order No : '.$inquire->order_number  : ''}}</p>
			</div>
			<div>
				<p>We are looking forward to your requirements.</p>
			</div>
			<br>
			<div >
				<p>Thanks and regards</p>
				<p>1004 Gourment</p>

			</div>
		</div>
	</body>
</html>
