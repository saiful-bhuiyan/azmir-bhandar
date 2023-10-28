<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kreta_joma_entry;
use App\Models\kreta_koifiyot_entry;
use App\Models\ponno_sales_info;

class kreta_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kreta_joma_entry()
    {
        return $this->hasMany(kreta_joma_entry::class);
    }

    public function kreta_koifiyot_entry()
    {
        return $this->hasMany(kreta_koifiyot_entry::class);
    }

    public function ponno_sales_info()
    {
        return $this->hasMany(ponno_sales_info::class);
    }
}
