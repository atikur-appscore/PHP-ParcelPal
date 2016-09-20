<?php

namespace App\Jobs\Parcel;

use App\Jobs\Job;
use Illuminate\Database\Eloquent\Model;

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
        $this->entity->update([
            'delivered' => $this->attributes['delivered'],
            'user_id' => \Auth::user()->id,
        ]);
    }
}
