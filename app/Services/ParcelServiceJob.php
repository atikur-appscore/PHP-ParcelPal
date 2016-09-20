<?php

namespace App\Services;

use App\Services\Contracts\ParcelService;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\Parcel\Store;
use App\Jobs\Parcel\Update;
use App\Jobs\Parcel\Delete;
use App\Jobs\Parcel\Destroy;
use App\Jobs\Parcel\Rearrange;
use App\Jobs\Parcel\Delivered;

class ParcelServiceJob extends AbstractServiceJob implements ParcelService
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

	public function rearrange(array $data)
	{
		return $this->dispatch(new Rearrange($data));
	}

	public function delivered(Model $entity, array $attributes)
	{
		return $this->dispatch(new Delivered($entity, $attributes));
	}
}
