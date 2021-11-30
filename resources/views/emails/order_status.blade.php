<html>

<head>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-ui.min.css') }}" />

</head>

<body>
    <div class="continer">
        <div style="text-align: center">
            <h5>Order {{ $order->order_id }} place </h5>
        </div>
        <div>
            <p>Dear : {{ $order->user->first_name }} </p>
            <p>Order Id : {{ $order->order_id }}</p>
            <p>Order status updated to {{ $order->status_text }}.</p>
        </div>
    </div>
</body>

</html>
