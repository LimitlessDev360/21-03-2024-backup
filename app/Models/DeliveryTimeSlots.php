<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTimeSlots extends Model
{
    use HasFactory;

    protected $fillable = ['start_time', 'end_time'];
    protected $table = 'delivey_time_slots';
}
