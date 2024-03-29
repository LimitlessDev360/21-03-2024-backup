<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverymanAmountRequest extends Model
{
    use HasFactory;
    protected $table = 'deliveryman_amount_requests';
    protected $fillable = ['name', 'deiveryman_id','requested_amount','paid_amount','remaining_amount','status'];
}
