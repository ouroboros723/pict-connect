<?php

namespace App\Http\Controllers\MediaDistributor;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Photo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

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

        foreach($photos as $key => $value)
        {
            $photos[$key]['user_info'] = User::where('user_id', $value["user_id"])
                ->first(['user_id','screen_name','view_name','user_icon_path']);

            $image = \Image::make(storage_path().'/app/'.$value['store_path']);
            $tumbnail = $image->stream('jpg', 50); //サムネイル画像バイナリ生成
            $photos[$key]['photo_base64'] = base64_encode($tumbnail);
            $photos[$key]['mime_type'] = mime_content_type(storage_path().'/app/'.$value['store_path']);
        }

        return response()->json(
            [
                'status' => 'ok',
                'photos' => $photos,
            ], 200);

    }

    //TODO: getPrevPhotosList()アクション

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
