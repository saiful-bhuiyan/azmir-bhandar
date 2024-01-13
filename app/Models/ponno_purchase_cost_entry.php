<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ponno_purchase_entry;

class ponno_purchase_cost_entry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ponno_purchase_entry()
    {
        return $this->belongsTo(ponno_purchase_entry::class,'purchase_id');
    }
}
