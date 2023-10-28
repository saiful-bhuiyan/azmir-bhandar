<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kreta_setup;

class kreta_koifiyot_entry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kreta_setup()
    {
        return $this->belongsTo(kreta_setup::class);
    }
}
