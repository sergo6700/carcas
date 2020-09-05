<?php

namespace Api\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BaseApiRepository
 * @package Api\Repositories
 */
abstract class BaseApiRepository extends BaseRepository
{
    /**
     * @return array
     */
    public function fillables()
    {
        return $this->model->getFillable();
    }

    /**
     * @return array
     */
    public function relations()
    {
        return $this->model->getRelations();
    }

    /**
     * @param $id
     * @param $field
     * @return null
     */
    public function findField($id, $field)
    {
        $model = $this->find($id, [
            $field
        ]);

        if (empty($model)) {
            return null;
        }

        return $model->{$field};
    }
}
