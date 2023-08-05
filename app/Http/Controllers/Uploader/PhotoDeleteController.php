<?php

namespace App\Http\Controllers\Uploader;

use App\Events\PhotoDeleteEvent;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Photo;
use App\Events\PublicEvent;

class PhotoDeleteController extends Controller
{
    public function photoDelete(Request $request){

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
            'delete_target_id' => 'string|required',
        ]);

        $delete_target_photo_user_id = Photo::where('photo_id', $request['delete_target_id'])->first()['user_id'];

        if($user_id !== $delete_target_photo_user_id){
            return response()->json(['status' => 'unauthorized'], 401);
        }

        Photo::where('photo_id', $request['delete_target_id'])->delete();

        event(new PublicEvent('photo_deleted', $request['delete_target_id']));
        return response()->json(['status' => 'success'], 200);
    }

}
