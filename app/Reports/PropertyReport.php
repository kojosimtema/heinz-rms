<?php

namespace App\Reports;

use App\PropertyOwner;

class PropertyReport extends Model
{
	protected $table = 'properties';
    protected $primaryKey = 'property_no';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['arrears'];

    public function type()
    {
        return $this->belongsTo('App\PropertyType', 'property_type', 'code');
    }
    public function category()
    {
        return $this->belongsTo('App\PropertyCategory', 'property_category', 'code');
    }
    public function owner()
    {
        return $this->belongsTo('App\PropertyOwner', 'property_owner', 'owner_id')
        ->select(['owner_id', 'name', 'phone']);
    }

    public function owner_def()
    {
      return PropertyOwner::where('id', $this->property_owner)->first();
    }

    public function zonal()
    {
        return $this->belongsTo('App\Models\Location\Zonal', 'zonal_id', 'code');
    }
    public function tas()
    {
        return $this->belongsTo('App\Models\Location\Ta', 'tas_id', 'code');
    }
    public function electoral()
    {
        return $this->belongsTo('App\Models\Location\Electoral', 'electoral_id', 'code');
    }
    public function street()
    {
        return $this->belongsTo('App\Models\Location\Street', 'street_id', 'code');
    }
    public function bills()
    {
        return $this->hasMany('App\Bill', 'account_no');
    }
    
    public function totalBills()
    {
        return $this->bills->count();
    }
    public function billArrears()
    {
        return $this->bills->sum('arrears');
    }
    public function currentBills()
    {
        return $this->bills->sum('current_amount');
    }
    public function totalPaid()
    {
        return $this->bills->sum('total_paid');
    }
    public function billArray()
    {
        // dd($this->bills[0]);
        return $this->bills[0];
    }
    public function getArrearsAttribute()
     {
         // $bill = (new Bill)->where('account_no',$this->property_no)->where('year', date('Y') - 1)->orderBy('id', 'desc')->first();
         // if ($bill) {
         //     return $bill->arrears;
         // }
         return 0.0;
     }

}
