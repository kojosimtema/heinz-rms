<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Location\Zonal;
use App\Models\Location\Ta;
use App\Models\Location\Electoral;
use App\Models\Location\Community;
use App\Models\Location\Constituency;
use App\Models\Location\Unit;
use App\Models\Location\Street;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function createZonals()
    {
        return view('console.location.zonals');
    }

    public function saveZonals(Request $request)
    {
        $zonal = $request->validate(['code' => 'required|unique:zonals', 'description' => 'required']);
        Zonal::create($zonal);
        return redirect()->route('location.zonals');
    }

    public function createTas()
    {
        return view('console.location.tas');
    }

    public function saveTas(Request $request)
    {
        $tas = $request->validate(['code' => 'required|unique:tas', 'description' => 'required']);
        $tas = array_merge($tas,['zonal_id' => 'none']);
        Ta::create($tas);
        return redirect()->route('location.tas');
    }

    public function createElectorals()
    {
        return view('console.location.electorals');
    }

    public function saveElectorals(Request $request)
    {
        $electoral = $request->validate(['code' => 'required|unique:electorals', 'description' => 'required']);
        $electoral = array_merge($electoral,['zonal_id' => 'none']);
        Electoral::create($electoral);
        return redirect()->route('location.electorals');
    }

    public function createCommunities()
    {
        return view('console.location.communities');
    }

    public function saveCommunities(Request $request)
    {
        $community = $request->validate(['code' => 'required|unique:communities', 'description' => 'required']);
        $community = array_merge($community,['electoral_id' => 'none']);
        Community::create($community);
        return redirect()->route('location.communities');
    }

    public function createConstituencies()
    {
        return view('console.location.constituencies');
    }

    public function saveConstituencies(Request $request)
    {
        $data = $request->validate(['code' => 'required|unique:constituencies', 'description' => 'required']);
        $data = array_merge($data,['community_id' => 'none']);
        Constituency::create($data);
        return redirect()->route('location.constituencies');
    }

    public function createUnits()
    {
        return view('console.location.units');
    }

    public function saveUnits(Request $request)
    {
        $unit = $request->validate(['code' => 'required|unique:units', 'description' => 'required']);
        $unit = array_merge($unit,['community_id' => 'none']);
        Unit::create($unit);
        return redirect()->route('location.units');
    }

    public function createStreets()
    {
        return view('console.location.streets');
    }

    public function saveStreets(Request $request)
    {
        $street = $request->validate(['code' => 'required|unique:streets', 'description' => 'required']);
        $street = array_merge($street,['unit_id' => 'none']);
        Street::create($street);
        return redirect()->route('location.streets');
    }
}
