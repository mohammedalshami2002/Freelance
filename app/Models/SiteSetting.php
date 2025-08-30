<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable =[

        'withdrawal_account_number',
        'commission_percentage',
        'minimum_withdrawal_amount',
        'transaction_fee',
        
    ];

}
