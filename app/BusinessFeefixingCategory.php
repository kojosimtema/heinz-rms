<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessFeefixingCategory extends Model
{
  public function type()
  {
      return $this->belongsTo('App\BusinessType', 'type_id');
  }
}
