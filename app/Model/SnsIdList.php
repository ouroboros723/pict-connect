<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\SnsIdList
 *
 * @property int $pc_user_id pict_connectユーザーid
 * @property int $sns_id 連携先SNSid
 * @property int $sns_type SNS種別
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @property \Illuminate\Support\Carbon|null $deleted_at 削除日時
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList query()
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList wherePcUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList whereSnsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList whereSnsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SnsIdList withoutTrashed()
 * @mixin \Eloquent
 */
class SnsIdList extends BaseModel
{
    use SoftDeletes;

    protected $table = "sns_id_lists";
    protected $primaryKey = "pc_user_id";

    protected $guarded = [];

    public const SNS_TYPE_PICTCONNECT = 0;
    public const SNS_TYPE_TWITTER = 1;
    public const SNS_TYPE_MASTODON = 2;
    public const SNS_TYPE_MISSKEY = 3;

    public static function getOrigID($twitter_id)
    {
        $orig_id_temp = self::query()->where('sns_id', $twitter_id)->where('sns_type', self::SNS_TYPE_TWITTER)->first('pc_user_id');
        if ($orig_id_temp) {
            $orig_id = $orig_id_temp['pc_user_id'];
        } else {
            $orig_id = null;
        }
        return $orig_id;
    }
}
