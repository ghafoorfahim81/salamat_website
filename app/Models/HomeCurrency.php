<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCurrency extends Model
{
    use HasFactory, Uuids;

    protected $table = "home_currencies";

    protected $fillable = [
        'currency_id',
        'code',
        'symbol',
        'exchange_rate',
        'company_id'
    ];
}
