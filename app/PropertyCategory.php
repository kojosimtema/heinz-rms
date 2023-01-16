<?php

namespace App;

class PropertyCategory extends Model
{
    public function type()
    {
        return $this->belongsTo('App\PropertyType', 'type_id');
    }
}
