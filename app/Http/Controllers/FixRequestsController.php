<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Collector;
use App\PropertyOwner;
use App\BusinessOwner;
use App\EnumGcr;
use App\Payment;
use App\Property;
use App\Business;

class FixRequestsController extends Controller
{

  function __construct()
  {
      $this->middleware('auth');
  }

    public function fixCollectorID()
    {
      $collectors = Collector::latest()->get();
      foreach($collectors as $key => $collector):
        $code = env('ASSEMBLY_CODE')[0].$collector->name[0].sprintf('%03d', $key);
        $collector->collector_id = $code;
        $collector->save();
         // dump($code);
         // dump(sprintf('%03d', $key));
      endforeach;
      dd('done');
    }
    public function fixOwnerID1()
    {
      $owners = PropertyOwner::latest()->get();
      foreach($owners as $key => $owner):
        $code = env('ASSEMBLY_CODE')[0].$owner->name[0].sprintf('%03d', $key);
        $owner->owner_id = $code;
        $owner->save();
         // dump($code);
         // dump(sprintf('%03d', $key));
      endforeach;
      dd('done');
    }
    public function propertyID()
    {
      $ass = 'PR-';
      $properties = Property::where('property_no', 'LIKE', "%{$ass}%")->get();
      foreach($properties as $key => $property):
        $code = 'PR-'.env('ASSEMBLY_CODE').sprintf('%05d', $key);
        $property->property_no = $code;
        $property->save();
         // dump($code);
         // dump(sprintf('%03d', $key));
      endforeach;
      dd('done');
    }
    public function businessID()
    {
      $ass ='BB-';
      $businesses = Business::where('business_no', 'LIKE', "%{$ass}%")->get();
      // dd($businesses);
      foreach($businesses as $key => $business):
        $code = 'BB-'.env('ASSEMBLY_CODE').sprintf('%05d', $key);
        $business->business_no = $code;
        $business->save();
         // dump($code);
         // dump(sprintf('%03d', $key));
      endforeach;
      dd('done');
    }
    public function fixPropertyOwner()
    {
      $properties = Property::latest()->get();
      $owners = PropertyOwner::latest()->get();
      foreach($properties as $key => $property):
        if(is_numeric($property->property_owner)):
          if($a = PropertyOwner::find($property->property_owner)):
            $property->property_owner = $a->owner_id;
            $property->save();
          else:
            $property->delete();
          endif;
        endif;
      endforeach;
      dd('done');
    }
    public function fixBusinessOwner()
    {
      $businesses = Business::latest()->get();
      $owners = BusinessOwner::latest()->get();
      foreach($businesses as $key => $business):
        if(is_numeric($business->business_owner)):
          if($a = BusinessOwner::find($business->business_owner)):
            $business->business_owner = $a->owner_id;
            $business->save();
          else:
            $business->delete();
          endif;
        endif;
      endforeach;
      dd('done');
    }
    public function fixOwnerID2()
    {
      $owners = BusinessOwner::latest()->get();
      foreach($owners as $key => $owner):
        $code = env('ASSEMBLY_CODE')[0].$owner->name[0].sprintf('%03d', $key);
        $owner->owner_id = $code;
        $owner->save();
         // dump($code);
         // dump(sprintf('%03d', $key));
      endforeach;
      dd('done');
    }
    public function fixCollectorIDEnumGCR()
    {
      $gcrs = EnumGcr::latest()->get();
      foreach($gcrs as $key => $gcr):
        $collector = DB::table('collectors')->where('id', $gcr->id_collector)->first();
        $gcr->id_collector = $collector->collector_id;
        $gcr->save();
         // dump($collector);
      endforeach;
      dd('done');
    }
    public function fixCollectorIDPayment()
    {
      $payments = Payment::latest()->get();
      foreach($payments as $key => $payment):
        $collector = DB::table('collectors')->where('id', $payment->collector_id)->first();
        $payment->id_collector = $collector->collector_id;
        $payment->save();
         // dump($payment->collector_id);
      endforeach;
      dd('done');
    }

    public function feeFixingProperty()
    {
      $categories = \App\PropertyCategory::orderBy('id', 'asc')->get();
      foreach ($categories as $category) {
        $feefixing = new \App\PropertyFeefixingCategory();
        $feefixing->code = $category->code;
        $feefixing->description = $category->description;
        $feefixing->rate_pa = $category->rate_pa;
        $feefixing->type_id = $category->type_id;
        $feefixing->min_charge = $category->min_charge;
        $feefixing->year = strval(date('Y') - 1);
        $feefixing->save();
      }
      dd('completed');
    }
    public function feeFixingBusiness()
    {
      $categories = \App\BusinessCategory::orderBy('id', 'asc')->get();
      foreach ($categories as $category) {
        $feefixing = new \App\PropertyFeefixingCategory();
        $feefixing->code = $category->code;
        $feefixing->description = $category->description;
        $feefixing->rate_pa = $category->rate_pa;
        $feefixing->type_id = $category->type_id;
        $feefixing->min_charge = $category->min_charge;
        $feefixing->year = strval(date('Y') - 1);
        $feefixing->save();
      }
      dd('completed');
    }
}
