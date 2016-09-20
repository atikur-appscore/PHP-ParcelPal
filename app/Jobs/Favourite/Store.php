<?php

namespace App\Jobs\Favourite;

use App\Jobs\Job;
use App\Favourite;

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
    public function handle(Favourite $repository)
    {
        $this->attributes['user_id'] = \Auth::user()->id;
        $result = $repository->create($this->attributes);
        return [
            'favourite' => [
                'identifier' => $result->id
            ]
        ];
    }
}
