<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ponno_setup;

class mohajon_commission_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ponno_setup()
    {
        return $this->belongsTo(ponno_setup::class);
    }
}
