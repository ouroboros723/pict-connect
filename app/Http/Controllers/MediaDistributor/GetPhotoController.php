<?php

namespace App\Http\Controllers\MediaDistributor;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Photo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GetPhotoController extends Controller
{
    public function getPhotosList(Request $request)
    {
        // Auth Params
        $user_token = $request->header('X-User-Token');
        $user_token_sec = $request->header('X-User-Token-Sec');

        // Get Settings Params
        $event_id = $request->input('event_id');
        $last_photo_id = $request->input('last_photo_id');

        $user_id = User::where('token', $user_token)
            ->where('token_sec',$user_token_sec)
            ->first(['user_id'])['user_id'];

        if(empty($user_token) || empty($user_token_sec) || empty($user_id))
        {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        if(empty($last_photo_id)){
            $photos = Photo::where('event_id', $event_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->limit('20')
                ->get();
        } else {
            $photos = Photo::where('event_id', $event_id)
                ->where('photo_id', '>', $last_photo_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->limit('20')
                ->get();
        }

        foreach ($photos as $key => $value) {
            $photos[$key]['user_info'] = User::where('user_id', $value["user_id"])
                ->first(['user_id', 'screen_name', 'view_name', 'user_icon_path']);

            if (\File::exists(storage_path() . '/app/' . $value['store_path']) && !empty($value['store_path'])) {
                $image = Image::make(storage_path() . '/app/' . $value['store_path']);
                $image->orientate();
                $tumbnail = $image->stream('jpg', 50); //サムネイル画像バイナリ生成
                $photos[$key]['photo_base64'] = base64_encode($tumbnail);
                $photos[$key]['mime_type'] = mime_content_type(storage_path() . '/app/' . $value['store_path']);
            }

            if (\File::exists(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']) && !empty($photos[$key]['user_info']['user_icon_path'])) {
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

    //TODO: getPrevPhotosList()アクション
    public function getPrevPhotosList(Request $request)
    {
        // Auth Params
        $user_token = $request->header('X-User-Token');
        $user_token_sec = $request->header('X-User-Token-Sec');

        // Get Settings Params
        $event_id = $request->input('event_id');
        $begin_photo_id = $request->input('begin_photo_id');

        $user_id = User::where('token', $user_token)
            ->where('token_sec', $user_token_sec)
            ->first(['user_id'])['user_id'];

        if (empty($user_token) || empty($user_token_sec) || empty($user_id)) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        if (empty($begin_photo_id)) {
            return response()->json(['status' => 'begin_photo_id_is_undefined'], 400);
        } else {
            $photos = Photo::where('event_id', $event_id)
                ->where('photo_id', '<', $begin_photo_id)
                ->where('deleted_at', null)
                ->orderBy('photo_id', 'desc')
                ->limit('20')
                ->get();
        }

        foreach ($photos as $key => $value) {
            $photos[$key]['user_info'] = User::where('user_id', $value["user_id"])
                ->first(['user_id', 'screen_name', 'view_name', 'user_icon_path']);

            if (\File::exists(storage_path() . '/app/' . $value['store_path']) && !empty($value['store_path'])) {
                $image = Image::make(storage_path() . '/app/' . $value['store_path']);
                $image->orientate();
                $tumbnail = $image->stream('jpg', 50); //サムネイル画像バイナリ生成
                $photos[$key]['photo_base64'] = base64_encode($tumbnail);
                $photos[$key]['mime_type'] = mime_content_type(storage_path() . '/app/' . $value['store_path']);
            }

            if (\File::exists(storage_path() . '/app/' . $photos[$key]['user_info']['user_icon_path']) && !empty($photos[$key]['user_info']['user_icon_path'])) {
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

    public function getFullSizePhoto(Request $request)
    {
        // Auth Params
        $user_token = $request->header('X-User-Token');
        $user_token_sec = $request->header('X-User-Token-Sec');

        // Get Settings Params
        $event_id = $request->input('event_id');
        $photo_id = $request->input('photo_id');

        $user_id = User::where('token', $user_token)
            ->where('token_sec', $user_token_sec)
            ->first(['user_id'])['user_id'];

        if (empty($user_token) || empty($user_token_sec) || empty($user_id)) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

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
        dd($user_id);
        $photos = Photo::where('token', $user_token)
            ->where('token_sec', $user_token_sec);
    }

    //多分要らない
//    public function getPhotosByUserWithStream(Request $request)
//    {
//
//    }
}
