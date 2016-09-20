<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ParcelService extends AbstractService
{
	public function rearrange(array $data);

	public function delivered(Model $entity, array $attributes);
}
