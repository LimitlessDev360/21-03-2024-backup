<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverymanBankDetail extends Model
{
    use HasFactory;
    protected $table = 'deliveryman_bank_details';

    protected $fillable = [
        'deliveryman_id',
        'deliveryman_name',
        'deliveryman_phone',
        'account_holder_name',
        'bank_name',
        'ifsc_code',
        'account_number',
        'confirm_account_number',
        'account_type',
        'is_active'
    ];
}
