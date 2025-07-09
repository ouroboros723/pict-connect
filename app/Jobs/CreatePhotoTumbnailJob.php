<?php

namespace App\Jobs;

use App\Events\PublicEvent;
use App\Models\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Log;

class CreatePhotoTumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $storedPath;
    public string $thumbnailDir;
    public string $fileToken;
    /**
     * @var mixed
     */
    public $userId;
    /**
     * @var mixed
     */
    public $eventId;
    /**
     * @var mixed
     */
    public $storeDir;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($storedPath, string $thumbnailDir, string $fileToken, $userId, $eventId, $storeDir)
    {
        $this->storedPath = $storedPath;
        $this->thumbnailDir = $thumbnailDir;
        $this->fileToken = $fileToken;
        $this->userId = $userId;
        $this->eventId = $eventId;
        $this->storeDir = $storeDir;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::path($this->storedPath));
        $image->save(Storage::path($this->storedPath));

        //サムネイル画像バイナリ生成();
        $maxWidth = 500; // your max width
        $maxHeight = 500; // your max height

        if ($image->height() > $image->width()) {
            $maxWidth = null;
        } else {
            $maxHeight = null;
        }

        $image->scale($maxWidth, $maxHeight);
        $image->save(Storage::path($this->thumbnailDir . '/' . $this->fileToken));

        $newPhoto = Photo::create(
            [
                'user_id' => $this->userId,
                'event_id' => $this->eventId,
                'store_path' => $this->storedPath,
            ]
        );

        if($newPhoto instanceof Photo) {
            event(new PublicEvent('new_photo'));
        }
    }
}
