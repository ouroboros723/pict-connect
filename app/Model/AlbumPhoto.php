<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\AlbumPhoto
 *
 * @property int $album_master_id アルバム-写真id
 * @property int $user_id アルバムマスタid
 * @property int|null $event_id イベントid
 * @property int $photo_id 写真id
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \App\Model\AlbumMaster|null $albumMaster
 * @property-read \App\Model\Event|null $event
 * @property-read \App\Model\Photo|null $photo
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto whereAlbumMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto wherePhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto withoutTrashed()
 * @mixin \Eloquent
 */
class AlbumPhoto extends BaseModel
{
    use SoftDeletes;

    protected $table = 'album_photos'; // table name.
    protected $primaryKey = 'album_photo_id'; // primary key name.

    protected $guarded = [
        'album_photo_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // setting casts.
    protected $casts = [
        'album_photo_id' => 'integer',
        'album_master_id' => 'integer',
        'event_id' => 'integer',
        'photo_id' => 'integer',
    ];

    /**
     * アルバムマスター
     * @return BelongsTo
     */
    public function albumMaster() {
        return $this->belongsTo(AlbumMaster::class, 'album_master_id', 'album_master_id');
    }

    /**
     * イベント
     * @return BelongsTo
     */
    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    /**
     * 写真
     * @return BelongsTo
     */
    public function photo() {
        return $this->belongsTo(Photo::class, 'photo_id', 'photo_id');
    }
}
