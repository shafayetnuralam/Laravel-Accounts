<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts_setup';
    public $timestamps = false;
    
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'LastUpdate';
    
    protected $fillable = [
        'accounts_name',
        'sector_name',
        'mobile_no',
        'credit_limit',
        'category',
        'opening_balance',
        'CreateDate',
        'LastUpdate',
        'Status'
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'CreateDate' => 'datetime',
        'LastUpdate' => 'datetime',
    ];
}
