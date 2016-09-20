<?php

namespace App\Jobs\Run;

use App\Jobs\Job;
use Illuminate\Database\Eloquent\Model;
use App\Run;

class Update extends Job
{
    protected $attributes;

    protected $entity;

    public function __construct(Model $entity, array $attributes)
    {
        $this->entity = $entity;
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->attributes['start_location'] = json_encode($this->attributes['start_location']);
        $this->attributes['end_location'] = json_encode($this->attributes['end_location']);
        $this->attributes['user_id'] = \Auth::user()->id;
        $this->entity->update($this->attributes);
    }
}
