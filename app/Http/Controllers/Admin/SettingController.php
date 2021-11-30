<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryTimeSlot;
use App\Models\HolidayTimeSlot;
use App\Models\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends BaseController
{
	public function time_slot_index()
	{
		$iData = DeliveryTimeSlot::get();
		$time_slot_duration = [1, 2, 3, 4, 5];
		return view('admin.time_slot', compact('iData', 'time_slot_duration'));
	}

	public function time_slot_store(Request $request)
	{
		try {
			DB::beginTransaction();
			$request_validation = [
				'*.data' => 'array|min:7',
				'data.*.id' => 'required|exists:delivery_time_slots,id',
				'data.*.open' => 'required',
				'data.*.close' => 'required',
				'data.*.time_slot_duration' => 'required',
			];
			$validator = Validator::make($request->all(), $request_validation);
			if ($validator->fails()) {
				throw new Exception($validator->getMessageBag()->first());
			}
			$updateFields = $validator->validate();

			foreach ($updateFields['data'] as $key => $value) {
				$iUpdate = $value;
				$iUpdate['status'] = isset($request->all()['data'][$key]['status']) ? 1 : 0;
				unset($iUpdate['id']);
				DeliveryTimeSlot::find($value['id'])->update($iUpdate);
			}
			DB::commit();

			$iReturn = ['success' => true, 'message' => 'Time slot updated successfully.'];
			$iData = DeliveryTimeSlot::get();
			$time_slot_duration = [1, 2, 3, 4, 5];
			return redirect()->back()->with('iData', $iData)->with('time_slot_duration', $time_slot_duration)->with($iReturn);
		} catch (Throwable $th) {
			DB::rollBack();
			$iData = DeliveryTimeSlot::get();
			$time_slot_duration = [1, 2, 3, 4, 5];
			return redirect()->back()->with('iData', $iData)->with('time_slot_duration', $time_slot_duration)->withErrors([$th->getMessage()]);
		}
	}

	public function holi_day_index(Request $request)
	{
		if ($request->ajax()) {
			$iHolidayTimeSlotData = HolidayTimeSlot::get();
			return DataTables::of($iHolidayTimeSlotData)
				->addIndexColumn()
				->editColumn('status', function ($row) {
					return ' <div class="custom-control custom-switch">
				<input autocomplete="off"  autocomplete="off"  type="checkbox" class="custom-control-input toggle" data-id="' . $row->id . '" id="switch-' . $row->id . '" title="Update status" value="1"
				' . ($row->status == 1 ? 'checked' : '') . '>
				<label class="custom-control-label" for="switch' . $row->id . '"></label>
				</div>';
				})->editColumn('date', function ($row) {
					$createdAt = Carbon::parse($row['date']);
					return $createdAt->format('d-m-Y (D)');
				})->editColumn('updated_at', function ($row) {
					$createdAt = Carbon::parse($row['updated_at']);
					return $createdAt->format('d-m-Y H:i:s');
				})->rawColumns(['status'])->make(TRUE);
		}
	}

	public function holyDayUpdateStatus(Request $request)
	{
		if ($request->ajax()) {
			try {
				DB::beginTransaction();
				$iHoliday = HolidayTimeSlot::find($request->post('id'));
				if ($iHoliday == null) {
					throw new Exception('Holiday not found');
				}
				$iHoliday->status = ($iHoliday->status == 1) ? 0 : 1;
				$iHoliday->save();
				DB::commit();
				return response()->json(['status' => TRUE, 'message' => 'Holiday save successfully.']);
			} catch (Throwable $th) {
				DB::rollback();
				return response()->json(['status' => FALSE, 'message' => $th->getMessage()], 422, [], 5);
			}
		}
	}

	public function holi_day_store(Request $request)
	{
		try {
			DB::beginTransaction();
			$data = request()->validate([
				"name" => "nullable|max:60|min:3",
				"date" => "required|date|date_format:Y-m-d|after:yesterday|unique:holiday_time_slots,date," . $request->id,
				"type" => "required|numeric",
				"open" => "nullable|string",
				"close" => "nullable|string",
			]);
			HolidayTimeSlot::updateOrCreate(["id" => $request->id], $data);
			$iReturn = ["status" => true, "message" => "Holiday saved successfully."];
			DB::commit();
			return response()->json($iReturn);
		} catch (Throwable $th) {
			DB::rollback();
			return response()->json(['success' => FALSE, 'message' => $th->getMessage()], 422, [], 5);
		}
	}

	public function index()
	{
		$data = Setting::where('type', 1)->get();
		return view('admin.setting.index')->with('data', $data);
	}

	public function update(Request $request)
	{
		try {
			DB::beginTransaction();
			$iRequest['data'] = [];
			foreach ($request->except('_token') as $key => $value) {
				$iRequest['data'][] = ['id' => explode('-', $key)[1], 'value' => $value];
			}
			$iReturn = $this->updateSettingCharges($iRequest);
			$data = Setting::where('type', 1)->get();
			DB::commit();
			return redirect()->back()->with('data', $data)->with($iReturn);
		} catch (Exception $e) {
			DB::rollBack();
			$data = Setting::where('type', 1)->get();
			return redirect()->back()->with('data', $data)->withErrors([$e->getMessage()]);
		}
	}

	public function updateSettingCharges($request)
	{
		try {
			DB::beginTransaction();
			$request_validation = [
				'data' => 'array|min:1',
				'data.*.id' => 'required|exists:settings,id',
				'data.*.value' => 'required',
			];
			$validator = Validator::make($request, $request_validation);
			if ($validator->fails()) {
				throw new Exception($validator->getMessageBag()->first());
			}
			$updateFields = $validator->validate();

			foreach ($updateFields['data'] as $key => $value) {
				Setting::find($value['id'])->update(['value' => $value['value']]);
			}

			$iReturn = ['success' => true, 'message' => 'Setting updated successfully.'];
			DB::commit();
			return $iReturn;
		} catch (Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}

	public function contactUs()
	{
		$settings = Setting::all()->pluck('value', 'key')->toArray();
		$days_type = config('constants.contact_us_days_type');
		return view('admin.contactus.index', compact('settings'))->with('days_type', $days_type);
	}

	public function storeCC(Request $request)
	{
		try {
			DB::beginTransaction();

			$settings = request()->validate([
				"customer_center_phone" => "required|regex:/^\+(?:[0-9] ?){6,14}[0-9]$/",
				"customer_center_days_from" => "required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday",
				"customer_center_days_to" => "required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday",
				"customer_center_time_from" => "required|date_format:H:i",
				"customer_center_time_to" => "required|date_format:H:i",
			]);
			foreach ($settings as $key => $value) {
				Setting::where('key', $key)->update(['value' => $value]);
			}
			DB::commit();
			return redirect()->back()->with(['success' => true, 'message' => 'Contact-us saved successfully.']);
		} catch (Throwable $th) {
			DB::rollback();
			throw $th;
		}
		return redirect(url('admin/contact-us'));
	}

	public function storeEmail(Request $request)
	{
		try {
			DB::beginTransaction();

			$settings = request()->validate([
				"email" => "required|email",
				"email_days_from" => "required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday",
				"email_days_to" => "required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday",
				"email_time_from" => "required|date_format:H:i",
				"email_time_to" => "required|date_format:H:i",
			]);
			foreach ($settings as $key => $value) {
				Setting::where('key', $key)->update(['value' => $value]);
			}
			DB::commit();
			return redirect()->back()->with(['success' => true, 'message' => 'Contact-us saved successfully.']);
		} catch (Throwable $th) {
			DB::rollback();
			throw $th;
		}
	}

	public function storeLiveChat(Request $request)
	{
		try {
			DB::beginTransaction();
			$settings = request()->validate([
				"live_chat_title" => "required|string",
				"live_chat_days_from" => "required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday",
				"live_chat_days_to" => "required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday",
				"live_chat_time_from" => "required|date_format:H:i",
				"live_chat_time_to" => "required|date_format:H:i",
			]);
			foreach ($settings as $key => $value) {
				Setting::where('key', $key)->update(['value' => $value]);
			}

			DB::commit();
			return redirect()->back()->with(['success' => true, 'message' => 'Contact-us saved successfully.']);
		} catch (Throwable $th) {
			DB::rollback();
			throw $th;
		}
	}

	public function storeShop(Request $request)
	{
		try {
			DB::beginTransaction();
			$settings = request()->validate([
				"shop_latitude" => "nullable|numeric|between:-90,90",
				"shop_longitude" => "nullable|numeric|between:-180,180",
				"shop_phone" => "required|regex:/^\+(?:[0-9] ?){6,14}[0-9]$/",
				"shop_address" => "required|string|max:200",
				"shop_email" => "required|email",
				"shop_map" => "nullable",
			]);
			foreach ($settings as $key => $value) {
				Setting::where('key', $key)->update(['value' => $value]);
			}

			DB::commit();
			return redirect()->back()->with(['success' => true, 'message' => 'Contact-us saved successfully.']);
		} catch (Throwable $th) {
			DB::rollback();
			throw $th;
		}
	}

	public function storeWarehouse(Request $request)
	{
		try {
			DB::beginTransaction();

			$settings = request()->validate([
				"warehouse_latitude" => "nullable|numeric|between:-90,90",
				"warehouse_longitude" => "nullable|numeric|between:-180,180",
				"warehouse_phone" => "required|regex:/^\+(?:[0-9] ?){6,14}[0-9]$/",
				"warehouse_address" => "required|string|max:200",
				"warehouse_email" => "required|email",
				"warehouse_map" => "nullable",
			]);
			foreach ($settings as $key => $value) {
				Setting::where('key', $key)->update(['value' => $value]);
			}
			DB::commit();
			return redirect()->back()->with(['success' => true, 'message' => 'Contact-us saved successfully.']);
		} catch (Throwable $th) {
			DB::rollback();
			throw $th;
		}
	}

	public function city_time_duration_index()
	{
		$data = Country::with(['cities'])->where('status', 1)->get();
		$typeData = config('constants.city.duration_type');
		return view('admin.cityDuration')->with('data', $data)->with('typeData', $typeData)->with('currency', $this->currency);
	}

	public function city_time_duration_update(Request $request)
	{
		try {
			DB::beginTransaction();
			$iRequest['data'] = $request->formData;
			$request_validation = [
				'data' => 'array',
				'data.*.duration_time' => 'required|nullable|numeric',
				'data.*.duration_type' => 'required|numeric',
			];
			$validator = Validator::make($iRequest, $request_validation);
			if ($validator->fails()) {
				throw new Exception($validator->getMessageBag()->first());
			}
			$updateFields = $validator->validate();
			foreach ($updateFields['data'] as $key => $value) {
				City::find($key)->update($value);
			}
			DB::commit();
			return redirect()->back()->with(['success' => true, 'message' => 'City duration saved successfully.']);
		} catch (Exception $e) {
			DB::rollBack();
			return redirect()->back()->withErrors([$e->getMessage()]);
		}
	}
}
