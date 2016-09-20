<?php

namespace App\Jobs\Offline;

use App\Jobs\Job;
use App\Run;
use App\Parcel;
use App\Favourite;
use Illuminate\Database\Eloquent\Model;

class Offline extends Job
{
    protected $array;

    protected $user;

    public function __construct(array $array)
    {
        $this->array = $array;
        $this->user = \Auth::user();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Run $runRepo, Parcel $parcelRepo, Favourite $favoRepo)
    {
        $this->actionRun($this->array['runs'], $runRepo);
        $this->actionFavourite($this->array['favourites'], $favoRepo);
    }

    protected function actionRun(array $data, Run $repository)
    {   
        $ids = [];
        foreach ($data as $key => $value) {
            $attributes = [
                'title' => $value['title'],
                'date_at' => date('Y-m-d H:i:s', $value['date']),
                'start_location' => json_encode($value['start_location']),
                'end_location' => json_encode($value['end_location']),
                'distance' => $value['distance'],
                'calculated' => $value['calculated'],
                'user_id' => $this->user->id,
            ];
            if (!isset($value['identifier']) || $value['identifier'] == 0) {
                $run = $repository->create($attributes);
            } else {
                $run = $repository->findOrFail($value['identifier']);
                $run->update($attributes);
            }
            array_push($ids, $run->id);
            if (count($value['parcels'])) {
                $this->actionParcel($value['parcels'], $run);
            } else {
                $repository->parcels()->delete();
            }
        }
        $this->user->runs()->whereNotIn('id',$ids)->delete();
    }

    protected function actionParcel(array $data, Model $runEntity)
    {
        $ids = [];
        foreach ($data as $key => $value) {
            $attributes = [
                'parcel_id' => $value['parcel_id'],
                'recipient_name' => $value['recipient_name'],
                'address' => json_encode($value['address']),
                'type' => $value['type'],
                'weight' => $value['weight'],
                'delivery_instructions' => $value['delivery_instructions'],
                'priority' => $value['priority'],
                'delivered' => $value['delivered'],
                'user_id' => $this->user->id,
            ];
            
            if (!isset($value['identifier']) || $value['identifier'] == 0) {
                $parcel = $runEntity->parcels()->create($attributes);
            } else {
                $parcel = $runEntity->parcels()->findOrFail($value['identifier']);
                $parcel->update($attributes);
            }
            array_push($ids, $parcel->id);
        }
        $runEntity->parcels()->whereNotIn('id',$ids)->delete();
        
    }

    protected function actionFavourite(array $data, Favourite $repository)
    {
        $ids = [];
        foreach ($data as $key => $value) {
            $attributes = [
                'name' => $value['name'],
                'unit_number' => $value['unit_number'],
                'street_number' => $value['street_number'],
                'street_name' => $value['street_name'],
                'suburb' => $value['suburb'],
                'state' => $value['state'],
                'user_id' => $this->user->id
            ];
            if (!isset($value['identifier']) || $value['identifier'] == 0) {
                $favourite  = $repository->create($attributes);
                array_push($ids, $favourite->id);
            } else {
                $repository->findOrFail($value['identifier'])->update($attributes);
                array_push($ids, $value['identifier']);
            }
        }
        $this->user->favourites()->whereNotIn('id',$ids)->delete();
    }
}