<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Business;
use App\BusinessType;
use App\BusinessCategory;
use App\BusinessOwner;
use App\Bill;

use Carbon\Carbon;

class BusinessController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businesses = Business::latest()->paginate(30);
        return view('console.business.index', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('console.business.create');
    }

    public function createOccupants()
    {
        return view('console.business.occupants');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'business_no' => '', 'business_name' => '',
            'name' => 'required', 'business_type' => 'required',
            'business_category' => 'required', 'zonal_id' => '', 'tas_id' => '',
            'street_id' => '', 'loc_longitude' => '', 'loc_latitude' => '',
            'electoral_id' => '', 'tin_number' => '', 'vat_no' => '', 'industry' => '',
            'image' => '', 'reg_no' => '', 'email' => '', 'phone' => '', 'address' => '',
            'employee_no' => '', 'male_employed' => '', 'female_employed' => '', 'property_no' => '',
            'valuation_no' => '', 'store_number' => '', 'gps_code' => '', 'client' => ''
        ]);
        $owns = array(
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        );
        $res = BusinessOwner::create($owns);
        if ($res) {
            $owners = BusinessOwner::latest()->count();
            $res->owner_id = strtoupper(env('ASSEMBLY_CODE')[0] . $res->name[0] . sprintf('%03d', $owners));
            $res->save();
        }
        unset($data['phone'], $data['name']);
        $data = array_merge($data, ['business_owner' => $res->owner_id, 'client' => 'office@gmail.com']);
        $tkn = \App\TrackAccountNumber::first();
        $addedValue = $tkn->business + 1;
        $tkn->business = $addedValue;
        $tkn->save();

        if ($data['valuation_no'] || $data['valuation_no'] != null || $data['valuation_no'] != '') :
            $data = array_merge($data, ['business_no' => $data['valuation_no']]);
        else :
            if ($data['zonal_id'] == null || $data['zonal_id'] == "no zonal data" || $data['zonal_id'] == "") {
                $data = array_merge($data, ['business_no' => 'BB-' . env('ASSEMBLY_CODE') . sprintf('%05d', $addedValue)]);
            } else {
                $data = array_merge($data, ['business_no' => 'BB-' . strtoupper($data['zonal_id']) . sprintf('%05d', $addedValue)]);
            }

        endif;

        $truesave = Business::create($data);
        // if ($truesave) $this->initBusinessBill($truesave);
        return redirect()->route('business.create');
    }

    public function prepareBill()
    {
        // $model = Business::where('id', $query)->first();
        // if ($model) $this->initBusinessBill($model);
        // dd('bill prepared');

        $all_models = Business::latest()->get();
        foreach ($all_models as $model) :
            $this->initBusinessBill($model);
        endforeach;
    }

    private function initBusinessBill($model)
    {
        $params = [];
        $bill = [];
        $params = array_merge($params, [
            'min_charge' => floatval($model->category->min_charge),
            'rate_pa' => floatval($model->category->rate_pa),
            'rateable_value' => floatval($model->rateable_value)
        ]);
        // dd($params);
        // dd($model);
        $amount = $params['rateable_value'] * $params['rate_pa'];
        $ans = $amount > $params['min_charge'] ? $ans = $amount : $ans = $params['min_charge'];

        $bill = array_merge($params, [
            'account_no' => $model->property_no, 'property_id' => $model->id,
            'current_amount' => $ans, 'bill_type' => 'b', 'prepared_by' => auth()->user()->id, 'year' => Carbon::now()->year,
            'bill_date' => Carbon::now()->toDateString(), 'total_payment' => $ans
        ]);
        // dd($bill);
        unset($bill['min_charge']);
        // dd($bill);
        Bill::create($bill);
    }

    public function addTypes()
    {
        return view('console.business.types');
    }
    public function saveTypes(Request $request)
    {
        $data = $request->validate(['code' => 'required|unique:business_types', 'description' => 'required', 'budget_code' => '']);
        BusinessType::create($data);
        return redirect()->route('business.types');
    }

    public function addCategories()
    {
        return view('console.business.categories');
    }
    public function saveCategories(Request $request)
    {
        $data = $request->validate(['code' => 'required', 'type_id' => 'required', 'description' => '', 'rate_pa' => '', 'min_charge' => '']);
        BusinessCategory::create($data);
        return redirect()->route('business.categories');
    }
    public function addOwners()
    {
        return view('console.business.owners');
    }
    public function saveOwners(Request $request)
    {
        $data = $request->validate(['firstname' => 'required', 'lastname' => 'required', 'phone' => '', 'address' => '']);
        BusinessOwner::create($data);
        return redirect()->route('business.owners');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business = Business::where('business_no', $id)->with(['bills' => function ($query) {
            $query->where(strtoupper('bill_type'), strtoupper('b'))->orderBy('year', 'desc');
        }])->first();
        return view('console.business.show', compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business = Business::where('business_no', $id)->first();
        return view('console.business.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'business_no' => '', 'business_name' => '',
            'business_type' => '', 'community_id' => '',
            'business_category' => '', 'zonal_id' => '', 'tas_id' => '',
            'street_id' => '', 'loc_longitude' => '', 'loc_latitude' => '',
            'electoral_id' => '', 'tin_number' => '', 'vat_no' => '', 'industry' => '',
            'image' => '', 'reg_no' => '', 'email' => '', 'phone' => '', 'address' => '',
            'employee_no' => '', 'male_employed' => '', 'female_employed' => '', 'property_no' => '',
            'valuation_no' => '', 'gps_code' => '', 'store_number' => '', 'client' => 'none'
        ]);

        $business = Business::where('business_no', $id)->first();
        $owner = \App\BusinessOwner::where('owner_id', $request->owner_id)->first();

        if ($owner) :
            if ($request->phone_number) {
                $owner->phone = $request->phone_number;
            }
            if ($request->business_owner) {
                $owner->name = $request->business_owner;
            }

            $owner->save();
        else :
            $owns = array(
                'name' => $request->business_owner,
            );
            $res = BusinessOwner::create($owns);
            if ($res) {
                $owners = BusinessOwner::latest()->count();
                $res->owner_id = strtoupper(env('ASSEMBLY_CODE')[0] . $res->name[0] . sprintf('%03d', $owners));
                $res->save();
            }
            $data = array_merge($data, ['business_owner' => $res->owner_id]);
        endif;
        $business->update($data);


        // dd($business);

        // if ($truesave) $this->initBusinessBill($truesave);
        return redirect()->route('business.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filterBusinessByColumn(Request $request)
    {
        // dd($request->all());
        $query = '';
        $queryArray = [];
        $businesses = [];
        $array = null;
        $reqs = $request->validate(['column' => 'required', 'query' => '']);

        switch ($request->column) {
            case 'business_no':
                $query = $reqs['query'];
                break;
            case 'business_name':
                $query = $reqs['query'];
                break;

            case 'business_type':
                $query = $reqs['query'];
                break;
            case 'electoral_id':
                $queryArray = \App\Electoral::where('description', 'LIKE', "%{$reqs['query']}%")->pluck('code');
                break;
            case 'business_category':
                $query = $reqs['query'];
                break;
            case 'business_owner':
                // dd($reqs['query']);
                // $bo = \App\BusinessOwner::latest()->get();
                $queryArray = \App\BusinessOwner::where('name', 'LIKE', "%{$reqs['query']}%")->pluck('owner_id');
                // dd($bo);
                break;
            case 'zonal_id':
                $queryArray = \App\Zonal::where('description', 'LIKE', "%{$reqs['query']}%")->pluck('code');
                break;
            case 'store_number':
                $query = $reqs['query'];
                break;

            default:
                $query = '';
                break;
        }

        // dd($queryArray);

        if ($request->column == 'electoral_id' || $request->column == 'business_owner' || $request->column == 'zonal_id') :
            foreach ($queryArray as $key => $array) {
                $pps = Business::where($request->column, 'LIKE', "%{$array}%")->get();
                foreach ($pps as $key => $pp) {
                    array_push($businesses, $pp);
                }
            }
        else :
            // $businesses = Business::where($request->column, 'LIKE', "%{$query}%")->paginate(30);
            $businesses = Business::where($request->column, 'LIKE', "%{$query}%")->paginate(30);
        // dd($businesses);
        endif;

        if ($request->column == 'electoral_id' || $request->column == 'business_owner' || $request->column == 'zonal_id') :
            $businesses = $this->paginateArrayCollecction(collect($businesses), $perPage = 30, $page = null, $options = []);
            return view('console.business.index', compact('businesses', 'array'));
        endif;



        return view('console.business.index', compact('businesses', 'array'));
    }

    /**
     * Gera a paginação dos itens de um array ou collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginateArrayCollecction($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);

        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}