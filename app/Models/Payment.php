<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'account_payment';
    public $timestamps = false;
    
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'LastUpdate';
    
    protected $fillable = [
        'accounts_id',
        'invoice_no',
        'pay_mode',
        'amount',
        'entry_date',
        'remarks',
        'CreateDate',
        'LastUpdate'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'CreateDate' => 'datetime',
        'LastUpdate' => 'datetime',
    ];
}
