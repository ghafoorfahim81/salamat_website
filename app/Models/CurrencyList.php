<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyList extends Model
{
    use HasFactory, Uuids;

    protected $table = "currency_lists";

    protected $fillable = [
        'name',
        'symbol',
        'code',
        'format',
        'flag',
        'exchange_rate'
    ];

}
