<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$videoData = Video::latest()->get();
			// Using Eloquent
			return DataTables::of($videoData)->make(true);
		}
		return view('admin.videos.index');
	}

	public function get_all(Request $request)
	{
		try {
			$length = $request->length > 0 ? $request->length : 10;
			$iRes = Video::select('*');

			$iReturn = $iRes->where('status', 1)->inRandomOrder()
				// ->paginate($length);
				->get();
			return response()->json(['success' => TRUE, 'message' => 'Video Get Successfully', 'data' => $iReturn]);
		} catch (Throwable $th) {
			throw $th;
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		try {
			DB::beginTransaction();
			request()->validate([
				'video' => 'required|max:102400',
				'thumbnail' => 'required|max:102400',
			]);
			if ($request->hasFile('video')) {
				$iVideo = new Video();

				$iVideo->userName = $request->userName;
				$iVideo->userCountry = $request->userCountry;
				$iVideo->userPicture = $request->userPicture;

				$video = $request->file('video');
				$name = md5(RandomStringGenerator(16) . time()) . '.' . $video->extension();
				$video->move(public_path(Config::get('imagepath.path.video')), $name);
				$iVideo->video = $name;

				$thumbnail = $request->file('thumbnail');
				$thumbnail_name = md5(RandomStringGenerator(16) . time()) . '.' . $thumbnail->extension();
				$thumbnail->move(public_path(Config::get('imagepath.path.thumbnail')), $thumbnail_name);
				$iVideo->thumbnail = $thumbnail_name;

				$iVideo->save();
				// $video_id = $iVideo->id;
				// $this->uploadVideo($request, $video_id);
			} else {
				throw new Exception('Video not found');
			}
			DB::commit();
			return response()->json(['success' => TRUE, 'message' => 'Video Uploded Successfully']);
		} catch (Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}


	// public function update(Request $request, $id)
	// {
	// 	try {
	// 		DB::beginTransaction();
	// 		$data = request()->validate([
	// 			"title" => "required|string|regex:/^[a-zA-Z0-9 ]+$/u|min:3|max:30",
	// 			"title_kr" => "required|string|min:1|max:30",
	// 			"sub_title" => "nullable|string|regex:/^[a-zA-Z0-9 ]+$/u|min:3|max:50",
	// 			"sub_title_kr" => "nullable|string|min:1|max:50",
	// 			"web_status" => "boolean",
	// 			"app_status" => "boolean",
	// 			"link" => "nullable|url",
	// 		]);

	// 		$insertFields = $data;
	// 		Video::find($id)->update($insertFields);
	// 		if ($request->hasFile('video') || $request->hasFile('app_video'))
	// 			$this->uploadVideo($request, $id);
	// 		DB::commit();
	// 		return redirect()->route('admin.videos.index')->with(['success' => true, 'message' => 'Video Updated Successfully.']);
	// 	} catch (Throwable $th) {
	// 		DB::rollBack();
	// 		throw $th;
	// 	}
	// }

	// public function uploadVideo(Request $request, $id)
	// {
	// 	try {
	// 		DB::beginTransaction();
	// 		request()->validate([
	// 			'video' => 'required|max:102400',
	// 		]);
	// 		$old_video = [];
	// 		$iVideo = Video::find($id);
	// 		if ($request->hasFile('video')) {
	// 			$video = $request->file('video');
	// 			$name = md5(RandomStringGenerator(16) . time()) . '.' . $video->extension();
	// 			$video->move(public_path(Config::get('imagepath.path.video')), $name);
	// 			$old_video[] = $iVideo->video;
	// 			$iVideo->video = $name;
	// 		}

	// 		$iVideo->save();

	// 		if (!empty($old_video)) {
	// 			foreach ($old_video as $key => $value) {
	// 				$video = str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', $value);
	// 				if (File::exists($video) && preg_match('/^storage/', $video)) {
	// 					File::delete($video);
	// 				}
	// 			}
	// 		}
	// 		DB::commit();
	// 		return ['success' => true, "message" => "Video uploaded successfully."];
	// 	} catch (Throwable $th) {
	// 		DB::rollback();
	// 		throw $th;
	// 	}
	// }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		if ($request->ajax()) {
			try {
				DB::beginTransaction();
				$iVideo = Video::find($id);
				$iData = Video::destroy($id);
				if ($iData !== 1) {
					throw new Exception('Video not found');
				}

				// video Delete
				$video = str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', $iVideo->video);
				if (File::exists($video) && preg_match('/^storage/', $video)) {
					File::delete($video);
				}

				// thumbnail Delete
				$thumbnail = str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', $iVideo->thumbnail);
				if (File::exists($thumbnail) && preg_match('/^storage/', $thumbnail)) {
					File::delete($thumbnail);
				}

				DB::commit();
				return response()->json(['success' => TRUE, 'message' => 'Video deleted successfully']);
			} catch (Exception $e) {
				DB::rollback();
				return response()->json(['success' => FALSE, 'message' => $e->getMessage()], 422, [], 5);
			}
		}
	}

	public function statusUpdate(Request $request, $id)
	{
		if ($request->ajax()) {
			try {
				DB::beginTransaction();
				if (Video::where('id', $id)->exists() == false) {
					throw new Exception('Video not found');
				}
				$iRequest = $request->all();
				Video::find($id)->update([array_keys($iRequest)[0] => array_values($iRequest)[0]]);
				DB::commit();
				return response()->json(['success' => TRUE, 'message' => 'Video status updated successfully.']);
			} catch (Exception $e) {
				DB::rollback();
				return response()->json(['success' => FALSE, 'message' => $e->getMessage()], 422, [], 5);
			}
		}
	}
}
