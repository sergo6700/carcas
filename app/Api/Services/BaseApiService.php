<?php

namespace Api\Services;

use Api\Filters\BaseApiFilter;
use Api\Repositories\BaseApiRepository;
use Api\Repositories\Criterias\Core\RelationCriteria;
use Api\Repositories\Criterias\Core\SelectCriteria;
use Api\Transformers\BaseApiTransformer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseService
 * @package Api\Services
 */
abstract class BaseApiService
{
    /**
     * @var BaseApiFilter
     */
    protected $filter;

    /**
     * @var BaseApiRepository
     */
    protected $repository;

    /**
     * @var BaseApiTransformer
     */
    protected $transformer;

    /**
     * @var array
     */
    protected $listable = [
        'key' => 'id',
        'value' => 'name',
    ];

    /**
     * BaseApiService constructor.
     * @param BaseApiFilter $filter
     * @param BaseApiRepository $repository
     * @param BaseApiTransformer $transformer
     */
    public function __construct(
        BaseApiFilter $filter,
        BaseApiRepository $repository,
        BaseApiTransformer $transformer
    )
    {
        $this->filter = $filter;
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param $abstract
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setFilter($abstract)
    {
        $this->filter = app()->make($abstract);
    }

    /**
     * @param $abstract
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setRepository($abstract)
    {
        $this->repository = app()->make($abstract);
    }

    /**
     * @param $abstract
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setTransformer($abstract)
    {
        $this->transformer = app()->make($abstract);
    }

    /**
     * @param $id
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function single($id, $data = [])
    {
        $this->applyFixes($data);

        return $this->transformer->transform($this->repository->find($id));
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function collection($data = [])
    {
        $this->applyFixes($data);

        return $this->transformer->transformCollection($this->repository->get());
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function pagination($data = [])
    {
        $this->applyFixes($data);

        return $this->transformer->transformPagination($this->repository->paginate());
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function listable($data = [])
    {
        $selects = [
            $this->listable['key'],
            $this->listable['value'],
        ];

        $this->fixSelects([
            '_selects' => $selects
        ]);
        $this->fixFilters($data);

        return $this->transformer->transformList(
            $this->repository->get(),
            $this->listable['key'],
            $this->listable['value']
        );
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $result = $this->baseCreate($data);

            DB::commit();

            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $result = $this->baseUpdate($id, $data);

            DB::commit();

            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $id
     * @return int
     * @throws \Exception
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $result = $this->baseDelete($id);

            DB::commit();

            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    protected function baseCreate(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    protected function baseUpdate($id, array $data)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return int
     */
    protected function baseDelete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * @param array $data
     * @return $this
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function applyFixes(array $data)
    {
        $this->fixSelects($data);
        $this->fixFilters($data);
        $this->fixRelations($data);

        return $this;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function fixData(array $data)
    {
        Arr::forget($data, [
            '_selects',
            '_relations',
        ]);

        return $data;
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function fixFilters(array $data)
    {
        $this->repository = $this->filter
            ->setData($this->fixData($data))
            ->setRepository($this->repository)
            ->filter();

        return $this;
    }

    /**
     * @param array $data
     * @return $this|array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function fixSelects(array $data)
    {
        if (!Arr::has($data, '_selects')) {
            return ['*'];
        }

        if (!is_array($data['_selects'])) {
            throw new \Exception('The _selects must be array');
        }

        $result = [];

        $fillables = $this->repository->fillables();

        foreach ($data['_selects'] as $select) {
            if ($select === 'id' || $select === 'created_at' || $select === 'updated_at') {
                $result[] = $select;
                continue;
            }

            if (!in_array($select, $fillables)) {
                continue;
            }

            $result[] = $select;
        }

        $this->repository->pushCriteria(new SelectCriteria($result));

        return $this;
    }

    /**
     * @param array $data
     * @return $this|array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function fixRelations(array $data)
    {
        if (!Arr::has($data, '_relations')) {
            return [];
        }

        if (!is_array($data['_relations'])) {
            throw new \Exception('The _relations must be array');
        }

        $result = [];

        $relations = $this->repository->relations();

        foreach ($data['_relations'] as $relation => $options) {
            if (!in_array($relation, $relations)) {
                continue;
            }

            if (!is_array($options)) {
                throw new \Exception('The relation options must be array');
            }

            if (!Arr::has($options, 'selects')) {
                $options['selects'] = ['*'];
            }

            $result[$relation] = $options;
        }

        $this->repository->pushCriteria(new RelationCriteria($result));

        return $this;
    }
}
