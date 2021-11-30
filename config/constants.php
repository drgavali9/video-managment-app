<?php

return [
	'admin' => [
		'first_name' => env('ADMIN_NAME'),
		'last_name' => env('ADMIN_NAME'),
		'email' => env('ADMIN_EMAIL'),
		'password' => env('ADMIN_PASS')
	],
	'status' => [
		'inactive' => 0,
		'active' => 1
	],
	'users' => [
		'status' => [
			'inactive' => 'Inactive',
			'active' => 'Active',
			'blocked' => 'Blocked'
		]
	],
	'city' => [
		'duration_type' => [
			'Minutes' => 1,
			'Hours' => 2,
			'Days' => 3,
			'Weeks' => 4
		]
	],
	'orders' => [
		'status' => [
			'New' => 1,
			'On-Hold' => 2,
			'Process' => 3,
			'Delivered' => 4,
			'Completed' => 5,
			'Cancel' => 6,
			'Return' => 7,
			'Dispute' => 8
		],
		'payment_mode' => [
			1 => 'Cod',
			2 => 'Online',
		]
	],
	'holiday' => [
		'type' => [
			'Full' => 1,
			'Part' => 2,
		]
	],
	'transactions' => [
		'status' => [
			'Cash' => 0,
			'Card' => 1,
			'Payment Link' => 2,
		]
	],
	'products' => [
		'pagination' => [
			'recordperpage' => 20
		],
		'duration_type' => [
			'Minutes' => 1,
			'Hours' => 2,
			'Days' => 3,
			'Weeks' => 4
		],
		'discount_type' => [
			'Percentage' => 1,
			'Fixed' => 2
		]
	],

	'blogs' => [
		'pagination' => [
			'recordperpage' => 6
		]
	],
	'recipes' => [
		'pagination' => [
			'recordperpage' => 6
		]
	],
	'ourpress' => [
		'pagination' => [
			'recordperpage' => 8
		]
	],
	'app_settings' => [
		'stripe' => [
			'stripe_secret' => env('STRIPE_SECRET'),
			'stripe_key' => env('STRIPE_KEY')
		]
	],
	'currency' => 'AED',
	'stripecurrency' => 'aed',
	'Homepage' => [
		'slider' => 20,
		'blogslider' => 10,
		'category_slider' => 40,
	],
	'address_types' => [
		'home' => 'Home',
		'work' => 'Work',
		'commercial' => 'Commercial'
	],
	'profile' => [
		'myorders' => 5
	],
	'contact_us_days_type' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
	'allowed_languages' => [
		'en', 'ar', 'kr'
	],
	'odoo_flag' => env('ODOO_FLAG'),
	'message_credentials' => [
		'MESSAGE_APIKEY' => env('FIREBASE_API_KEY'),
		'MESSAGE_AUTHDOMAIN' => env('FIREBASE_DOMAIN'),
		'MESSAGE_PROJECTID' => env('FIREBASE_PROJECT_ID'),
		'MESSAGE_STORAGEBUKET' => env('FIREBASE_STORAGE_BUCKET'),
		'MESSAGE_MESSING_SENDER_ID' => env('FIREBASE_SENDER_ID'),
		'MESSAGE_APPID' => env('FIERBASE_APP_ID'),
		'MESSAGE_MEASURMENTID' => env('FIREBASE_MEASURMENTID'),
	],
	'wholesale_email' => env('WHOLESALE_EMAIL'),

];
