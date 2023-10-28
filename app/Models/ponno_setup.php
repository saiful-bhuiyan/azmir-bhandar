<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\mohajon_commission_setup;
use App\Models\kreta_commission_setup;
use App\Models\ponno_purchase_entry;

class ponno_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mohajon_commission_setup()
    {
        return $this->hasOne(mohajon_commission_setup::class);
    }

    public function kreta_commission_setup()
    {
        return $this->hasOne(kreta_commission_setup::class);
    }

    public function ponno_purchase_entry()
    {
        return $this->hasMany(ponno_purchase_entry::class);
    }
}
