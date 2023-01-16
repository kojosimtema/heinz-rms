<?php

namespace App\Reports;

use App\Reports\BusinessReport as Business;

class CommunityBusinessReport extends Model
{
    protected $table = 'communities';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $year = '2018';

    public function withRelation($relations, $year)
    {
        // dd($year)
        return $this->with($relations);
    }

    public function properties()
    {
        return $this->hasMany('App\Property', 'community_id');
    }
    public function businesses()
    {
        return $this->hasMany('App\Business', 'community_id');
    }
    public function bills()
    {
        return $this->hasMany('App\Bill', 'community_id');
    }
}