<?php

namespace App\Http\Controllers\Uploader;

use App\Http\Requests\PhotoRequest;
use App\Jobs\CreatePhotoTumbnailJob;
use App\Model\User;
use DateTime;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class PhotoUploadController extends Controller
{
    public function __construct() {
        ini_set('max_file_uploads', 100);
        ini_set('post_max_size', '2048M');
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', '-1');
    }

    /**
     * @throws FileNotFoundException
     */
    public function photoStore(PhotoRequest $request): JsonResponse
    {

        // Auth Params
        $user_token = $request->userToken;
        $user_token_sec = $request->userTokenSec;

        // Get Settings Params
        $event_id = $request->input('event_id');
        $user_id = User::where('token', $user_token)
            ->where('token_sec', $user_token_sec)
            ->first(['user_id'])['user_id'];

        $today = new DateTime();
        $today = $today->format('Ymd');

        $screen_name = User::where('user_id', $user_id)
            ->first(['screen_name'])['screen_name'];

        $store_dir = 'photos/' . $screen_name . '/' . $today;
        $thumbnail_dir = 'thumbnails/' . $store_dir;

        Storage::makeDirectory($thumbnail_dir);
//        dd($request->file('photo_data'));
        //TODO: ここをforeachで回す。
        $status = true;
        foreach ($request->file('photo_data') as $value) {
            $file_token = Str::random();

            $stored_path = Storage::putFileAs($store_dir, $value, $file_token);
            $status = $status && is_string($stored_path);
            CreatePhotoTumbnailJob::dispatchIf(is_string($stored_path), $stored_path, $thumbnail_dir, $file_token, $user_id, $event_id, $store_dir);
//            CreatePhotoTumbnailJob::dispatchNow($stored_path, $thumbnail_dir, $file_token, $user_id, $event_id, $store_dir); // テスト用
        }

        return $status ? response()->json(['status' => 'success']) : response()->json(['status' => 'process_failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
