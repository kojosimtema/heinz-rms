<?php

namespace App\Reports;

use App\Reports\PropertyReport as Property;

class CommunityPropertyReport extends Model
{
	protected $table = 'communities';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $year = '2018';


    public function withRelation($relations, $year)
    {
        // dd($year);
        return $this->with($relations);
    }

    public static function setYear($value)
    {
        $this->year = $value;
    }

    public function properties()
    {
      return $this->hasMany('App\Property','community_id');
    }
    public function bills()
    {
      return $this->hasMany('App\Bill','community_id', 'code');
    }
    public function businesses()
    {
      return $this->hasMany('App\Business','community_id');
    }
    

}
