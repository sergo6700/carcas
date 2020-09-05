<?php

namespace Api\Http\Controllers\Traits;

use Illuminate\Http\Request;

/**
 * Trait CrudTrait
 * @package Api\Http\Controllers\Traits
 */
trait CrudTrait
{
    /**
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function single($id, Request $request)
    {
        return $this->getSingle($id, $request->all());
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function paginated(Request $request)
    {
        return $this->getPagination($request->all());
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function collected(Request $request)
    {
        return $this->getCollection($request->all());
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        return $this->processCreation($request->all());
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function update($id, Request $request)
    {
        return $this->processEditing($id, $request->all());
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        return $this->processDeletion($id);
    }
}
