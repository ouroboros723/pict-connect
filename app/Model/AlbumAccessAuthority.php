<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\AlbumAccessAuthority
 *
 * @property int $album_access_authority_id アルバムアクセス権限id
 * @property int $album_photo_id アルバム-写真id
 * @property string|null $token アクセストークン
 * @property string|null $sns_screen_name 連携先SNS スクリーンネーム(@hoge)
 * @property int|null $authorized_user_id 承認済みユーザー
 * @property bool $is_writable アルバム内容の変更の可否
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \App\Model\AlbumPhoto|null $albumPhoto
 * @property-read \App\Model\User|null $authorizedUser
 * @property-read \App\Model\GuestLogin|null $guestLogin
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereAlbumAccessAuthorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereAlbumPhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereAuthorizedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereIsWritable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereSnsScreenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumAccessAuthority withoutTrashed()
 * @mixin \Eloquent
 */
class AlbumAccessAuthority extends BaseModel
{
    use SoftDeletes;

    protected $table = 'album_access_authorities'; // table name.
    protected $primaryKey = 'album_access_authority_id'; // primary key name.

    protected $guarded = [
        'album_access_authority_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // setting casts.
    protected $casts = [
        'album_access_authority_id' => 'integer',
        'album_photo_id' => 'integer',
        'token' => 'string',
        'sns_screen_name' => 'string',
        'authorized_user_id' => 'integer',
        'is_writable' => 'boolean',
    ];

    /**
     * アルバム-写真
     * @return BelongsTo
     */
    public function albumPhoto(): BelongsTo
    {
        return $this->belongsTo(AlbumPhoto::class, 'album_photo_id', 'album_photo_id');
    }

    /**
     * ゲストログイン中ユーザの情報
     * @return BelongsTo
     */
    public function guestLogin(): BelongsTo
    {
        return $this->belongsTo(GuestLogin::class, 'sns_screen_name', 'sns_screen_name');
    }

    /**
     * 承認済みユーザー
     * @return BelongsTo
     */
    public function authorizedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorized_user_id', 'user_id');
    }
}
