<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\Photo
 *
 * @property int $photo_id 写真id
 * @property int|null $user_id 投稿ユーザーid
 * @property int|null $event_id イベントid
 * @property string|null $store_path 写真保存パス
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property string|null $deleted_at 削除日時
 * @property-read \App\Model\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo wherePhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereStorePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUserId($value)
 * @mixin \Eloquent
 */
class Photo extends BaseModel
{
    protected $table = "photos";
    protected $primaryKey = "photo_id";

    protected $guarded = ['photo_id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
