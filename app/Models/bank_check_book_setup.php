<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\bank_setup;
use App\Models\check_book_page_setup;

class bank_check_book_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bank_setup()
    {
        return $this->belongsTo(bank_setup::class);
    }

    public function check_book_page_setup()
    {
        return $this->hasMany(check_book_page_setup::class);
    }
}
