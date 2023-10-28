<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\hawlat_entry;

class hawlat_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hawlat_setup()
    {
        return $this->hasMany(hawlat_entry::class);
    }
}
