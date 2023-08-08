<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\Events
 *
 * @property int $event_id event_id
 * @property string $event_name イベント名
 * @property int $event_admin_id イベント管理者id
 * @property string|null $event_detail イベント詳細
 * @property string|null $description 備考
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @property-read \App\Model\User|null $eventAdmin
 * @method static \Illuminate\Database\Eloquent\Builder|Events newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Events newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Events onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Events query()
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereEventAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereEventDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereEventName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Events withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Events withoutTrashed()
 * @mixin \Eloquent
 */
class Events extends BaseModel
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
}
