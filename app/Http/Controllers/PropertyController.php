<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Property;
use App\PropertyType;
use App\PropertyCategory;
use App\PropertyOwner;
use App\Bill;
use QrCode;
use Excel;
use App\Exports\NorminalRowExportProperty;
use App\Jobs\PreparePropertyExport;
use App\Models\Location\Electoral;
use App\Models\Location\Zonal;
use Carbon\Carbon;
use File;
use Response;
use Session;

use App\WebClientPrint\WebClientPrint;
use App\WebClientPrint\Utils;
use App\WebClientPrint\DefaultPrinter;
use App\WebClientPrint\InstalledPrinter;
use App\WebClientPrint\PrintFile;
use App\WebClientPrint\ClientPrintJob;

class PropertyController extends Controller
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
    public function index($array = null)
    {
        // return Storage::download('aabbcc.xlsx');
        // PreparePropertyExport::dispatch(2019, '1401', 'aaabbbccc.xlsx');
        // (new NorminalRowExportProperty(2019, '1401'))->queue('uin.xlsx');

        // $export = new NorminalRowExportProperty(2019, '1401');
        // dd($export);

        // $fr = (new NorminalRowExportProperty(2019, 'EK011'))->download('hjhkj.xlsx');
        // Excel::store(new NorminalRowExportProperty(2019, '1021'), 'invoices.xlsx', 'public');
        // return $export->download('invoices.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

        // return Excel::download(new NorminalRowExportProperty(2019, '1021'), 'invoices.xlsx');
        // return (new NorminalRowExportProperty)->forYear(2019)->forElectoral('1401')->download('invoices.xlsx');
        // dd(public_path());
        // http://res.cloudinary.com/dzsvcvdes/image/upload/c_fit,h_640,w_640/omxlufmmebxhtu3xr7ap.png

        // return Excel::raw(new NorminalRowExportProperty(2019, '1021'), \Maatwebsite\Excel\Excel::XLSX);
        // \App\TemporalFiles::truncate();
        // \App\TemporalFiles::create(['file_name' => $gt]);
        // dd($gt);
        // $data = \App\TemporalFiles::first();
        // dd($data->file_name, $gt);
        // $path = Storage::disk('public')->put('images/kbills/test5.txt', 'hahahahha');
        // File::put('images/kbills/test4.txt', 'hello');
        // $page = File::put('images/kbills/test777.xlsx', $data->file_name);
        // return Response::download(public_path('images/kbills/test777.xlsx'));
        $properties = Property::with(['type', 'category', 'owner'])->orderBy('property_no', 'asc')->paginate(30);
        // dd($properties);
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintHtmlCardController@printFile'), Session::getId());

        // return view('console.prints.demand-notice-card', compact('wcpScript'));
        return view('console.property.index', compact('properties', 'array'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('console.property.create');
    }

    public function createOccupants()
    {
        return view('console.property.occupants');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'building_permit_no' => '',
        //     'serial_no' => '', 'property_type' => 'required',
        //     'property_category' => 'required',
        //     'valuation_no' => '', 'house_no' => '',
        //     'street_id' => '', 'loc_longitude' => '', 'loc_latitude' => '',
        //     'image' => '', 'client' => ''
        // ]);
        // $data = array_merge($data, ['client' => 'none', 'property_owner' => (string) $request->property_owner, 'property_no' => 'PR-'.env('ASSEMBLY_CODE').mt_rand(10000,100000)]);
        //
        // $truesave = Property::create($data);
        $props = $request->validate([
            'name' => 'required', 'valuation_no' => '',
            'phone' => '', 'address' => '', 'building_permit_no' => '',
            'serial_no' => '', 'property_type' => 'required',
            'property_category' => 'required', 'zonal_id' => '',
            'valuation_no' => '', 'house_no' => '', 'rateable_value' => '',
            'street_id' => '', 'loc_longitude' => '', 'loc_latitude' => '',
            'image' => '', 'client' => '', 'electoral_id' => '', 'tas_id' => '', 'community_id' => ''
        ]);
        // dd($props);
        $owns = array(
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        );
        $res = PropertyOwner::create($owns);
        if ($res) {
            $owners = PropertyOwner::latest()->count();
            $res->owner_id = strtoupper(env('ASSEMBLY_CODE')[0] . $res->name[0] . sprintf('%03d', $owners));
            $res->save();
        }
        unset($props['phone'], $props['name']);

        $props = array_merge($props, ['property_owner' => $res->owner_id]);
        $tkn = \App\TrackAccountNumber::first();
        $addedValue = $tkn->property + 1;
        $tkn->property = $addedValue;
        $tkn->save();

        if ($props['valuation_no'] || $props['valuation_no'] != null || $props['valuation_no'] != '') :
            $props = array_merge($props, ['property_no' => $props['valuation_no']]);
        else :
            if ($props['zonal_id'] == null || $props['zonal_id'] == "no zonal data" || $props['zonal_id'] == "") {
                $props = array_merge($props, ['property_no' => 'PR-' . env('ASSEMBLY_CODE') . sprintf('%05d', $addedValue)]);
            } else {
                $props = array_merge($props, ['property_no' => 'PR-' . strtoupper($props['zonal_id']) . sprintf('%05d', $addedValue)]);
            }

        endif;



        $props = array_merge($props, ['client' => 'office@gmail.com']);

        $property = Property::create($props);
        // if($property):
        //   $tkn = \App\TrackAccountNumber::first();
        //   $addedValue = $tkn->property + 1;
        //   $tkn->property = $addedValue;
        //   $tkn->save();
        // endif;
        return redirect()->route('property.create');
    }

    public function preparePropertyBills(Request $request)
    {
        $array = [];
        // $model = Property::where('id', $query)->first();
        // if ($model) $this->initPropertyBill($model);
        // dd('bill prepared');

        $all_models = Property::latest()->get();
        // dd($all_models);
        foreach ($all_models as $model) :
            $response = $this->initPropertyBill($model);
            if ($response) array_push($array, $response);
        endforeach;
        // dd($array);
        if ($array) :
            return view('console.property.error', compact('array'));
        else :
            return redirect()->back();
        endif;
    }

    private function initPropertyBill($model)
    {
        $params = [];
        $bill = [];
        $response;
        if (!$model->category) {
            $response = $model->property_no;
            // return $response;
            // $r = PropertyCategory::where('code', trim($model->property_category))->first();
            $z = PropertyCategory::where('code', 'LIKE', "%{$model->property_category}%")->first();
            // dd($z->min_charge, $model->rateable_value,$z->rate_pa);
            if (!$z) return $response;
            $params = array_merge($params, [
                'min_charge' => floatval($z->min_charge),
                'rate_pa' => floatval($z->rate_pa),
                'rateable_value' => floatval($model->rateable_value)
            ]);
            if (!$z->min_charge) dd('ol');
            // dd($params);
        } else {
            $params = array_merge($params, [
                'min_charge' => floatval($model->category->min_charge),
                'rate_pa' => floatval($model->category->rate_pa),
                'rateable_value' => floatval($model->rateable_value)
            ]);
        }
        // dd($params);
        // dd($model);
        $amount = floatval($params['rateable_value']) * floatval($params['rate_pa']);
        $ans = $amount > $params['min_charge'] ? $ans = $amount : $ans = $params['min_charge'];

        $bill = array_merge($params, [
            'account_no' => $model->property_no,
            'account_balance' => $ans, 'current_amount' => $ans, 'bill_type' => 'p', 'prepared_by' => 'Admin', 'year' => Carbon::now()->year,
            'bill_date' => Carbon::now()->toDateString()
        ]);
        // dd($bill);
        unset($bill['min_charge']);
        // dd($bill);
        $billRes = Bill::where('account_no', $model->property_no)->first();
        if ($billRes) :
            $billRes->update($bill);
        // dump($billRes->id);
        else :
            $t = Bill::create($bill);
        // dump($t->id);
        endif;

        // return $response;



    }

    public function addTypes()
    {
        return view('console.property.types');
    }
    public function saveTypes(Request $request)
    {
        $data = $request->validate(['code' => 'required|unique:property_types', 'description' => 'required', 'budget_code' => '']);
        PropertyType::create($data);
        return redirect()->route('property.types');
    }

    public function addCategories()
    {
        return view('console.property.categories');
    }
    public function saveCategories(Request $request)
    {
        // dd($request->all());
        $data = $request->validate(['code' => 'required', 'type_id' => 'required', 'description' => '', 'rate_pa' => '', 'min_charge' => '']);
        // if($request->type_id && $request->code):
        //   $code = $request->type_id.'-'.$request->code;
        //   $data = array_merge($data, ['code' => $code]);
        // endif;
        PropertyCategory::create($data);
        return redirect()->route('property.categories');
    }
    public function addOwners()
    {
        $owners = PropertyOwner::latest()->paginate(30);
        // dd($owners);
        return view('console.property.owners', compact('owners'));
    }
    public function filterOwner(Request $request)
    {
        $query = $request->input('filter');
        if (!$query || $query == '') :
            return redirect()->back();
        endif;

        $owners = PropertyOwner::where('name', 'LIKE', "%{$query}%")->paginate(30);

        return view('console.property.owners', compact('owners'));
    }
    public function saveOwners(Request $request)
    {
        $data = $request->validate(['firstname' => 'required', 'lastname' => 'required', 'phone' => '', 'address' => '']);
        PropertyOwner::create($data);
        return redirect()->route('property.owners');
    }

    public function filterPropertyByColumn(Request $request)
    {
        // dd($request->all());
        $query = '';
        $queryArray = [];
        $properties = [];
        $array = null;
        $reqs = $request->validate(['column' => 'required', 'query' => '']);

        switch ($request->column) {
            case 'property_no':
                $query = $reqs['query'];
                break;

            case 'property_type':
                $query = $reqs['query'];
                break;
            case 'electoral_id':
                $queryArray = Electoral::where('description', 'LIKE', "%{$reqs['query']}%")->pluck('code');
                break;
            case 'property_category':
                $query = $reqs['query'];
                break;
            case 'property_owner':
                $queryArray = \App\PropertyOwner::where('name', 'LIKE', "%{$reqs['query']}%")->pluck('owner_id');
                break;
            case 'zonal_id':
                $queryArray = Zonal::where('description', 'LIKE', "%{$reqs['query']}%")->pluck('code');
                break;

            default:
                $query = '';
                break;
        }

        // dd($queryArray);

        if ($request->column == 'electoral_id' || $request->column == 'property_owner' || $request->column == 'zonal_id') :
            foreach ($queryArray as $key => $array) {
                $pps = Property::where($request->column, 'LIKE', "%{$array}%")->get();
                foreach ($pps as $key => $pp) {
                    array_push($properties, $pp);
                }
            }
        else :
            $properties = Property::where($request->column, 'LIKE', "%{$query}%")->paginate(100);
        endif;

        // dd($properties);

        if ($request->column == 'electoral_id' || $request->column == 'property_owner' || $request->column == 'zonal_id') :
            $properties = $this->paginateArrayCollecction(collect($properties), $perPage = 300, $page = null, $options = []);
            // dd($properties);
            return view('console.property.index', compact('properties', 'array'));
        endif;

        return view('console.property.index', compact('properties', 'array'));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::where('property_no', $id)->first();
        // dd($property);
        return view('console.property.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::where('property_no', $id)->first();
        return view('console.property.edit', compact('property'));
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
            'building_permit_no' => '', 'zonal_id' => '', 'serial_no' => '',
            'property_type' => '', 'property_category' => '', 'zonal_id' => '',
            'valuation_no' => '', 'house_no' => '', 'division' => '',
            'street_id' => '', 'loc_longitude' => '', 'loc_latitude' => '',
            'image' => '', 'electoral_id' => '', 'tas_id' => '', 'community_id' => '',
            'street_id' => '', 'rateable_value' => ''
        ]);

        $owner = \App\PropertyOwner::where('owner_id', $request->owner_id)->first();
        $property = Property::where('property_no', $id)->first();
        if ($owner) :
            if ($request->phone_number) {
                $owner->phone = $request->phone_number;
            }
            if ($request->property_owner) {
                $owner->name = $request->property_owner;
            }

            $owner->save();
        else :
            $res = PropertyOwner::create(['name' => $request->property_owner]);
            if ($res) {
                $owners = PropertyOwner::latest()->count();
                $res->owner_id = strtoupper(env('ASSEMBLY_CODE')[0] . $res->name[0] . sprintf('%03d', $owners));
                $res->save();
            }
            $data = array_merge($data, ['property_owner' => $res->owner_id]);
        endif;
        $property->update($data);
        // if ($truesave) $this->initPropertyBill($truesave);
        return redirect()->route('property.index');
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
}