<?php

namespace App;

class Business extends Model
{

  protected $table = 'businesses';
  protected $primaryKey = 'business_no';
  protected $keyType = 'string';
  public $incrementing = false;


  public function type()
  {
      return $this->belongsTo('App\BusinessType', 'business_type', 'code');
  }
  public function category()
  {
      return $this->belongsTo('App\BusinessCategory', 'business_category', 'code');
  }
  public function owner()
  {
      return $this->belongsTo('App\BusinessOwner', 'business_owner', 'owner_id')
      ->select(['owner_id', 'name', 'phone']);
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
  public function communities()
  {
      return $this->belongsTo('App\Models\Location\Community', 'community_id', 'code');
  }
  public function street()
  {
      return $this->belongsTo('App\Models\Location\Street', 'street_id', 'code');
  }
  public function bills()
  {
      return $this->hasMany('App\Bill', 'account_no');
  }

}
