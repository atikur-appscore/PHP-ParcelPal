<?php

namespace App\Services;

use App\Services\Contracts\FavouriteService;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\Favourite\Store;
use App\Jobs\Favourite\Update;
use App\Jobs\Favourite\Delete;
use App\Jobs\Favourite\Destroy;

class FavouriteServiceJob extends AbstractServiceJob implements FavouriteService
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
