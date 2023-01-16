<?php

namespace App;

class EnumGcr extends Model
{
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
