<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Model\User
 *
 * @property int $user_id ユーザーid
 * @property string|null $screen_name ScreenName
 * @property string|null $view_name 表示名
 * @property string|null $password パスワード(ハッシュ化済み)
 * @property string|null $user_icon_path ユーザーアイコンのパス
 * @property string|null $token 認証トークン
 * @property string|null $token_sec 認証トークン(sec)
 * @property string|null $remember_token rememberトークン
 * @property string|null $description 備考
 * @property bool $is_from_sns SNSログインを利用して登録したユーザーか？
 * @property string|null $email メールアドレス
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $adminEvents
 * @property-read int|null $admin_events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventParticipant> $joinedEvents
 * @property-read int|null $joined_events_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsFromSns($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereScreenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTokenSec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereViewName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = "users";
    protected $primaryKey = "user_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
        'screen_name' => 'string',
        'view_name' => 'string',
        'user_icon_path' => 'string',
        'token' => 'string',
        'token_sec' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'description' => 'string',
        'is_from_sns' => 'bool',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function makeToken()
    {
        try {
            return uniqid(bin2hex(random_bytes(1)), true);
        } catch (Exception $e) {
            return 'error';
        }
    }

    public static function maxOrigUserID()
    {
        return self::query()->max('user_id');
    }

    /*** Relations ***/
    /**
     * 管理しているイベント
     * @return HasMany
     */
    public function adminEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'event_admin_id', 'user_id');
    }

    /**
     * 管理しているイベント
     * @return HasMany
     */
    public function joinedEvents(): HasMany
    {
        return $this->hasMany(EventParticipant::class, 'user_id', 'user_id');
    }
}
