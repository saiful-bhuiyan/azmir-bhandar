<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\mohajon_payment_entry;
use App\Models\mohajon_return_entry;
use App\Models\ponno_purchase_entry;

class mohajon_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mohajon_payment_entry()
    {
        return $this->hasMany(mohajon_payment_entry::class);
    }

    public function mohajon_return_entry()
    {
        return $this->hasMany(mohajon_return_entry::class);
    }

    public function ponno_purchase_entry()
    {
        return $this->hasMany(ponno_purchase_entry::class);
    }
}
