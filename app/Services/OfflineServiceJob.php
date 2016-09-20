<?php

namespace App\Services;

use App\Services\Contracts\OfflineService;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\Offline\Offline;

class OfflineServiceJob extends AbstractServiceJob implements OfflineService
{
	public function store(array $attributes)
	{
	}

	public function update(Model $entity, array $attributes)
	{
	}

	public function delete(Model $entity)
	{
	}

	public function destroy(array $ids)
	{
	}

	public function offline(array $data)
	{
		return $this->dispatch(new Offline($data));
	}
}
