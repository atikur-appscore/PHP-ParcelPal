<?php

namespace App\Jobs\Run;

use App\Jobs\Job;
use App\Run;

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
    public function handle(Run $repository)
    {
        $this->attributes['start_location'] = json_encode($this->attributes['start_location']);
        $this->attributes['end_location'] = json_encode($this->attributes['end_location']);
        $this->attributes['user_id'] = \Auth::user()->id;
        $result = $repository->create($this->attributes);

        return [
            'run' => [
                'identifier' => $result->id
            ]
        ];
    }
}
