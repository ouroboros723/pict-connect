<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\Event
 *
 * @property int $event_id event_id
 * @property string $event_name イベント名
 * @property int $event_admin_id イベント管理者id
 * @property string|null $event_detail イベント詳細
 * @property string|null $description 備考
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property string|null $icon_path イベントアイコンのパス
 * @property \Illuminate\Support\Carbon $event_period_start イベント開催期間(開始)
 * @property \Illuminate\Support\Carbon $event_period_end イベント開催期間(終了)
 * @property-read \App\Models\User|null $eventAdmin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventParticipant> $participants
 * @property-read int|null $participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Photo> $photos
 * @property-read int|null $photos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventPeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventPeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withoutTrashed()
 * @mixin \Eloquent
 */
class Event extends BaseModel
{
    // todo: if have factories, this use.
    //use HasFactory;
    use SoftDeletes;

    protected $table = 'events'; // table name.
    protected $primaryKey = 'event_id'; // primary key name.

    protected $guarded = [
        'event_id',
        'created_at',
        'updated_at',
    ];

    // setting casts.
    protected $casts = [
        'event_id' => 'integer',
        'event_name' => 'string',
        'event_admin_id' => 'integer',
        'event_detail' => 'string',
        'description' => 'string',
        'icon_path' => 'string',
        'event_period_start' => 'datetime',
        'event_period_end' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // setting hidden data columns. (option)
    protected $hidden = [

    ];

    // relations

    /**
     * イベント管理者
     * @return BelongsTo
     */
    public function eventAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'event_admin_id', 'user_id');
    }

    /**
     * イベント参加者
     * @return HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class, 'event_id', 'event_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'event_id', 'event_id');
    }
}
