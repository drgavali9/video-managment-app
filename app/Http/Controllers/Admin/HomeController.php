<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttributeDetails;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Promocode;
use App\Models\State;
use App\Models\WholesaleInquiry;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends BaseController
{
	public function index()
	{
		return view('admin.dashboard');
	}
}
