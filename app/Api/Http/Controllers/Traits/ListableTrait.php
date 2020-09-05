<?php

namespace Api\Http\Controllers\Traits;

use Illuminate\Http\Request;

/**
 * Trait ListableTrait
 * @package Api\Http\Controllers\Traits
 */
trait ListableTrait
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function listable(Request $request)
    {
        return $this->getList($request->all());
    }
}
