<?php

namespace App;

class BusinessType extends Model
{

    protected $table = 'business_types';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    public function categories(){
        return $this->hasMany(BusinessCategory::class, 'type_id');
    }

    public function fixcategories()
		{
        return $this->hasMany(BusinessFeefixingCategory::class, 'type_id', 'code');
    }
}
