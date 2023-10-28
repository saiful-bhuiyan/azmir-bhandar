<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\bank_check_book_setup;
use App\Models\kreta_joma_entry;
use App\Models\mohajon_payment_entry;
use App\Models\mohajon_return_entry;
use App\Models\amanot_entry;
use App\Models\hawlat_entry;
use App\Models\other_joma_khoroc_entry;


class bank_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bank_check_book_setup()
    {
        return $this->hasMany(bank_check_book_setup::class);
    }

    public function kreta_joma_entry()
    {
        return $this->hasMany(kreta_joma_entry::class);
    }

    public function bank_entry()
    {
        return $this->hasMany(bank_entry::class);
    }

    public function mohajon_payment_entry()
    {
        return $this->hasMany(mohajon_payment_entry::class);
    }

    public function mohajon_return_entry()
    {
        return $this->hasMany(mohajon_return_entry::class);
    }

    public function amanot_entry()
    {
        return $this->hasMany(amanot_entry::class);
    }

    public function hawlat_entry()
    {
        return $this->hasMany(hawlat_entry::class);
    }

    public function other_joma_khoroc_entry()
    {
        return $this->hasMany(other_joma_khoroc_entry::class,'other_id');
    }
}
