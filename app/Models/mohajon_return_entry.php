<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\mohajon_setup;
use App\Models\bank_setup;

class mohajon_return_entry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mohajon_setup()
    {
        return $this->belongsTo(mohajon_setup::class);
    }

    public function bank_setup()
    {
        return $this->belongsTo(bank_setup::class);
    }
}
