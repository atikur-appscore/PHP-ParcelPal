<?php

namespace App\Services;

use App\Services\Contracts\UserService;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\User\Store;
use App\Jobs\User\Update;
use App\Jobs\User\Delete;
use App\Jobs\User\Destroy;
use Mail;

class UserServiceJob extends AbstractServiceJob implements UserService
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

	public function sendMail(array $data, array $to , $subject = null, $view = null)
	{
        Mail::send("mail.{$view}", ['data' => $data], function ($m) use ($to, $subject) {
            $m->from('info@parcelcms.freeddns.org', "[Parcel] - {$subject}");

            $m->to($to)->subject($subject);
        });
	}
}
