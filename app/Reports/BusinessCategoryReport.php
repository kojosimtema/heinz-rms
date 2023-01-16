<?php

namespace App\Reports;

use App\Reports\BusinessReport as Business;

class BusinessCategoryReport extends Model
{
	protected $table = 'business_categories';
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
      return $this->hasMany('App\Bill','business_category', 'code');
    }
    public function businesses()
    {
      return $this->hasMany('App\Business','business_category');
    }


}
