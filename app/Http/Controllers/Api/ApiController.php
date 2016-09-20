<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\AbstractService;
use Illuminate\Http\Request;
use Validator;

abstract class ApiController extends Controller
{
	protected $repository;

    protected $repositoryName;

    protected $guard = 'api';

    protected $dataSelect = ['*'];

    protected $format = 'Y-m-d H:i:s';

    protected $items;

    protected $item;

    protected $user;

    public function __construct($repository = null)
    {
        if ($repository) {
            $this->repositorySetup($repository);
        }
        $this->user = \Auth::user();
    }

    public function repositorySetup($repository = null)
    {
        $this->repository = $repository;
        $this->repositoryName = strtolower(class_basename($this->repository->getModel()));
    }

    public function lists($item = null)
    {
        try {
            $this->items = ($item) ? $item : $this->repository->get($this->dataSelect);
            if (! $this->items) {
                return response()->json(['error' => 'not_value_' . $this->repositoryName], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_query_' . $this->repositoryName], 401);
        }
    }

    public function detail(Request $request)
    {
        try {
            $this->item = $this->repository->findOrFail($request->identifier);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_find_' . $this->repositoryName], 401);
        }
    }

    public function storeData(array $rules, array $data, AbstractService $service, callable $callback = null)
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator_fails_' . $this->repositoryName,'error' => $validator->errors()->all()], 401);
        }
        try {
            $item = $service->store($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_store_' . $this->repositoryName], 401);
        }
        if (is_callable($callback)) {
            call_user_func_array($callback, [$item]);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    public function updateData(array $rules, array $data, AbstractService $service, $identifier)
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator_fails_' . $this->repositoryName,'error' => $validator->errors()->all()], 401);
        }
        try {
            $entity = $this->repository->findOrFail($identifier);
            $service->update($entity, $data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_update_' . $this->repositoryName], 401);
        }

        return response()->json(['success' => true]);
    }

    public function deleteData(AbstractService $service, $identifier)
    {
        try {
            $entity = $this->repository->findOrFail($identifier);
            $service->delete($entity);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_delete_' . $this->repositoryName], 401);
        }

        return response()->json(['success' => true]);
    }
}
