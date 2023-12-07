<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kreta_setup;
use App\Models\ponno_sales_entry;
use App\Models\bikroy_marfot_setup;

class ponno_sales_info extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kreta_setup()
    {
        return $this->belongsTo(kreta_setup::class);
    }

    public function ponno_sales_entry()
    {
        return $this->hasMany(ponno_sales_entry::class,'sales_invoice');
    }

    public function bikroy_marfot_setup()
    {
        return $this->belongsTo(bikroy_marfot_setup::class,'marfot_id');
    }
}
