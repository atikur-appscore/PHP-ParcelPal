<?php

namespace App\Jobs\User;

use App\Jobs\Job;
use App\User;

class Store extends Job
{
    protected $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(User $repository)
    {
        $this->attributes['password'] = bcrypt($this->attributes['password']);
        $this->attributes['active'] = false;
        return $repository->create($this->attributes);
    }
}
