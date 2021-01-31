<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Facility;

class FacilityController extends Controller
{
    private array $group;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('facility');
    }

    public function list()
    {
        $data['countries'] = Country::orderBy('country')->get();
        $data['facilities'] = Facility::orderBy('facility')
            ->get()
            ->map(function ($facility) {
                return [
                    'id' => $facility->id,
                    'facility' => $facility->facility,
                    'country' => json_decode($facility->country, true),
                ];
            });

        return $data;
    }

    public function store()
    {
        $data = request()->validate([
            'facility' => 'required',
            'country' => 'required',
        ]);
        $data['country'] = json_encode(request('country'), JSON_UNESCAPED_UNICODE);

        Facility::create($data);
    }

    public function destroy($id)
    {
        Facility::find($id)
            ->delete();
    }
}
