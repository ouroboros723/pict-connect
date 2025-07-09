<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

/**
 * App\Model\EventJoinToken
 *
 * @property int $event_join_token_id イベント参加トークンid
 * @property int $event_id イベントid
 * @property string $join_token イベント参加トークン
 * @property \Illuminate\Support\Carbon $expired_at 有効期限
 * @property int $limit_times 使用可能回数
 * @property int $use_times 使用された回数
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \App\Models\Event|null $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereEventJoinTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereJoinToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereLimitTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken whereUseTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventJoinToken withoutTrashed()
 * @mixin \Eloquent
 */
class EventJoinToken extends BaseModel
{
    // todo: if have factories, this use.
    //use HasFactory;

    use SoftDeletes;

    protected $table = 'event_join_tokens'; // table name.
    protected $primaryKey = 'event_join_token_id'; // primary key name.

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // setting casts.
    protected $casts = [
        'event_join_token_id' => 'integer',
        'event_id' => 'integer',
        'join_token' => 'string',
        'expired_at' => 'datetime',
        'limit_times' => 'integer',
        'use_times' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*** Relations ***/
    /**
     * イベント
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    /*** Methods ***/
    /**
     * イベント参加トークン生成(保存はしない)
     * @param int|null $eventId イベントid
     * @param Carbon|null $expiredAt トークン有効期限
     * @param int|null $limitTimes トークン使用回数
     * @return $this
     */
    public function makeEventJoinToken(?int $eventId = null, ?Carbon $expiredAt = null, ?int $limitTimes = null) : self
    {
        if(!is_null($eventId)){
            $this->event_id = $eventId;
        }
        $this->join_token = Str::random(64);
        $this->event_id = $eventId;
        $this->expired_at = $expiredAt ? $expiredAt->format('Y-m-d H:i:s') : null;
        $this->limit_times = $limitTimes;
        return $this;
    }
}
