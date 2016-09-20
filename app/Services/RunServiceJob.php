<?php

namespace App\Services;

use App\Services\Contracts\RunService;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\Run\Store;
use App\Jobs\Run\Update;
use App\Jobs\Run\Delete;
use App\Jobs\Run\Destroy;

class RunServiceJob extends AbstractServiceJob implements RunService
{
	public function store(array $attributes)
	{
		return $this->dispatch(new Store($attributes));
	}

	public function update(Model $entity, array $attributes)
	{
		return $this->dispatch(new Update($entity, $attributes));
	}

	public function delete(Model $entity)
	{
		return $this->dispatch(new Delete($entity));
	}

	public function destroy(array $ids)
	{
		return $this->dispatch(new Destroy($ids));
	}
}
