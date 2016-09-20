<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Favourite;
use App\Services\Contracts\FavouriteService;

class FavouriteController extends ApiController
{
    protected $dataSelect = ['id','id as identifier','name','unit_number','street_number','street_name','suburb','state'];

    protected $rules = [
        'name' => "required|min:2|max:255",
        'unit_number' => 'numeric',
        'street_number' => 'required|numeric',
        'street_name' => 'required|min:2|max:255',
        'suburb' => 'required',
        'state' => 'required'
    ];

    public function __construct(Favourite $favourite)
    {
        parent::__construct($favourite);
    }

    public function lists($item = null)
    {
        $item = $this->repository->where('user_id',$this->user->id)->get($this->dataSelect);
        parent::lists($item);

        return response()->json([
            'success' => true,
            'data' => [
                'favourites' => $this->items
            ]
        ]);
    }

    public function add(Request $request, FavouriteService $service)
    {
        $data = $request->only('name','unit_number','street_number','street_name','suburb','state');

        return $this->storeData($this->rules, $data, $service);
    }

    public function delete(Request $request, FavouriteService $service)
    {
    	return $this->deleteData($service, $request->favourite['identifier']);
    }
}
