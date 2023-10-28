<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\bank_setup;
use App\Models\check_book_page_setup;

class bank_entry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function check_book_page_setup()
    {
        return $this->belongsTo(check_book_page_setup::class, 'check_id')->withTrashed();
    }

    public function bank_setup()
    {
        return $this->belongsTo(bank_setup::class);
    }
}
