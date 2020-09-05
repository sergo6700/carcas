<?php

namespace Api\Http\Controllers;

use Api\Core\Response\Response;
use Api\Services\BaseApiService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Class BaseApiController
 * @package Api\Http\Controllers
 */
abstract class BaseApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var BaseApiService
     */
    protected $service;

    /**
     * @var Response
     */
    protected $response;

    /**
     * BaseApiController constructor.
     * @param Response $response
     * @param BaseApiService $service
     */
    public function __construct(
        Response $response,
        BaseApiService $service
    )
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @param $id
     * @param array $data
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getSingle($id, array $data)
    {
        return $this->response->make($this->service->single($id, $data));
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getCollection(array $data)
    {
        return $this->response->make($this->service->collection($data));
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getPagination(array $data)
    {
        return $this->response->make($this->service->pagination($data));
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getList(array $data)
    {
        return $this->response->make($this->service->listable($data));
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function processCreation(array $data)
    {
        return $this->response->make($this->service->create($data));
    }

    /**
     * @param $id
     * @param array $data
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function processEditing($id, array $data)
    {
        return $this->response->make($this->service->update($id, $data));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function processDeletion($id)
    {
        return $this->response->make($this->service->delete($id));
    }
}
