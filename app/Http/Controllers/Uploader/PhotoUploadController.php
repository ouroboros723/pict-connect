<?php

namespace App\Http\Controllers\Uploader;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Photo;
use App\Events\PublicEvent;

class PhotoUploadController extends Controller
{
    public function photoStore(Request $request){

        // Auth Params
        $user_token = $request->header('X-User-Token');
        $user_token_sec = $request->header('X-User-Token-Sec');

        // Get Settings Params
        $event_id = $request->input('event_id');
        $user_id = User::where('token', $user_token)
            ->where('token_sec',$user_token_sec)
            ->first(['user_id'])['user_id'];


        if(empty($user_token) || empty($user_token_sec) || empty($user_id))
        {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $request->validate([
            'photo_data' => 'bail|required|mimes:jpeg,bmp,png,gif',
        ]);

        $today = new \DateTime();
        $today = $today->format('Ymd');

        $screen_name = User::where('user_id', $user_id)
            ->first(['screen_name'])['screen_name'];

        $store_dir = 'photos/'.$screen_name.'/'.$today;
        $stored_path = $request->file('photo_data')->store($store_dir);

        Photo::create(
            [
                'user_id' => $user_id,
                'event_id' => $event_id,
                'store_path' => $stored_path,
            ]
        );

        event(new PublicEvent());
        return response()->json(['status' => 'success'], 200);

    }

}
