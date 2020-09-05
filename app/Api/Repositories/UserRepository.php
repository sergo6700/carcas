<?php

namespace Api\Repositories;

use Api\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository
 * @package Api\Repositories
 */
class UserRepository extends BaseApiRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param $id
     * @return array
     */
    public function getPropertyIds($id)
    {
        return DB::table('users_properties')
            ->select(['property_id'])
            ->where('user_id', $id)
            ->pluck('property_id')
            ->toArray();
    }
}
