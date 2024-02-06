<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;


class Transaction extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
           'account_id',
           'organization_id',
            'amount',
            'currency',
            'rate',
            'date',
            'account_name',
            'type',
            'discount',
            'remark',
            'user_id',
            'company_id',
            'location_id'
    ];
}
