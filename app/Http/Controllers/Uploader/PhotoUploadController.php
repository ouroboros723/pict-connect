<?php

namespace App\Http\Controllers\Uploader;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Photo;

class PhotoUploadController extends Controller
{
    public function photoStore(Request $request){

        $request->validate([
            'photo_data' => 'bail|required|mimes:jpeg,bmp,png,gif',
        ]);

        $today = new \DateTime();
        $today = $today->format('Ymd');

        $screen_name = "testuser";

        $store_dir = 'photos/'.$screen_name.'/'.$today;
        $stored_path = $request->file('photo_data')->store($store_dir);

        Photo::create(
            [
                'user_id' => '0',
                'event_id' => '0',
                'store_path' => $stored_path,
            ]
        );

        return response()->json(['status' => 'success'], 200);

    }

}
