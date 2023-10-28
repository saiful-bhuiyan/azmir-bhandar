<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\amanot_entry;

class amanot_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function amanot_entry()
    {
        return $this->hasMany(amanot_entry::class);
    }
}
