<?php

namespace App\Services\Contracts;

interface UserService extends AbstractService
{
	public function sendMail(array $data, array $to , $view, $subject);
}
