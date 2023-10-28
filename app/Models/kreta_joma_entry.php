<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kreta_setup;
use App\Models\bank_setup;

class kreta_joma_entry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kreta_setup()
    {
        return $this->belongsTo(kreta_setup::class);
    }

    public function bank_setup()
    {
        return $this->belongsTo(bank_setup::class);
    }
}
