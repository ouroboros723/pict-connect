<?php

namespace App\Model;

use App\Scopes\ExcludeDeletedEventScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\EventParticipant
 *
 * @property int $event_participants_id イベント参加者id
 * @property int $event_id イベントid
 * @property int $user_id 参加者ユーザーid
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \App\Model\Event|null $event
 * @property-read \App\Model\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant whereEventParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventParticipant withoutTrashed()
 * @mixin \Eloquent
 */
class EventParticipant extends BaseModel
{
    // todo: if have factories, this use.
    //use HasFactory;

    use SoftDeletes;

    protected $table = 'event_participants'; // table name.
    protected $primaryKey = 'event_participants_id'; // primary key name.

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    // setting casts.
    protected $casts = [
        'event_participants_id' => 'integer',
        'event_id' => 'integer',
        'user_id' => 'integer',
    ];



    /*** Relations ***/
    /**
     * イベント参加者
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * イベント
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    /*** Scopes ***/
    /**
     * 削除されていないイベントに関連する参加者のみを取得するスコープ
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithActiveEvents($query)
    {
        return $query->whereHas('event');
    }

    /*** Methods ***/
    /**
     * @param int $eventId
     * @param int $userId
     * @return bool
     */
    public function joinEvent(int $eventId, int $userId): bool
    {
        $this->event_id = $eventId;
        $this->user_id = $userId;
        return $this->save();
    }
}
