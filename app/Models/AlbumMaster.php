<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\AlbumMaster
 *
 * @property int $album_master_id アルバム-写真id
 * @property int $user_id アルバムマスタid
 * @property int|null $event_id イベントid
 * @property int $photo_id 写真id
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \App\Models\User|null $albumMaster
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster whereAlbumMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster wherePhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumMaster withoutTrashed()
 * @mixin \Eloquent
 */
class AlbumMaster extends BaseModel
{
    use SoftDeletes;

    protected $table = 'album_photos'; // table name.
    protected $primaryKey = 'album_photo_id'; // primary key name.

    public const OPEN_RANGE_FRAG_PUBLIC = 0;
    public const OPEN_RANGE_FRAG_LIMITED = 1;
    public const OPEN_RANGE_FRAG_PRIVATE = 2;

    public const OPEN_RANGE_FRAG = [
       self::OPEN_RANGE_FRAG_PUBLIC => 'パブリック',
       self::OPEN_RANGE_FRAG_LIMITED => '限定公開',
       self::OPEN_RANGE_FRAG_PRIVATE => 'プライベート',
    ];

    protected $guarded = [
        'album_master_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // setting casts.
    protected $casts = [
        'album_master_id' => 'integer',
        'user_id' => 'integer',
        'event_id' => 'integer',
        'open_range_flag' => 'integer',
    ];

    /**
     * 作成ユーザー
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function albumMaster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'event_id', 'event_id');
    }
}
