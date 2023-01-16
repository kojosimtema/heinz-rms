<?php

namespace App\Reports;

use App\Reports\PropertyReport as Property;

class PropertyCategoryReport extends Model
{
	protected $table = 'property_categories';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $year = '2018';

    // protected $appends = ['count_bills', 'bills_arrears', 'current_bills', 'total_paid_bills', 'bills_array'];

    public function withRelation($relations, $year)
    {
        // dd($year);
        return $this->with($relations);
    }

    public static function setYear($value)
    {
        $this->year = $value;
    }
    public function bills()
    {
      return $this->hasMany('App\Bill','property_category', 'code');
    }
    public function properties()
    {
      return $this->hasMany('App\Property','property_category');
    }


}
