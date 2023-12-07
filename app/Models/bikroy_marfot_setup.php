<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ponno_sales_info;

class bikroy_marfot_setup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ponno_sales_info()
    {
        return $this->hasMany(ponno_sales_info::class,'marfot_id');
    }
}
