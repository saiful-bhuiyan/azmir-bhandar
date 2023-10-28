<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\bank_check_book_setup;
use App\Models\bank_entry;
use App\Models\mohajon_payment_entry;
use App\Models\amanot_entry;
use App\Models\hawlat_entry;
use App\Models\other_joma_khoroc_entry;


class check_book_page_setup extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function bank_check_book_setup()
    {
        return $this->belongsTo(bank_check_book_setup::class);
    }

    public function bank_entry()
    {
        return $this->hasMany(bank_entry::class,'check_id')->withTrashed();
    }

    public function mohajon_payment_entry()
    {
        return $this->hasMany(mohajon_payment_entry::class,'check_id')->withTrashed();
    }

    public function amanot_entry()
    {
        return $this->hasMany(amanot_entry::class,'check_id')->withTrashed();
    }

    public function hawlat_entry()
    {
        return $this->hasMany(hawlat_entry::class,'check_id')->withTrashed();
    }

    public function other_joma_khoroc_entry()
    {
        return $this->hasMany(other_joma_khoroc_entry::class,'check_id')->withTrashed();
    }
}
