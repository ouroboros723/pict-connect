<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\GuestLogin
 *
 * @property int $guest_login_id ゲストログインid
 * @property string $sns_screen_name 連携先SNS スクリーンネーム(@hoge)
 * @property int $sns_type SNS種別
 * @property string $guest_token 認証トークン
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Model\AlbumAccessAuthority> $albumAccessAuthorities
 * @property-read int|null $album_access_authorities_count
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin whereGuestLoginId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin whereGuestToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin whereSnsScreenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin whereSnsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestLogin withoutTrashed()
 * @mixin \Eloquent
 */
class GuestLogin extends BaseModel
{
    use SoftDeletes;

    protected $table = 'guest_logins'; // table name.
    protected $primaryKey = 'guest_login_id'; // primary key name.

    protected $guarded = [
        'guest_login_id',
        'created_at',
        'updated_at',
    ];

    // setting casts.
    protected $casts = [
        'guest_login_id' => 'integer',
        'sns_screen_name' => 'string',
        'sns_type' => 'integer',
        'guest_token' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public const SNS_TYPE_PICTCONNECT = 0;
    public const SNS_TYPE_TWITTER = 1;
    public const SNS_TYPE_MASTODON = 2;
    public const SNS_TYPE_MISSKEY = 3;

    public const SNS_TYPE = [
        self::SNS_TYPE_PICTCONNECT => 'pict-connect',
        self::SNS_TYPE_TWITTER => 'Twitter(X)',
        self::SNS_TYPE_MASTODON => 'Mastodon',
        self::SNS_TYPE_MISSKEY => 'Misskey',
    ];

    /**
     * ゲストログイン中のユーザーがアクセス可能なアルバム
     * @return HasMany
     */
    public function albumAccessAuthorities(): HasMany
    {
        return $this->hasMany(AlbumAccessAuthority::class, 'sns_screen_name', 'sns_screen_name');
    }
}
