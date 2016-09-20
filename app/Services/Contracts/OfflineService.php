<?php

namespace App\Services\Contracts;

interface OfflineService extends AbstractService
{
	public function offline(array $data);
}
