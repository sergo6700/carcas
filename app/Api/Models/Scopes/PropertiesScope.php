<?php

namespace Api\Models\Scopes;

use Api\Models\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PropertiesScope
 * @package Api\Models\Scopes
 */
class PropertiesScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return bool
     */
    public function apply(Builder $builder, Model $model)
    {
        $table = $model->getTable();

        if (!defined('PROPERTY_IDS')) {
            return false;
        }

        if ($table === 'properties') {
            $builder->whereIn("$table.id", PROPERTY_IDS);
            return true;
        }

        if ($table === 'reservations') {
            $builder->whereNotNull('reservations.property_id');
        }

        if (Schema::hasColumn($table, 'property_id')) {
            $builder->whereIn("$table.property_id", PROPERTY_IDS);
            return true;
        }

        if (Schema::hasColumn($table, 'room_type_id')) {
            $roomTypeIds = RoomType::query()
                ->select(['id'])
                ->pluck('id')
                ->toArray();

            $builder->whereIn("$table.room_type_id", $roomTypeIds);
            return true;
        }

        return true;
    }
}
