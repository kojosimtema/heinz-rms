<?php

namespace App\Models\Location;

class Zonal extends Model
{
    protected $table = 'zonals';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    // public function properties()
    // {
    //   return $this->hasMany('App\Property','zonal_id');
    // }

    public function electorals()
    {
    	return $this->hasMany('App\Models\Location\Electoral', 'zonal_id');
    }
}
