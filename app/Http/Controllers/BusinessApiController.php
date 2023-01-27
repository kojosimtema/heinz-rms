<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supervisor;
use App\Collector;
use App\Cashier;
use App\Stock;
use App\EnumGcr;
use DB;
use Image;
use Hash;

use App\Models\Location\Zonal;
use App\Models\Location\Ta;
use App\Models\Location\Electoral;
use App\Models\Location\Community;
use App\Models\Location\Constituency;
use App\Models\Location\Unit;
use App\Models\Location\Street;

use App\Business;
use App\BusinessType;
use App\BusinessCategory;
use App\BusinessOwner;
use App\Bill;

use Cloudder;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\SetupController as Setup;

class BusinessApiController extends Controller
{

    public function getFromData($query)
    {
        $data = [];
        $stock = [];
        if($query === 'supervisor'):
            $data = Supervisor::latest()->get();
        endif;
        if($query === 'stock'):
            $stock = Stock::where('status', 'free')->whereNotNull('accountant_id')->get();
        endif;
        return response()->json(['status' => 'success', 'data' => $data, 'stock' => $stock]);
    }

    public function getFromStock($query, $id = null)
    {
        $data = [];
        if($query === 'supervisor'):
            $data = DB::table('stocks')->where('supervisor_id', $id)->get();
        endif;
        if($query === 'stock'):
            $data = DB::table('stocks')->where('status', 'free')->get();
        endif;
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function getToData($query)
    {
        $data = [];
        if($query === 'supervisor'):
            $data = Supervisor::latest()->get();
        endif;
        if($query === 'collector'):
            $data = Collector::latest()->get();
        endif;
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function findGcr($query)
    {
        $data = Stock::where('min_serial', $query)->first();
        $name = $data->get_name_person();
        $date = DB::table('issue_stocks')->where('stock_id', $data['id'])->first();
        return response()->json(['status' => 'success', 'data' => $data, 'name' => $name, 'date' => $date->date]);
    }

    public function getZonals()
    {
        $data = Zonal::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getTas()
    {
        $data = Ta::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getElectorals()
    {
        $data = Electoral::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getCommunities()
    {
        $data = Community::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getUnits()
    {
        $data = Unit::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getStreets()
    {
        $data = Street::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getConstituencies()
    {
        $data = Constituency::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinesses()
    {
        $data = Business::with(['type', 'category', 'owner', 'tas'])->latest()->get();
        // $data = Business::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinessesD()
    {
        // $data = Business::with(['type', 'category', 'owner', 'tas'])->latest()->get();
        $data = Business::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinessTypes()
    {
        $data = BusinessType::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinessTypeName($id)
    {
        $data = BusinessType::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data->description]);
    }
    public function getBusinessTypeName2($id)
    {
        $data = BusinessType::where('code', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data->description]);
    }
    public function getBusinessCatName($id)
    {
        $data = BusinessCategory::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data->description]);
    }
    public function getBusinessCatName2($id)
    {
        $data = BusinessCategory::where('code', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data->description]);
    }
    public function getBusinessOwnerName($id)
    {
        $data = BusinessOwner::where('id', $id)->first();
        $d = array("firstname" => $data->firstname, "lastname" => $data->lastname);
        return response()->json(['status' => 'success', 'data' => $d]);
    }
    public function getBusinessZonal($id)
    {
        $data = Zonal::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function getBusinessCategories()
    {
        $data = BusinessCategory::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinessOwners()
    {
        $data = BusinessOwner::orderBy('code', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinessOwnerData($id)
    {
        $data = BusinessOwner::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinessTypeData($id)
    {
        $data = BusinessType::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getBusinessCategoryData($id)
    {
        $data = BusinessCategory::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function updateBusinessOwnerData(Request $request, $id)
    {
        // dd('ok');
        $data = $request->validate(['firstname' => 'required', 'lastname' => 'required', 'phone' => '', 'address' => '']);
        $owner = BusinessOwner::where('id', $id)->first();
        $owner->update($data);
        return response()->json(['status' => 'success', 'data' => $owner]);
    }
    public function updateBusinessTypeData(Request $request, $id)
    {
        // dd('ok');
        $data = $request->validate(['code' => 'required', 'description' => 'required', 'budget_code' => '']);
        $type = BusinessType::where('id', $id)->first();
        $type->update($data);
        return response()->json(['status' => 'success', 'data' => $type]);
    }
    public function updateBusinessCategoryData(Request $request, $id)
    {
        // dd('ok');
        $data = $request->validate(['code' => 'required', 'type_id' => 'required', 'description' => '', 'rate_pa' => '', 'min_charge' => '']);
        $category = BusinessCategory::where('id', $id)->first();
        $category->update($data);
        return response()->json(['status' => 'success', 'data' => $category]);
    }
    /** Delete */

    public function deleteBusinessCategoryData($id)
    {
        // dd($id);
        $category = BusinessCategory::where('id', $id)->first();
        $category->delete();
        return response()->json(['status' => 'success', 'data' => 'deleted']);
    }
    public function deleteBusinessTypeData($id)
    {
        // dd($id);
        $type = BusinessType::where('id', $id)->first();
        $type->delete();
        return response()->json(['status' => 'success', 'data' => 'deleted']);
    }

    public function getBusinessBills($query)
    {
        $bill = [];
        $data = [];
        $data = Business::with(['type', 'category', 'owner', 'tas'])->where('id', $query)->first();
        $bill = Bill::with('business')->where('business_id', $query)->first();
        return response()->json(['status' => 'success', 'data' => $data, 'bill' => $bill]);
    }
    public function getCollectors()
    {
        $data = Collector::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getCashiers()
    {
        $data = Cashier::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getCollectorStock($query)
    {
        $data = EnumGcr::where('id_collector', $query)->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function saveBusinessFromMobile(Request $request)
    {
        // return response()->json(['status' => 'success', 'data' => 'okay...'], 201);
        // dd($request()->all());
        $props = $request->validate([
            'business_no' => '', 'business_name' => '', 'firstname' => 'required', 'lastname' => 'required',
            'business_owner' => '', 'business_type' => 'required',
            'business_category' => 'required', 'zonal_id' => '', 'tas_id' => '',
            'street_id' => '', 'loc_longitude' => '', 'loc_latitude' => '',
            'electoral_id' => '', 'tin_number' => '', 'vat_no' => '', 'industry' => '',
            'image' => '', 'reg_no' => '', 'email' => '', 'phone' => '', 'address' => '',
            'employee_no' => '', 'male_employed' => '', 'female_employed' => '', 'property_no' => '',
            'valuation_no' => '', 'gps_code' => '','client' => '', 'community_id' => '', 'store_number' => ''
        ]);
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        $owns = array(
          'name' => $request->firstname . ' ' . $request->lastname,
          'phone' => $request->phone,
          'address' => $request->address
        );
        $ownrs = array(
          'firstname' => $request->firstname,
          'lastname' => $request->lastname,
          'phone' => $request->phone,
          'address' => $request->address
        );
        // if($request->image):
        //     $pic = $this->createImageFromBase64($request->image);
        //     $props = array_merge($props,['image' => $pic]);
        // endif;
        if($request->image):
        //   Cloudder::upload(request('image'), null);
        //   list($width, $height) = getimagesize($request->image);
        //   $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
          
        
        //   $path = Storage::disk('do')->put('businesses', $request->image, 'public');
        //   Storage::disk('do')->put('businesses', base64_decode($request->image), 'public');
        //   $props = array_merge($props,['image' => env('DO_URL').'/'. $path]);
          $path =  $this->createImageFromBase64($request->image, 'businesses');
           $props = array_merge($props,['image' => env('DO_URL').'/'. $path]);
        endif;
        $res = BusinessOwner::create($owns);
        if($res) {
          $owners = BusinessOwner::latest()->count();
          $res->owner_id = strtoupper(env('ASSEMBLY_CODE')[0].$res->name[0].sprintf('%03d', $owners));
          $res->save();
        }
        unset($props['firstname'], $props['lastname']);
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        $props = array_merge($props, ['business_owner' => (string) $res->owner_id, 'business_no' => 'BB-'.env('ASSEMBLY_CODE').mt_rand(10000,100000)]);
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        $business = Business::create($props);
        if($business):
          $tkn = \App\TrackAccountNumber::first();
          $addedValue = $tkn->business + 1;
          $tkn->business = $addedValue;
          $tkn->save();

          if($business->zonal_id == null || $business->zonal_id == "no zonal data" || $business->zonal_id == ""){
            $business->business_no = 'BB-'.env('ASSEMBLY_CODE').sprintf('%05d', $addedValue);
          }else{
            $business->business_no = 'BB-'.strtoupper($business->zonal_id).sprintf('%05d', $addedValue);
          }
          $business->save();

          $collectorPayment = $this->createCollectorPayment([
            'email' => $business->client,
            'account_no' => $business->business_no,
            'account_type' => strtoupper('b')
          ]);
          // $billingResponse = \App\Http\Controllers\BillingController::initBusinessBill($business, "2018", "2019");

          if ($business->owner && $business->owner->phone) {
            $mobile = $business->owner->phone;
            if($mobile[0] == '0') $mobile = ltrim($mobile, '0');
            $mobile = '233' . $mobile;
            // dd($mobile);
            // dear ignatius of business_name and account no account_no has been successfully registered with ASHMA.
            $message = 'Dear ' . $business->owner->name . ' of '.$business->business_name . ' and ACC No: '. $business->business_no . ' has been successfully registered with ' .env('ASSEMBLY_SMS_FROM').' Assembly.' ;
            // if(env('contacts')):
            //   $message. = 'For any enquiry, please contact us.' . env('contacts'). '.';
            // endif;
            $smsRes = Setup::sendSms($mobile, $message);
            // dd($smsRes, 'o');
            if ($smsRes == 'good') {
              return response()->json(['status' => 'success', 'message' => 'Saved and SMS sent', 'business' => $business, 'owner' => $ownrs], 201);
            }else{
              return response()->json(['status' => 'success', 'message' => 'Saved and SMS sent', 'business' => $business, 'owner' => $ownrs], 201);
            }
          }else {
            return response()->json(['status' => 'success', 'data' => 'Saved with no owner number']);
          }
        endif;
        // return response()->json(['status' => 'success', 'data' => $props], 201);
        return response()->json(['status' => 'success', 'business' => $business, 'owner' => $ownrs], 201);
    }

    private function createCollectorPayment($data) {
      $collector = \App\Collector::where('email', $data['email'])->first();
      $data = array_merge($data, ['collector_id' => $collector->collector_id, 'name' => $collector->name, 'username' => $collector->username, 'paid' => 0]);
      $payment = \App\CollectorPayment::create($data);
      return true;
    }



    public function getBusinessFromMobile($prop)
    {
        $business = Business::where('business_no', $prop)->first();
        if(!$business):
            return response()->json(['status' => 'success', 'business' => '', 'owner' => ''], 201);
        endif;
        $ownerName = BusinessOwner::where('owner_id', $business->business_owner)->first();
        $name = explode(" ", $ownerName->name);
        $owner = ["firstname" => $name[0], "lastname" => $name[1]];
        if (count($name) > 2) $owner = array_merge($owner, ["lastname" => $name[1] . " " . $name[2]]);
        // dd($owner);
        return response()->json(['status' => 'success', 'business' => $business, 'owner' => $owner], 201);
    }

    public function getBusinessesFromMobile($email, $number = 5)
    {
        $business = Business::where('client', $email)->paginate($number);

        return response()->json(['status' => 'success', 'business' => $business], 201);
    }

    public function updateBusinessFromMobile(Request $request, $businessID, $owner)
    {

      // dd($request->all());
      // $businessOwner;
      $business = Business::where('id', $businessID)->first();

        if($request->firstname || $request->lastname || $request->phone || $request->address):
            $businessOwner = BusinessOwner::where('owner_id', $business->business_owner)->first();
            // dd($businessOwner);
            $businessOwner->name = $request->firstname ." ".$request->lastname;
            $businessOwner->phone = $request->phone;
            $businessOwner->address = $request->address;
            $businessOwner->update();
        endif;

        $business->business_name=$request->business_name;
        $business->vat_no=$request->vat_no;
        $business->reg_no=$request->reg_no;
        $business->tin_number=$request->tin_number;
        $business->industry=$request->industry;
        $business->gps_code=$request->gps_code;
        $business->employee_no=$request->employee_no;
        $business->store_number=$request->store_number;
        $business->update();
        // dd($business, $businessOwner);

        return response()->json(['status' => 'success', 'business' => $business, 'owner' => $businessOwner], 201);
    }

    public function createImageFromBase64($image){
        $file_name = 'image_'.time().'.png'; //generating unique file name;
        @list($type, $image) = explode(';', $file_data);
        @list(, $file_data) = explode(',', $file_data);

        if($file_data!=""){ // storing image in storage/app/public Folder
               \Storage::disk('public')->put($file_name,base64_decode($file_data));
         }
         return $file_name;
     }

     public function checkMobileAuth(Request $request)
     {
        $res = '';
        $email = '';
         $collector = Collector::where('email', $request->email)->first();

         if ($collector && Hash::check($request->password, $collector->password)) {
            $res = 'verified';
            $email = $collector->email;
        }else{
            $res = 'fraud';
        }

        return response()->json(['status' => 'success', 'data' => $res, 'email' => $email], 201);
     }

     public function getBusinessTC($id)
     {
        $cats = BusinessCategory::where('type_id', $id)->get();

        return response()->json(['status' => 'success', 'cats' => $cats], 201);
     }

     public function createImageFromBase64($image_64, $route){

        $file_name = 'image_'.time().'.png';
        $path = $route.'/'.$file_name;
        @list($type, $image_64) = explode(';', $image_64);
        @list(, $image_64)      = explode(',', $image_64);
        if($image_64!=""){
               // storing image in storage/app/public Folder
                //   Storage::disk('public')->put($file_name,base64_decode($file_data));
            $storage = Storage::disk('do')->put($route.'/'.$file_name, base64_decode($image_64), 'public');
            return $path;

        }

    }
}
