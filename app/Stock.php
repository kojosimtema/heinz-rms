<?php

namespace App;
use App\Accountant;
use App\Supervisor;
use App\Collector;

class Stock extends Model
{
    public function get_name_person()
    {
        $id = '';
        if(!empty($this->accountant_id)):
            // $accountant = Accountant::find($this->accountant_id)->first();
            $id = "In Stock";
        endif;
        if(!empty($this->collector_id)):
            $collector = Collector::where('collector_id', $this->collector_id)->first();
            $id = $collector ? $collector->name : 'NA';
        endif;
        if(!empty($this->supervisor_id)):
            $supervisor = Supervisor::where('supervisor_id', $this->supervisor_id)->first();
            $id = $supervisor ? $supervisor->name : 'NA';
        endif;

        return $id;
    }
    public function gcr()
    {
        return $this->hasMany(EnumGcr::class);
    }
}
