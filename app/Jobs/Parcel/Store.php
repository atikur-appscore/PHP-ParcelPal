<?php

namespace App\Jobs\Parcel;

use App\Jobs\Job;
use App\Parcel;

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
    public function handle(Parcel $repository)
    {
        $this->attributes['address'] = json_encode($this->attributes['address']);
        $this->attributes['user_id'] = \Auth::user()->id;
        $result = $repository->create($this->attributes);
        return [
            'parcel' => [
                'identifier' => $result->id
            ]
        ];
    }
}
