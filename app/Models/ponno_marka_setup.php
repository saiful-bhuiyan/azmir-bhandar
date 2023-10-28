<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ponno_purchase_entry;


class ponno_marka_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ponno_purchase_entry()
    {
        return $this->hasMany(ponno_purchase_entry::class,'marka_id');
    }
}
