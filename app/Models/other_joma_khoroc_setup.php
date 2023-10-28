<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\other_joma_khoroc_entry;

class other_joma_khoroc_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function other_joma_khoroc_entry()
    {
        return $this->hasMany(other_joma_khoroc_entry::class,'other_id');
    }
}
