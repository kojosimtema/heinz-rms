<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyFeefixingCategory extends Model
{
    public function type()
    {
        return $this->belongsTo('App\PropertyType', 'type_id');
    }
}
