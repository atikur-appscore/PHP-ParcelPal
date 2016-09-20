<?php

namespace App\Jobs\Parcel;

use App\Jobs\Job;
use App\Parcel;
use App\Run;

class Rearrange extends Job
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Parcel $repository)
    {
        foreach ($this->data['parcels'] as $key => $value) {
            $repository->findOrFail($value['identifier'])
                ->update(['priority' => $value['priority']]);
        }
        app(Run::class)->findOrFail($this->data['run']['identifier'])->update([
            'distance' => $this->data['run']['distance'],
            'calculated' => $this->data['run']['calculated']
        ]);
    }
}
