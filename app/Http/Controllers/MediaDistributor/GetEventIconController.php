<?php

namespace App\Http\Controllers\MediaDistributor;

use App\Http\Requests\GetPhotosListRequest;
use App\Models\Event;
use App\Models\EventJoinToken;
use Config;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

use Redirect;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GetEventIconController extends Controller
{
    /**
     * @param Request $request
     * @param $eventId
     * @return JsonResponse|mixed
     */
    public function getEventIcon($eventId) {
        $event = Event::findOrFail($eventId);

        if (File::exists(Storage::path($event->icon_path))) {
            return Storage::response($event->icon_path, null, [
                'Cache-Control' => 'max-age='.Config::get('cache.photo.full.max-age').', private',
            ]);
        }
        return Redirect::to('/img/common/photos.png');
    }

	/**
	 * @param $eventToken
	 * @return RedirectResponse|StreamedResponse
	 */
	public function getEventIconFromJoinToken($eventToken) {
		$event = EventJoinToken::whereJoinToken($eventToken)->with(['event'])->firstOrFail()->event;

		if (File::exists(Storage::path($event->icon_path ?? null))) {
			return Storage::response($event->icon_path, null, [
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
