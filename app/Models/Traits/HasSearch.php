<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    public function scopeWithSearch(Builder $query, array $models)
    {
        $query->when(request()->exists('search'), function ($query) use ($models) {
            foreach ($models as $model) {
                $relations = explode('.', $model);

                $query->where($query->qualifyColumn('id'), request()->get('search'))
                    ->orWhere('name', 'like', '%' . request()->get('search') . '%');
                
                if (count($relations)) {
                    $this->nestedRelationQuery($query, $relations);
                }
            }
        });
    }

    public function nestedRelationQuery($query, &$relations)
    {
        $model = array_shift($relations);

        $query->orWhereHas($model, function ($query) use (&$relations) {
            $query->where($query->qualifyColumn('id'), request()->get('search'))
                ->orWhere('name', 'like', '%' . request()->get('search') . '%');

            if (count($relations)) {
                $this->nestedRelationQuery($query, $relations);
            }
        });
    }
}