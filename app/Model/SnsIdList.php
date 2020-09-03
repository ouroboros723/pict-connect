<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SnsIdList extends Model
{
    protected $table = "sns_id_lists";
    protected $primaryKey = "pc_user_id";

    protected $guarded = [];

    public const SNS_TYPE_PICTCONNECT = 0;
    public const SNS_TYPE_TWITTER = 1;

    public static function getOrigID($twitter_id)
    {
        return self::query()->where('sns_id', $twitter_id)->where('sns_type', self::SNS_TYPE_TWITTER)->first('pc_user_id')['pc_user_id'];
    }
}
