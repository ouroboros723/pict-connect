<?php

namespace App\Http\Controllers\MediaDistributor;

use Config;
use File;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Photo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Redirect;
use RuntimeException;

class GetPhotoController extends Controller
{
    public function getPhotosList(Request $request, $limit = 12)
    {
        // Auth Params
        $user_token = $request->userToken;
        $user_token_sec = $request->userTokenSec;

        // Get Settings Params
        $event_id = $request->input('event_id');
        $last_photo_id = $request->input('last_photo_id');

        $user_id = User::where('token', $user_token)
            ->where('token_sec',$user_token_sec)
            ->first(['user_id'])['user_id'];

        if(empty($last_photo_id)){
            $photos = Photo::where('event_id', $event_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->limit($limit)
                ->get();
        } else {
            $photos = Photo::where('event_id', $event_id)
                ->where('photo_id', '>', $last_photo_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->limit($limit)
                ->get();
        }

        foreach ($photos as $key => $value) {
            $photos[$key]['user_info'] = User::where('user_id', $value["user_id"])
                ->first(['user_id', 'screen_name', 'view_name', 'user_icon_path']);

            if (File::exists(storage_path() . '/app/' . $value['store_path']) && !empty($value['store_path'])) {
                $image = Image::make(storage_path() . '/app/' . $value['store_path']);
                $image->orientate();
                $tumbnail = $image->stream('jpg', 50); //サムネイル画像バイナリ生成
                $photos[$key]['photo_base64'] = base64_encode($tumbnail);
                $photos[$key]['mime_type'] = mime_content_type(storage_path() . '/app/' . $value['store_path']);
            }

            if (File::exists(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']) && !empty($photos[$key]['user_info']['user_icon_path'])) {
                $user_icon = Image::make(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']);
                $user_icon->orientate();
                $user_icon_bin = $user_icon->stream('jpg', 40);
                $photos[$key]['user_info']['user_icon_base64'] = base64_encode($user_icon_bin);
                $photos[$key]['user_info']['user_icon_mime_type'] = mime_content_type(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']);
            }
        }

        return response()->json(
            [
                'status' => 'ok',
                'photos' => $photos,
            ], 200);

    }

    public function getTextPhotosList(Request $request)
    {
        // Auth Params
        $user_token = $request->userToken;
        $user_token_sec = $request->userTokenSec;

        // Get Settings Params
        $event_id = $request->input('event_id');
        $last_photo_id = $request->input('last_photo_id');

        $user_id = User::where('token', $user_token)
            ->where('token_sec', $user_token_sec)
            ->firstOrFail(['user_id'])['user_id'];

        if (empty($last_photo_id)) {
            $photos = Photo::where('event_id', $event_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->get();
        } else {
            $photos = Photo::where('event_id', $event_id)
                ->where('photo_id', '>', $last_photo_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->get();
        }

        foreach ($photos as $key => $value) {
            $photos[$key]['user_info'] = User::where('user_id', $value["user_id"])
                ->first(['user_id', 'screen_name', 'view_name', 'user_icon_path']);
        }

        return response()->json(
            [
                'status' => 'ok',
                'photos' => $photos,
            ], 200);

    }

    //TODO: getPrevPhotosList()アクション
//    public function getPrevPhotosList(Request $request)
//    {
//        // Get Settings Params
//        $event_id = $request->input('event_id');
//        $begin_photo_id = $request->input('begin_photo_id');
//
//        if (empty($begin_photo_id)) {
//            return response()->json(['status' => 'begin_photo_id_is_undefined'], 400);
//        }
//
//        $photos = Photo::where('event_id', $event_id)
//            ->where('photo_id', '<', $begin_photo_id)
//            ->where('deleted_at', null)
//            ->orderBy('photo_id', 'desc')
//            ->limit('30')
//            ->get();
//
//        foreach ($photos as $key => $value) {
//            $photos[$key]['user_info'] = User::where('user_id', $value["user_id"])
//                ->first(['user_id', 'screen_name', 'view_name', 'user_icon_path']);
//
//            if (File::exists(storage_path() . '/app/' . $value['store_path']) && !empty($value['store_path'])) {
//                $image = Image::make(storage_path() . '/app/' . $value['store_path']);
//                $image->orientate();
//                $tumbnail = $image->stream('jpg', 50); //サムネイル画像バイナリ生成
//                $photos[$key]['photo_base64'] = base64_encode($tumbnail);
//                $photos[$key]['mime_type'] = mime_content_type(storage_path() . '/app/' . $value['store_path']);
//            }
//
//            if (File::exists(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']) && !empty($photos[$key]['user_info']['user_icon_path'])) {
//                $user_icon = Image::make(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']);
//                $user_icon->orientate();
//                $user_icon_bin = $user_icon->stream('jpg', 40);
//                $photos[$key]['user_info']['user_icon_base64'] = base64_encode($user_icon_bin);
//                $photos[$key]['user_info']['user_icon_mime_type'] = mime_content_type(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']);
//            }
//
//        }
//
//        return response()->json(
//            [
//                'status' => 'ok',
//                'photos' => $photos,
//            ], 200);
//
//    }

    /**
     * @param Request $request
     * @param $photo_id
     * @return JsonResponse|mixed
     */
    public function getFullSizePhoto(Request $request, $photo_id) {
        $photo = Photo::wherePhotoId($photo_id)->firstOrFail();

        if (File::exists(storage_path() . '/app/' . $photo->store_path) && !empty($photo->store_path)) {
            return Storage::response($photo->store_path, null, [
                'Cache-Control' => 'max-age='.Config::get('cache.photo.full.max-age').', private',
            ]);
        }
        return Redirect::to('/img/common/photos.png');
    }

    /**
     * @param Request $request
     * @param $photo_id
     * @return JsonResponse|mixed
     */
    public function downloadFullSizePhoto(Request $request, $photo_id) {
        $photo = Photo::wherePhotoId($photo_id)->firstOrFail();

        if (File::exists(storage_path() . '/app/' . $photo->store_path) && !empty($photo->store_path)) {
            return Storage::download($photo->store_path, File::name(storage_path() . '/app/' . $photo->store_path).'.'.$this->getExt(File::mimeType(storage_path() . '/app/' . $photo->store_path)));
        }
        return Redirect::to('/img/common/photos.png');
    }

    public function getThumbnail(Request $request, $photo_id) {
        $photo = Photo::wherePhotoId($photo_id)->firstOrFail();

        if (File::exists(storage_path() . '/app/thumbnails/' . $photo->store_path) && !empty($photo->store_path)) {
            return Storage::response('thumbnails/' . $photo->store_path, null, [
                'Cache-Control' => 'max-age='.Config::get('cache.photo.thumbnail.max-age').', private',
            ]);
        }
        return Redirect::to('/img/common/photos.png');
    }

    public function getProfileIcon(Request $request, $user_id) {
        $user_info = User::findOrFail($user_id);

        if (File::exists(storage_path() . '/app/' . $user_info['user_icon_path']) && !empty($user_info['user_icon_path'])) {
            $user_icon = Image::make(storage_path() . '/app/' . $user_info['user_icon_path']);
            $user_icon->orientate();
            $user_icon->stream('jpg', 40);
            return $user_icon->response();
        }
        return Redirect::to('/img/common/anonman.svg');
    }

    public function getSlideShow(Request $request)
    {
        // Auth Params
        $user_token = $request->userToken;
        $user_token_sec = $request->userTokenSec;

        // Get Settings Params
        $event_id = $request->input('event_id');
        $photo_id = $request->input('photo_id');

        $user_id = User::where('token', $user_token)
            ->where('token_sec', $user_token_sec)
            ->first(['user_id'])['user_id'];

        if (empty($photo_id)) {
            return response()->json(['status' => 'photo_id_is_undefined'], 400);
        } else {
            $photos = Photo::where('event_id', $event_id)
                ->where('photo_id', '<', $photo_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->limit('20')
                ->get();
        }

        foreach ($photos as $key => $value) {
            $photo['user_info'] = User::where('user_id', $value["user_id"])
                ->first(['user_id', 'screen_name', 'view_name', 'user_icon_path']);

            $image = Image::make(storage_path() . '/app/' . $value['store_path']);
            $image->orientate();
            $pict = $image->stream('jpg', 100); //元サイズ画像バイナリ生成
            $photo['photo_base64'] = base64_encode($pict);
            $user_icon = Image::make(storage_path() . '/app/' . $value['user_info']['user_icon_path']);
            $user_icon->orientate();
            $user_icon_bin = $user_icon->stream('jpg', 60);
            $photo['user_info']['user_icon_base64'] = base64_encode($user_icon_bin);
            $photo['mime_type'] = mime_content_type(storage_path() . '/app/' . $value['user_info']['user_icon_path']);
        }

        return response()->json(
            [
                'status' => 'ok',
                'photos' => $photos,
            ], 200);

    }

    //多分要らない
//    public function getPhotoWithStream()
//    {
//
//    }

    public function getPhotosByUser(Request $request)
    {
        $user_token = $request->input('token');
        $user_token_sec = $request->input('token_sec');

        $user_id = User::where('token', $user_token)
            ->where('token_sec', $user_token_sec)
            ->first(['user_id'])
            ->toArray();
        $photos = Photo::where('token', $user_token)
            ->where('token_sec', $user_token_sec);
    }

    //多分要らない
//    public function getPhotosByUserWithStream(Request $request)
//    {
//
//    }

    /**
     * mimeTypeから拡張子を取得
     * @param $mime_type
     * @return string
     */
    private function getExt($mime_type) {
        $ext = "";
        switch ($mime_type) {
            case "image/png":
                $ext = "png";
                break;
            case "image/jpeg":
                $ext = "jpg";
                break;
            case "image/gif":
                $ext = "gif";
                break;
            case "image/svg+xml":
                $ext = "svg";
                break;
            case "image/heic":
                $ext = "heic";
                break;
            case "application/pdf":
                $ext = "pdf";
                break;
            default:
                throw new RuntimeException('許可されていないファイルです');
        }
        return $ext;
    }
}
