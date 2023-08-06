<?php

namespace App\Http\Controllers\Uploader;

use App\Http\Requests\PhotoRequest;
use App\Model\User;
use DateTime;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Model\Photo;
use App\Events\PublicEvent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PhotoUploadController extends Controller
{
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
        foreach ($request->file('photo_data') as $value) {
            $file_token = Str::random();

            $image = Image::make($value);
            $image->orientate();
            $image->save($value);
            $stored_path = Storage::putFileAs($store_dir, $value, $file_token);

            //サムネイル画像バイナリ生成();
            $maxWidth = 500; // your max width
            $maxHeight = 500; // your max height
            $image = Storage::get($stored_path);
            $image = Image::make($image);
//            $image->stream('jpg', 5);
            $image->height() > $image->width() ? $maxWidth = null : $maxHeight = null;
            $image->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(Storage::path($thumbnail_dir . '/' . $file_token));

            Photo::create(
                [
                    'user_id' => $user_id,
                    'event_id' => $event_id,
                    'store_path' => $stored_path,
                ]
            );
        }


        event(new PublicEvent('new_photo'));
        return response()->json(['status' => 'success']);

    }

}
