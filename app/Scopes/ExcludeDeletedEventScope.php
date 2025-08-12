<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ExcludeDeletedEventScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // event_participantsテーブルとeventsテーブルをJOINして、
        // 論理削除されていないイベントのみを対象とする
        $builder->whereHas('event', function ($query) {
            // Eventモデルで既にSoftDeletesが適用されているため、
            // 自動的に削除されていないレコードのみが対象となる
        });
    }
}
