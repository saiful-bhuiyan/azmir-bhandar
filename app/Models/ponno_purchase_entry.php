<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\mohajon_setup;
use App\Models\ponno_setup;
use App\Models\ponno_size_setup;
use App\Models\ponno_marka_setup;
use App\Models\temp_ponno_sale;
use App\Models\ponno_sales_entry;
use App\Models\stock;

class ponno_purchase_entry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function temp_ponno_sale()
    {
        return $this->hasMany(temp_ponno_sale::class,'purchase_id');
    }

    public function ponno_sales_entry()
    {
        return $this->hasMany(ponno_sales_entry::class,'purchase_id');
    }

    public function mohajon_setup()
    {
        return $this->belongsTo(mohajon_setup::class);
    }

    public function ponno_setup()
    {
        return $this->belongsTo(ponno_setup::class);
    }

    public function ponno_size_setup()
    {
        return $this->belongsTo(ponno_size_setup::class,'size_id');
    }

    public function ponno_marka_setup()
    {
        return $this->belongsTo(ponno_marka_setup::class,'marka_id');
    }

    public function stock()
    {
        return $this->hasMany(stock::class,'purchase_id');
    }
}
