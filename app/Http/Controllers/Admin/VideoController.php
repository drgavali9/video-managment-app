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
			$videoData = Video::get();
			// Using Eloquent
			return DataTables::of($videoData)->make(true);
		}
		return view('admin.videos.index');
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
				'video' => 'required|video|mimes:mp4,ogx,oga,ogv,ogg,webm|max:102400',
			]);

			$insertFields['title'] = '';
			$insertFields['slug'] = '';
			$video = Video::create($insertFields);
			$video_id = $video->id;
			$this->uploadVideo($request, $video_id);
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

	public function uploadVideo(Request $request, $id)
	{
		try {
			DB::beginTransaction();
			request()->validate([
				'video' => 'required|video|mimes:mp4,ogx,oga,ogv,ogg,webm|max:4048',
			]);
			$old_video = [];
			$video = Video::find($id);
			if ($request->hasFile('video')) {
				$video = $request->file('video');
				$name = md5(RandomStringGenerator(16) . time()) . '.' . $video->extension();
				$video->move(public_path(Config::get('videopath.path.video')), $name);
				$old_video[] = $video->video;
				$video->video = $name;
			}

			$video->save();

			if (!empty($old_video)) {
				foreach ($old_video as $key => $value) {
					$video = str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', $value);
					if (File::exists($video) && preg_match('/^storage/', $video)) {
						File::delete($video);
					}
				}
			}
			DB::commit();
			return ['success' => true, "message" => "Video uploaded successfully."];
		} catch (Throwable $th) {
			DB::rollback();
			throw $th;
		}
	}

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
				$video = Video::find($id);
				$iData = Video::destroy($id);
				if ($iData !== 1) {
					throw new Exception('Video not found');
				}

				// video Delete
				$video = str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', $video->video);
				if (File::exists($video) && preg_match('/^storage/', $video)) {
					File::delete($video);
				}

				$video1 = str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', $video->app_video);
				if (File::exists($video1) && preg_match('/^storage/', $video1)) {
					File::delete($video1);
				}

				$this->reOrder();
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